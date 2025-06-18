<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController
{
    /**
     * Tampilkan halaman kasir beserta daftar penjualan dan detailnya.
     */
    public function kasir()
    {
        // Ambil semua produk untuk ditampilkan di dropdown, urutkan berdasarkan nama
        $produks = Produk::orderBy('nama_produk')->get();

        // Kirim data produks ke view kasir
        return view('kasir', compact('produks'));
    }
    /**
     * Tampilkan halaman laporan transaksi penjualan.
     * Bisa difilter berdasarkan rentang tanggal.
     */
    // app/Http/Controllers/PenjualanController.php

    public function laporan(Request $request)
    {
        // Eager load relasi yang dibutuhkan
        $query = Penjualan::with(['pengguna', 'penjualanDetails.produk']);

        // --- LOGIKA FILTER ---
        if ($request->filled('nama_pelanggan')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->nama_pelanggan . '%');
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        if ($request->filled('dari') && $request->filled('hingga')) {
            // Pastikan format tanggal benar sebelum query
            $dari = \Carbon\Carbon::parse($request->dari)->startOfDay();
            $hingga = \Carbon\Carbon::parse($request->hingga)->endOfDay();
            $query->whereBetween('waktu_bayar', [$dari, $hingga]);
        }

        // [PERBAIKAN] Blok filter Total Penjualan
        if ($request->filled('minimal') || $request->filled('maksimal')) {
            $query->whereHas('penjualanDetails', function ($q) use ($request) {
                // Kelompokkan detail berdasarkan penjualan untuk menghitung total
                $q->groupBy('penjualan_id');
                if ($request->filled('minimal')) {
                    $q->havingRaw('SUM(subtotal) >= ?', [$request->minimal]);
                }
                if ($request->filled('maksimal')) {
                    $q->havingRaw('SUM(subtotal) <= ?', [$request->maksimal]);
                }
            });
        }


        // --- [PERBAIKAN] LOGIKA SORTING ---
        $sort = $request->input('sort', 'terbaru');

        if ($sort == 'total_asc' || $sort == 'total_desc') {
            // Jika sort berdasarkan total, kita perlu join dan group
            $direction = ($sort == 'total_asc') ? 'asc' : 'desc';
            $query->select('penjualans.*', DB::raw('SUM(penjualan_details.subtotal) as total_penjualan'))
                ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
                ->groupBy('penjualans.id') // Group berdasarkan semua kolom penjualan atau ID-nya
                ->orderBy('total_penjualan', $direction);
        } else {
            // Sort berdasarkan waktu transaksi
            $direction = ($sort == 'terlama') ? 'asc' : 'desc';
            $query->orderBy('waktu_bayar', $direction);
        }

        $penjualans = $query->get();

        return view('laporan.index', compact('penjualans'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pelanggan'    => 'nullable|string|max:255',
            'metode_pembayaran' => 'required|string',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|integer|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.harga'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kasir')->withErrors($validator)->withInput();
        }

        // 2. Gunakan DB Transaction untuk memastikan semua query berhasil
        try {
            DB::beginTransaction();

            // 3. Buat record di tabel 'penjualans'
            $penjualan = Penjualan::create([
                // Buat nomor transaksi unik
                'no_transaksi' => 'TRX-' . Carbon::now()->format('YmdHis'),
                // TODO: Ganti dengan ID pengguna yang sedang login (misal: Auth::id())
                // Untuk sementara kita gunakan ID 1 karena ada di seeder
                'pengguna_id' => 1,
                'nama_pelanggan' => $request->nama_pelanggan ?? 'Walk-in',
                'tanggal_penjualan' => Carbon::now()->toDateString(),
                'waktu_bayar' => Carbon::now(), // Langsung dianggap lunas
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 4. Loop dan buat record di 'penjualan_details' untuk setiap item
            foreach ($request->items as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $item['qty'] * $item['harga'],
                ]);

                // 5. Logika pengurangan stok tidak diperlukan secara eksplisit
                // karena laporan stok sudah menghitung dari data PenjualanDetail.
            }

            DB::commit(); // Jika semua berhasil, simpan perubahan

            return redirect()->route('laporan')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua query
            // Log error jika perlu: Log::error($e->getMessage());
            return redirect()->route('kasir')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
    /**
     * Endpoint untuk filter laporan
     */
    public function filterLaporan(Request $request)
    {
    // Logika sama seperti laporan()
    return $this->laporan($request);
    }

    public function laporanTransaksi()
    {
        // Ambil semua data penjualan, urutkan dari yang terbaru
        // Eager load relasi 'details' dan 'pengguna' untuk optimasi query
        $penjualans = Penjualan::with('details', 'pengguna')->latest()->get();

        // Kirim data ke view
        return view('laporan_transaksi', compact('penjualans'));
    }

    public function eksporPdf(Request $request)
    {
        // 1. Ambil data dengan logika filter & sort yang sama persis seperti method laporan()
        // ===================================================================================
        // Inisialisasi query
        $query = Penjualan::with(['pengguna', 'penjualanDetails.produk']);

        // --- LOGIKA FILTER (Salin dari method laporan) ---
        if ($request->filled('nama_pelanggan')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->nama_pelanggan . '%');
        }

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        if ($request->filled('dari') && $request->filled('hingga')) {
            $dari = \Carbon\Carbon::parse($request->dari)->startOfDay();
            $hingga = \Carbon\Carbon::parse($request->hingga)->endOfDay();
            $query->whereBetween('waktu_bayar', [$dari, $hingga]);
        }

        if ($request->filled('minimal') || $request->filled('maksimal')) {
            $query->whereHas('penjualanDetails', function ($q) use ($request) {
                $q->groupBy('penjualan_id');
                if ($request->filled('minimal')) {
                    $q->havingRaw('SUM(subtotal) >= ?', [$request->minimal]);
                }
                if ($request->filled('maksimal')) {
                    $q->havingRaw('SUM(subtotal) <= ?', [$request->maksimal]);
                }
            });
        }

        // --- LOGIKA SORTING (Salin dari method laporan) ---
        $sort = $request->input('sort', 'terbaru');

        if ($sort == 'total_asc' || $sort == 'total_desc') {
            $direction = ($sort == 'total_asc') ? 'asc' : 'desc';
            $query->select('penjualans.*', DB::raw('SUM(penjualan_details.subtotal) as total_penjualan'))
                  ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
                  ->groupBy('penjualans.id')
                  ->orderBy('total_penjualan', $direction);
        } else {
            $direction = ($sort == 'terlama') ? 'asc' : 'desc';
            $query->orderBy('waktu_bayar', $direction);
        }

        $penjualans = $query->get();
        // ===================================================================================

        // 2. Load view khusus untuk PDF dan kirim datanya
        // Pastikan Anda sudah membuat file 'laporan.pdf_view'
        $pdf = Pdf::loadView('laporan.pdf_view', compact('penjualans'));

        // 3. Download PDF dengan nama file dinamis
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }

}
