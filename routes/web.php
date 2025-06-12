<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController; // Pastikan Anda mengimpor controller Anda

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/kasir', function () {
    return view('kasir');
});

Route::get('/laporan-transaksi', function () {
    return view('laporan_transaksi');
});

Route::get('/masuk-stok', function () {
    return view('StokMasuk.masuk_stok');
});

Route::get('/tambah-stok', function () {
    return view('StokMasuk.tambah_stok');
});

Route::get('/daftar-stok', function () {
    return view('OpnameStok.daftar_stok');
});

Route::get('/opname-stok', function () {
    return view('OpnameStok.opname_stok');
});

// Route BARU untuk halaman produk (menampilkan daftar produk)
Route::get('/produk', function () {
    return view('produk.index');
})->name('produk.index'); // Memberi nama rute untuk memudahkan

// Route untuk menampilkan form tambah produk
Route::get('/tambah-produk', function () {
    return view('produk.create');
})->name('produk.create'); // Memberi nama rute untuk memudahkan

// Rute BARU: untuk memproses data dari form 'Tambah Produk' (metode POST)
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');