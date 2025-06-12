<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController; // Pastikan Anda mengimpor controller Anda

Route::get('/', function () {
    return view('dashboard', ['title' => 'Dashboard', 'header_title' => 'Dashboard']);
});

Route::get('/kasir', function () {
    return view('kasir', ['title' => 'Kasir', 'header_title' => 'Kasir']);
});

Route::get('/laporan-transaksi', function () {
    return view('laporan_transaksi', ['title' => 'laporan_transaksi', 'header_title' => 'laporan_transaksi']);
});

Route::get('/masuk-stok', function () {
    return view('StokMasuk.masuk_stok', ['title' => 'masuk_stok', 'header_title' => 'masuk_stok']);
});

Route::get('/tambah-stok', function () {
    return view('StokMasuk.tambah_stok', ['title' => 'tambah_stok', 'header_title' => 'tambah_stok']);
});

Route::get('/daftar-stok', function () {
    return view('OpnameStok.daftar_stok', ['title' => 'daftar_stok', 'header_title' => 'Kasir']);
});

Route::get('/opname-stok', function () {
    return view('OpnameStok.opname_stok', ['title' => 'opname_stok', 'header_title' => 'opname_stok']);
});

// Route BARU untuk halaman produk (menampilkan daftar produk)
Route::get('/produk', function () {
    return view('produk.index', ['title' => 'produk', 'header_title' => 'produk']);
})->name('produk.index'); // Memberi nama rute untuk memudahkan

// Route untuk menampilkan form tambah produk
Route::get('/tambah-produk', function () {
    return view('produk.create', ['title' => 'Tambah-Produk', 'header_title' => 'Tambah-Produk']);
})->name('produk.create'); // Memberi nama rute untuk memudahkan

// Rute BARU: untuk memproses data dari form 'Tambah Produk' (metode POST)
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');