@extends('layouts.app')
@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
        <div class="flex items-center gap-2">
            <div class="flex bg-white border border-gray-300 rounded-md">
                <button class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-l-md">Harian</button>
                <button class="px-4 py-2 text-sm font-semibold text-gray-500 hover:bg-gray-50">Mingguan</button>
                <button class="px-4 py-2 text-sm font-semibold text-gray-500 hover:bg-gray-50 rounded-r-md">Bulan</button>
            </div>
            <div class="flex items-center bg-white border border-gray-300 rounded-md px-3 py-2 text-sm">
                <i class="fa-solid fa-chevron-left text-gray-400 cursor-pointer"></i>
                <span class="mx-3 font-semibold text-gray-700">24 Mei 25 - 25 Mei 25</span>
                <i class="fa-solid fa-chevron-right text-gray-400 cursor-pointer"></i>
            </div>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        {{-- Card Total Pendapatan --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-sm font-semibold text-gray-500">Total Pendapatan</h3>
            <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format(1000000, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-2">Akumulasi dari Awal Berdiri Sistem: Rp {{ number_format(400000000, 0, ',', '.') }}</p>
        </div>
        {{-- Card Penjualan --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-sm font-semibold text-gray-500">Penjualan Belum Dibayar</h3>
            <p class="text-xl font-bold text-red-600 mt-1">Rp {{ number_format(10000000, 0, ',', '.') }}</p>
            <h3 class="text-sm font-semibold text-gray-500 mt-3">Penjualan Terbayar</h3>
            <p class="text-xl font-bold text-green-600 mt-1">Rp {{ number_format(10000000, 0, ',', '.') }}</p>
        </div>
        {{-- Card Transaksi --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-sm font-semibold text-gray-500">Jumlah Transaksi</h3>
            <p class="text-3xl font-bold text-gray-800 mt-1">13</p>
            <h3 class="text-sm font-semibold text-gray-500 mt-3">Produk Terjual</h3>
            <p class="text-3xl font-bold text-gray-800 mt-1">46</p>
        </div>
    </div>

    {{-- Chart dan Stok Terendah --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart Penjualan --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Chart Penjualan</h3>
            <div class="h-80 bg-gray-100 rounded-md flex items-center justify-center">
                {{-- Canvas untuk Chart.js atau div untuk library lain akan diletakkan di sini --}}
                <p class="text-gray-500">Area Grafik Penjualan</p>
            </div>
        </div>

        {{-- Stok Terendah --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Stok Terendah</h3>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">Produk</th>
                        <th scope="col" class="px-4 py-3 text-right">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b">
                        <td class="px-4 py-3 font-medium">Kue Leker</td>
                        <td class="px-4 py-3 text-right font-bold text-red-600">2</td>
                    </tr>
                    <tr class="bg-white border-b">
                        <td class="px-4 py-3 font-medium">Pisang Ijo</td>
                        <td class="px-4 py-3 text-right font-bold text-orange-500">4</td>
                    </tr>
                    <tr class="bg-white">
                        <td class="px-4 py-3 font-medium">Donut</td>
                        <td class="px-4 py-3 text-right font-bold text-yellow-500">6</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
