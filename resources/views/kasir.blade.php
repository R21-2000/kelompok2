@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Kasir</h2>
    </div>

    {{-- Formulir Kasir --}}
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Kolom Kiri: Detail Produk --}}
            <div>
                <div class="mb-4">
                    <label for="no_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">No. Transaksi</label>
                    <input type="text" id="no_transaksi" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Otomatis terisi">
                </div>

                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label for="jenis_produk" class="block text-sm font-semibold text-gray-700">Jenis Produk</label>
                        <button class="flex items-center text-brand-orange-dark font-semibold text-sm">
                            <i class="fa-solid fa-plus-circle mr-1"></i> Tambah
                        </button>
                    </div>
                    {{-- Area Produk yang akan ditambahkan --}}
                    <div class="border border-gray-300 rounded-md h-64 p-2 bg-gray-100 flex items-center justify-center text-gray-500">
                        Area daftar produk yang akan ditambahkan
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Transaksi --}}
            <div>
                <div class="mb-4">
                    <label for="operator_kasir" class="block text-sm font-semibold text-gray-700 mb-2">Operator Kasir</label>
                    <input type="text" id="operator_kasir" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Nama Operator">
                </div>

                <div class="mb-4">
                    <label for="nama_pelanggan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Nama Pelanggan (Opsional)">
                </div>

                <div class="mb-4">
                    <label for="tanggal_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Transaksi</label>
                    <input type="date" id="tanggal_transaksi" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="metode_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select id="metode_pembayaran" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100">
                        <option value="">Pilih Metode</option>
                        <option value="cash">Tunai</option>
                        <option value="card">Kartu Debit/Kredit</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="total_penjualan" class="block text-sm font-semibold text-gray-700 mb-2">Total Penjualan</label>
                    <input type="text" id="total_penjualan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100 font-bold text-lg" value="Rp 0" readonly>
                </div>

                <div class="flex justify-end">
                    {{-- Tombol "Tambah Transaksi" sekarang mengarah ke rute /laporan-transaksi --}}
                    <button onclick="window.location.href='{{ url('/laporan-transaksi;" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                        Tambah Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
