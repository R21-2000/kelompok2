<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/stok/masuk', [StokController::class, 'masuk'])->name('stok.masuk');
Route::get('/stok/tambah', [StokController::class, 'create'])->name('stok.create');
Route::post('/stok', [StokController::class, 'store'])->name('stok.store');
Route::get('/stok/opname', [StokController::class, 'opname'])->name('stok.opname');
Route::put('/stok/{id}', [StokController::class, 'update'])->name('stok.update');
Route::delete('/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');

Route::get('/kasir', [PenjualanController::class, 'kasir'])->name('kasir');
Route::get('/laporan', [PenjualanController::class, 'laporan'])->name('laporan');
Route::get('/laporan/filter', [PenjualanController::class, 'filterLaporan'])->name('laporan.filter');
