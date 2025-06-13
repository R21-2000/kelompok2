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
    public function index(Request $request)
    {
        // Filter tanggal dari request jika ada
        $start = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        // Stok terendah
        $stokTerendah = Stok::with('produk')
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // Jumlah transaksi
        $jumlahTransaksi = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])->count();

        // Total produk terjual
        $produkTerjual = PenjualanDetail::whereHas('penjualan', function ($q) use ($start, $end) {
            $q->whereBetween('tanggal_penjualan', [$start, $end]);
        })->sum('qty');

        // Total pendapatan (penjualan yang sudah dibayar)
        $totalPendapatan = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])
            ->whereNotNull('waktu_bayar')
            ->with('penjualanDetails')
            ->get()
            ->flatMap->details
            ->sum('subtotal');

        // Penjualan terbayar
        $penjualanTerbayar = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])
            ->whereNotNull('waktu_bayar')
            ->count();

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
