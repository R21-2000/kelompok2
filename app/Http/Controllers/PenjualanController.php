<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pengguna;

class PenjualanController
{
    /**
     * Tampilkan halaman kasir beserta daftar penjualan dan detailnya.
     */
    public function kasir()
    {
        $penjualans = Penjualan::with('penjualanDetails', 'pengguna')->get();
        return view('kasir', compact('penjualans'));
    }
    /**
     * Tampilkan halaman laporan transaksi penjualan.
     * Bisa difilter berdasarkan rentang tanggal.
     */
    public function laporan(Request $request)
    {
        $query = Penjualan::with(['pengguna', 'penjualanDetails']);
        // Jika filter tanggal diisi, filter data penjualan
        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
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
        //
    }

    /**
     * Display the specified resource.
     */
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

}
