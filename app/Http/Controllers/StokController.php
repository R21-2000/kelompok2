<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;

/**
 * Controller untuk manajemen stok.
 */
class StokController
{
     /**
     * Tampilkan halaman daftar stok opname.
     */
    public function daftar() {
    return view('OpnameStok.daftar_stok');
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
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric'
        ]);

        $existing = Stok::where('produk_id', $request->produk_id)->first();

        if ($existing) {
            // Jika stok produk sudah ada, tambahkan jumlahnya
            $existing->jumlah += $request->jumlah;
            $existing->save();
        } else {
            // Jika belum ada, buat stok baru
            Stok::create($request->only(['produk_id', 'jumlah']));
        }

        return redirect()->route('stok.index');
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
