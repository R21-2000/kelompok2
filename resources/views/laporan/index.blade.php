@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('header_title', 'Laporan')

@section('content')
    {{-- Header Konten & Filter --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Laporan</h2>
            <p class="text-sm text-gray-500 mt-1">01 Mei 2025 - 31 Mei 2025</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg flex items-center">
                <i class="fa-solid fa-filter mr-2 text-gray-500"></i>
                <span>Filter</span>
            </button>
            <button class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-lg flex items-center">
                {{-- Ikon download lebih cocok untuk ekspor, namun saya sesuaikan dengan gambar --}}
                <i class="fa-solid fa-plus mr-2"></i>
                <span>Ekspor Laporan</span>
            </button>
        </div>
    </div>

    {{-- Kartu Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm border">
            <h3 class="text-sm font-semibold text-gray-500">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format(400000000, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border">
            <h3 class="text-sm font-semibold text-gray-500">Penjualan Terbayar</h3>
            <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format(10000000, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border">
            <h3 class="text-sm font-semibold text-gray-500">Penjualan Belum Dibayar</h3>
            <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format(10000000, 2, ',', '.') }}</p>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-800 uppercase bg-[#FDEBDD]">
                    <tr>
                        <th scope="col" class="px-6 py-3">No Transaksi</th>
                        <th scope="col" class="px-6 py-3">Waktu Order</th>
                        <th scope="col" class="px-6 py-3">Waktu Bayar</th>
                        <th scope="col" class="px-6 py-3">Total Penjualan</th>
                        <th scope="col" class="px-6 py-3">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-3">Operator Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis sesuai gambar --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">TR/250501/1</td>
                        <td class="px-6 py-4">1 Mei 2025, 13:27</td>
                        <td class="px-6 py-4">1 Mei 2025, 14:30</td>
                        <td class="px-6 py-4">Rp.1.200.000,00</td>
                        <td class="px-6 py-4">Bank Transfer, BCA</td>
                        <td class="px-6 py-4">Anak Sigma</td>
                        <td class="px-6 py-4">Ucup</td>
                    </tr>

                    {{-- Contoh loop data dari controller --}}
                    {{--
                    @forelse ($laporan as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->no_transaksi }}</td>
                            <td class="px-6 py-4">{{ $item->waktu_order }}</td>
                            <td class="px-6 py-4">{{ $item->waktu_bayar }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->total, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $item->metode_pembayaran }}</td>
                            <td class="px-6 py-4">{{ $item->nama_pelanggan }}</td>
                            <td class="px-6 py-4">{{ $item->operator }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-10">
                                Tidak ada data untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                    --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
