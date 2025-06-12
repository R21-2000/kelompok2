<?php

use Illuminate\Support\Facades\Route;

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
    return view('masuk_stok');
});

Route::get('/tambah-stok', function () {
    return view('tambah_stok');
});

Route::get('/daftar-stok', function () {
    return view('daftar_stok');
});

Route::get('/opname-stok', function () {
    return view('opname_stok');
});