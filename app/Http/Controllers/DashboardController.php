<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan data ringkasan di dashboard.
     */
    public function index(Request $request)
    {
        // Ambil tanggal awal & akhir dari input, default ke awal & akhir bulan ini
        $start = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        // Ambil tanggal awal & akhir dari input, default ke awal & akhir bulan ini
        $stokTerendah = Stok::with('produk')
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // Hitung jumlah transaksi pada periode ini
        $jumlahTransaksi = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])->count();

        // Hitung total produk terjual
        $produkTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($start, $end) {
            $q->whereBetween('tanggal_penjualan', [$start, $end]);
        })->sum('qty');

        // Hitung total pendapatan dari penjualan terbayar
        $totalPendapatan = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])
            ->whereNotNull('waktu_bayar')
            ->with('penjualanDetails')
            ->get()
            ->flatMap->details
            ->sum('subtotal');

        // Hitung jumlah penjualan yang sudah dibayar
        $penjualanTerbayar = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])
            ->whereNotNull('waktu_bayar')
            ->count();


        // Kirim semua data ke view dashboard
        return view('dashboard.index', [
            'stokTerendah' => $stokTerendah,
            'jumlahTransaksi' => $jumlahTransaksi,
            'produkTerjual' => $produkTerjual,
            'totalPendapatan' => $totalPendapatan,
            'penjualanTerbayar' => $penjualanTerbayar,
            'start' => $start,
            'end' => $end,
        ]);
    }
}
