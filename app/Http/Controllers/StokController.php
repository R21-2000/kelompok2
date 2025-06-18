<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanDetail;
use Carbon\Carbon;

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

        $endDateInclusive = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

        // Query dasar ke semua produk
        $query = Produk::query();

        // Gunakan 'addSelect' untuk menambahkan kolom hasil kalkulasi dari subquery
        $query->addSelect([
            'total_masuk_sebelum' => Stok::query()
                ->selectRaw('COALESCE(sum(stok), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->where('created_at', '<', $startDate),

            'total_terjual_sebelum' => PenjualanDetail::query()
                ->selectRaw('COALESCE(sum(qty), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereHas('penjualan', fn($q) => $q->where('tanggal_penjualan', '<', $startDate)),
            
            'stok_masuk_periode' => Stok::query()
                ->selectRaw('COALESCE(sum(stok), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereBetween('created_at', [$startDate, $endDateInclusive]), // Gunakan di sini

            'stok_terjual_periode' => PenjualanDetail::query()
                ->selectRaw('COALESCE(sum(qty), 0)')
                ->whereColumn('produk_id', 'produks.id')
                ->whereHas('penjualan', fn($q) => $q->whereBetween('tanggal_penjualan', [$startDate, $endDate])), // Di sini tidak perlu diubah karena kolomnya adalah 'date'
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
        
        // ... (sisa kode tidak perlu diubah)
        if ($request->filled('min_stok') && $request->filled('max_stok')) {
            $laporanStok = $laporanStok->whereBetween('stok_akhir', [$request->min_stok, $request->max_stok]);
        }

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
        $produks = Produk::with('satuan')->orderBy('nama_produk')->get();
        return view('OpnameStok.opname_stok', compact('produks'));
    }

    public function storeOpname(Request $request)
    {
        $request->validate([
            'stok' => 'required|array',
            'stok.*' => 'nullable|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->stok as $produk_id => $new_stok_value) {
                    // Hanya proses jika nilainya diisi
                    if (!is_null($new_stok_value)) {
                        // 1. Hapus semua catatan stok masuk sebelumnya untuk produk ini
                        Stok::where('produk_id', $produk_id)->delete();

                        // 2. Buat satu catatan stok baru yang merepresentasikan hasil opname
                        Stok::create([
                            'produk_id' => $produk_id,
                            'stok' => $new_stok_value,
                        ]);
                    }
                }
            });

            return redirect()->route('stok.daftar')->with('success', 'Stok opname berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data opname.');
        }
    }



}
