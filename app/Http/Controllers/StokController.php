<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;

/**
 * StokController handles the management of stock resources.
 */
class StokController
{
    /**
     * Display a listing of the resource.
     */
    public function daftar() {
    return view('OpnameStok.daftar_stok');
}

    public function index()
    {
        $stoks = Stok::with('produk')->get();
        return view('stok.masuk', compact('stoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::with('satuan')->get();
        return view('stok.tambah', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric'
        ]);

        $existing = Stok::where('produk_id', $request->produk_id)->first();

        if ($existing) {
            $existing->jumlah += $request->jumlah;
            $existing->save();
        } else {
            Stok::create($request->only(['produk_id', 'jumlah']));
        }

        return redirect()->route('stok.index');
    }

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
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        return view('stok.edit', compact('stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stok $stok)
    {
         $stok->update($request->only(['jumlah']));
        return redirect()->route('stok.list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
         $stok->delete();
        return back();
    }
    public function masuk() {
        return $this->index();
    }
    public function opname() {
    $stoks = Stok::with('produk')->get();
    return view('OpnameStok.opname_stok', compact('stoks'));
}



}
