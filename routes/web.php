<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Di aplikasi nyata, Anda akan mengambil data dari database di sini
    // dan mengirimkannya ke view.
    // contoh: $totalPendapatan = Order::sum('total');
    return view('dashboard');
});

// Route BARU untuk halaman produk
Route::get('/produk', function () {
    // Di aplikasi nyata, Anda akan mengambil data dari model Product
    // $products = Product::latest()->get();
    // return view('produk.index', compact('products'));

    return view('produk.index'); // Untuk sekarang, kita hanya tampilkan view-nya
});

Route::get('/laporan', function () {
    // Di aplikasi nyata, Anda akan mengambil data dari model Product
    // $products = Product::latest()->get();
    // return view('produk.index', compact('products'));

    return view('laporan.index'); // Untuk sekarang, kita hanya tampilkan view-nya
});

Route::get('/tambah-produk', function () {
    // Di aplikasi nyata, Anda akan mengambil data dari model Product
    // $products = Product::latest()->get();
    // return view('produk.index', compact('products'));

    return view('produk.create'); // Untuk sekarang, kita hanya tampilkan view-nya
});