<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ProdukController
{
    /**
     * Tampilkan semua produk.
     */
    public function index()
    {
        $produks = Produk::with('satuan')->get();
        return view('produk.index', compact('produks'));
    }

     /**
     * Tampilkan form tambah produk.
     */
    public function create()
    {
        $satuans = Satuan::all();
        return view('produk.create', compact('satuans'));
    }
    /**
     * Simpan produk baru ke database.
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
    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Produk $produk)
    {
        $produk->load('satuan');
        return view('produk.show', compact('produk'));
    }

    /**
     * Tampilkan form edit produk.
     */

    public function edit(Produk $produk)
    {
        $satuans = Satuan::all();
        return view('produk.edit', compact('produk', 'satuans'));
    }

    /**
     * Update produk yang sudah ada.
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
     * Hapus produk.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index');
    }
}
