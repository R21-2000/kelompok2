<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ProdukController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('satuan')->get();
        return view('produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuans = Satuan::all();
        return view('produk.create', compact('satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'sku' => 'required',
            'harga_satuan' => 'required|numeric',
            'jenis' => 'required',
            'satuan_id' => 'required'
        ]);

        Produk::create($request->all());
        return redirect()->route('produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->load('satuan');
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $satuans = Satuan::all();
        return view('produk.edit', compact('produk', 'satuans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'sku' => 'required',
            'harga_satuan' => 'required|numeric',
            'jenis' => 'required',
            'satuan_id' => 'required'
        ]);

        $produk->update($request->all());
        return redirect()->route('produk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index');
    }
}
