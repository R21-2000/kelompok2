<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController; // Pastikan Anda mengimpor controller Anda

// Route::get('/', function () {
//     return view('dashboard');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/', function () {
    return view('dashboard', ['title' => 'Dashboard', 'header_title' => 'Dashboard']);
});

// Route::get('/kasir', function () {
//     return view('kasir');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/kasir', function () {
    return view('kasir', ['title' => 'Kasir', 'header_title' => 'Kasir']);
});

// Route::get('/laporan-transaksi', function () {
//     return view('laporan_transaksi');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/laporan-transaksi', function () {
    return view('laporan_transaksi', ['title' => 'Laporan Transaksi', 'header_title' => 'Laporan']);
});

// Route::get('/masuk-stok', function () {
//     return view('StokMasuk.masuk_stok');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/masuk-stok', function () {
    return view('StokMasuk.masuk_stok', ['title' => 'Masuk Stok', 'header_title' => 'Inventori']);
});

// Route::get('/tambah-stok', function () {
//     return view('StokMasuk.tambah_stok');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/tambah-stok', function () {
    return view('StokMasuk.tambah_stok', ['title' => 'Tambah Stok', 'header_title' => 'Inventori']);
});

// Route::get('/daftar-stok', function () {
//     return view('OpnameStok.daftar_stok');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/daftar-stok', function () {
    return view('OpnameStok.daftar_stok', ['title' => 'Daftar Stok', 'header_title' => 'Inventori']);
});

// Route::get('/opname-stok', function () {
//     return view('OpnameStok.opname_stok');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/opname-stok', function () {
    return view('OpnameStok.opname_stok', ['title' => 'Opname Stok', 'header_title' => 'Inventori']);
});

// Route BARU untuk halaman produk (menampilkan daftar produk)
// Route::get('/produk', function () {
//     return view('produk.index');
// })->name('produk.index');
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/produk', function () {
    return view('produk.index', ['title' => 'Daftar Produk', 'header_title' => 'Produk']);
})->name('produk.index');

// Route untuk menampilkan form tambah produk
// Route::get('/tambah-produk', function () {
//     return view('produk.create');
// })->name('produk.create');
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/tambah-produk', function () {
    return view('produk.create', ['title' => 'Tambah Produk', 'header_title' => 'Produk']);
})->name('produk.create');

// Route::get('/laporan', function () {
//     return view('laporan.index');
// });
// Mengganti dengan pengiriman variabel title dan header_title
Route::get('/laporan', function () {
    return view('laporan.index', ['title' => 'Laporan', 'header_title' => 'Laporan']);
});

// Rute BARU: untuk memproses data dari form 'Tambah Produk' (metode POST)
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');