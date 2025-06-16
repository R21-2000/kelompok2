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
    public function index(Request $request)
    {
        // Mulai query ke model Produk
        $query = Produk::query();

        // 1. Logika untuk PENCARIAN
        // Jika ada input 'search' di URL
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            // Cari berdasarkan nama_produk ATAU sku
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_produk', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // 2. Logika untuk PENGURUTAN
        // Jika ada input 'sort' di URL
        if ($request->filled('sort')) {
            $sortOption = $request->input('sort');
            switch ($sortOption) {
                case 'nama_asc':
                    $query->orderBy('nama_produk', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama_produk', 'desc');
                    break;
                case 'harga_asc':
                    $query->orderBy('harga_satuan', 'asc');
                    break;
                case 'harga_desc':
                    $query->orderBy('harga_satuan', 'desc');
                    break;
            }
        } else {
            // Urutan default jika tidak ada pilihan sort
            $query->orderBy('created_at', 'desc');
        }

        // Ambil hasil query, jangan lupa relasi 'satuan'
        $produks = $query->with('satuan')->get();

        // Kirim data produk yang sudah difilter/diurutkan ke view
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
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
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
