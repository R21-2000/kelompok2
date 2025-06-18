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
            <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        {{-- Card Transaksi --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-sm font-semibold text-gray-500">Jumlah Transaksi</h3>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $jumlahTransaksi }}</p>
            <h3 class="text-sm font-semibold text-gray-500 mt-3">Produk Terjual</h3>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $produkTerjual }}</p>
        </div>
    </div>

    {{-- Chart dan Stok Terendah --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart Penjualan --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Chart Penjualan</h3>
            <div class="h-80 bg-gray-100 rounded-md flex items-center justify-center">
                <canvas id="chartPenjualan" class="w-full h-full"></canvas>
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
                    @foreach ($stokTerendah as $stok)
                        @php
                            $warna = 'text-gray-700';
                            if ($stok->stok <= 3) $warna = 'text-red-600';
                            elseif ($stok->stok <= 5) $warna = 'text-orange-500';
                            elseif ($stok->stok <= 10) $warna = 'text-yellow-500';
                        @endphp
                        <tr class="bg-white border-b">
                            <td class="px-4 py-3 font-medium">{{ $stok->produk->nama_produk ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-bold {{ $warna }}">{{ $stok->stok }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const canvas = document.getElementById('chartPenjualan');
    if (canvas) {
        const ctx = canvas.getContext('2d');

        const labels = @json($penjualanHarian->pluck('tanggal'));
        const data = @json($penjualanHarian->pluck('total'));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>

@endsection
