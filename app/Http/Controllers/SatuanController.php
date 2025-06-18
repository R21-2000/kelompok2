<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController
{
    /**
     * Menampilkan daftar semua satuan.
     * Fungsi ini akan dipanggil saat Anda membuka menu Satuan.
     */
    public function index()
    {
        // 1. Ambil semua data dari model Satuan
        $satuans = Satuan::all();

        // 2. Tampilkan view 'satuan.index' dan kirim data $satuans ke dalamnya
        return view('satuan.index', compact('satuans'));
    }

    /**
     * Menampilkan formulir untuk membuat satuan baru.
     * Fungsi ini akan dipanggil saat Anda klik tombol "+ Tambah Satuan".
     */
    public function create()
    {
        // Cukup tampilkan view 'satuan.create' yang berisi form
        return view('satuan.create');
    }

    /**
     * Menyimpan satuan baru ke dalam database.
     * Fungsi ini akan dipanggil saat Anda klik "Simpan" pada form tambah satuan.
     */
    public function store(Request $request)
    {
        // 1. Validasi input: pastikan 'nama_satuan' diisi dan unik (tidak boleh sama)
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan'
        ]);

        // 2. Buat data baru di database menggunakan model Satuan
        Satuan::create([
            'nama_satuan' => $request->nama_satuan,
        ]);

        // 3. Alihkan kembali ke halaman daftar satuan dengan pesan sukses
        return redirect()->route('satuan.index')->with('success', 'Satuan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        // Untuk saat ini tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        return view('satuan.edit', compact('satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        // 1. Validasi input: pastikan 'nama_satuan' diisi dan unik (tidak boleh sama)
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan,' . $satuan->id
        ]);

        // 2. Update data di database menggunakan model Satuan
        $satuan->update([
            'nama_satuan' => $request->nama_satuan,
        ]);

        // 3. Alihkan kembali ke halaman daftar satuan dengan pesan sukses
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus!');
    }
}
