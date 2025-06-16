<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;

/**
 * Controller untuk manajemen stok.
 */
class StokController
{
    public function daftarStok(Request $request)
    {
        // Tentukan rentang tanggal. Defaultnya adalah 1 Juni 2025 sampai hari ini.
        $startDate = $request->input('start_date', '2025-06-01');
        $endDate = $request->input('end_date', now()->toDateString());

        // Query dasar ke semua produk
        $query = Produk::query();

        // Gunakan 'addSelect' untuk menambahkan kolom hasil kalkulasi dari subquery
        $query->addSelect([
            // Hitung total stok masuk SEBELUM tanggal mulai (untuk Stok Awal)
            'total_masuk_sebelum' => Stok::query()
                ->selectRaw('ifnull(sum(stok), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->where('created_at', '<', $startDate),

            // Hitung total stok terjual SEBELUM tanggal mulai (untuk Stok Awal)
            'total_terjual_sebelum' => PenjualanDetail::query()
                ->selectRaw('ifnull(sum(qty), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereHas('penjualan', fn($q) => $q->where('tanggal_penjualan', '<', $startDate)),
            
            // Hitung stok masuk SELAMA periode tanggal yang dipilih
            'stok_masuk_periode' => Stok::query()
                ->selectRaw('ifnull(sum(stok), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereBetween('created_at', [$startDate, $endDate]),

            // Hitung stok terjual SELAMA periode tanggal yang dipilih
            'stok_terjual_periode' => PenjualanDetail::query()
                ->selectRaw('ifnull(sum(qty), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereHas('penjualan', fn($q) => $q->whereBetween('tanggal_penjualan', [$startDate, $endDate])),
        ]);

        // Ambil data produk beserta relasi dan hasil kalkulasi
        $laporanStok = $query->with('satuan')->get()->map(function ($item) {
            // Lakukan kalkulasi final di sini
            $item->stok_awal = $item->total_masuk_sebelum - $item->total_terjual_sebelum;
            $item->stok_akhir = $item->stok_awal + $item->stok_masuk_periode - $item->stok_terjual_periode;
            $item->stok_opname = 0; // Placeholder
            return $item;
        });

        // --- Filter Lanjutan (setelah semua data dihitung) ---

        // Filter berdasarkan rentang jumlah stok akhir
        if ($request->filled('min_stok') && $request->filled('max_stok')) {
            $laporanStok = $laporanStok->whereBetween('stok_akhir', [$request->min_stok, $request->max_stok]);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $laporanStok = $laporanStok->filter(
                fn($item) => str_contains(strtolower($item->nama_produk), $searchTerm) || str_contains(strtolower($item->sku), $searchTerm)
            );
        }
        
        return view('OpnameStok.daftar_stok', [
            'laporanStok' => $laporanStok,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Tampilkan semua stok masuk.
     */
    public function index()
    {
        $stoks = Stok::with('produk')->get();
        return view('stok.masuk', compact('stoks'));
    }

    /**
     * Tampilkan form tambah stok baru.
     */
    public function create()
    {
        $produks = Produk::with('satuan')->get();
        return view('stok.tambah', compact('produks'));
    }

    /**
     * Simpan stok baru atau update jika sudah ada.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|numeric|min:1'
        ]);

        // 2. Selalu buat catatan stok baru untuk setiap penambahan.
        // Ini PENTING agar riwayat stok masuk tercatat.
        Stok::create([
            'produk_id' => $request->produk_id,
            'stok' => $request->jumlah
        ]);

        // 3. Alihkan kembali ke halaman daftar stok dengan pesan sukses
        return redirect()->route('stok.daftar')->with('success', 'Stok berhasil ditambahkan!');
    }
    /**
     * Tampilkan daftar stok (bisa filter min & max jumlah).
     */
    public function list(Request $request)
    {
        $query = Stok::with('produk');
        if ($request->filled(['min', 'max'])) {
            $query->whereBetween('jumlah', [$request->min, $request->max]);
        }
        $stoks = $query->get();
        return view('stok.daftar', compact('stoks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Stok $stok)
    {
        //
    }

    /**
     * Tampilkan form edit stok.
     */
    public function edit(Stok $stok)
    {
        return view('stok.edit', compact('stok'));
    }

    /**
     * Update jumlah stok.
     */
    public function update(Request $request, Stok $stok)
    {
         $stok->update($request->only(['jumlah']));
        return redirect()->route('stok.list');
    }

    /**
     * Hapus stok.
     */
    public function destroy(Stok $stok)
    {
         $stok->delete();
        return back();
    }
    /**
     * Shortcut ke index() untuk stok masuk.
     */
    public function masuk() {
        return $this->index();
    }
    /**
     * Tampilkan halaman stok opname.
     */
    public function opname() {
    $stoks = Stok::with('produk')->get();
    return view('OpnameStok.opname_stok', compact('stoks'));
}



}
