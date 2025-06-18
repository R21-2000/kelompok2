<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan data ringkasan di dashboard.
     */
    public function index()
    {
        // Tanggal default: 7 hari terakhir dari hari ini
        $start = Carbon::now()->subDays(6)->toDateString();
        $end = Carbon::now()->toDateString();

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

        // Total pendapatan terbayar
        $totalPendapatan = PenjualanDetail::whereHas('penjualan', function ($q) use ($start, $end) {
            $q->whereBetween('tanggal_penjualan', [$start, $end])
              ->whereNotNull('waktu_bayar');
        })->sum('subtotal');

        // Penjualan terbayar
        $penjualanTerbayar = Penjualan::whereBetween('tanggal_penjualan', [$start, $end])
            ->whereNotNull('waktu_bayar')
            ->count();

        // Penjualan harian (7 hari terakhir)
        $penjualanHarian = PenjualanDetail::select(
                DB::raw('DATE(penjualans.tanggal_penjualan) as tanggal'),
                DB::raw('SUM(penjualan_details.subtotal) as total')
            )
            ->join('penjualans', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->whereBetween('penjualans.tanggal_penjualan', [$start, $end])
            ->whereNotNull('penjualans.waktu_bayar')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Kirim ke view
        return view('dashboard.index', [
            'stokTerendah' => $stokTerendah,
            'jumlahTransaksi' => $jumlahTransaksi,
            'produkTerjual' => $produkTerjual,
            'totalPendapatan' => $totalPendapatan,
            'penjualanTerbayar' => $penjualanTerbayar,
            'penjualanHarian' => $penjualanHarian,
        ]);
    }
}
