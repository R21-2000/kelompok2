@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('header_title', 'Produk')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

    {{-- Header Form --}}
    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Produk</h2>
        {{-- Tombol X untuk kembali ke halaman produk --}}
        <a href="{{ route('produk.index') }}" class="w-10 h-10 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors">
            <i class="fa-solid fa-times text-xl"></i>
        </a>
    </div>

    {{-- Form Tambah Produk --}}
    {{-- Aksi form akan diarahkan ke route 'produk.store' yang akan kita buat nanti --}}
    <form action="{{ route('produk.store') }}" method="POST" class="mt-6">
        @csrf {{-- Token keamanan wajib di Laravel --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
            {{-- Input Nama Produk --}}
            <label for="nama_produk" class="text-sm font-medium text-gray-700 self-center">Nama Produk</label>
            <div class="md:col-span-2">
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Contoh: Roti Coklat" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-brand-orange focus:border-brand-orange">
            </div>

            {{-- Input Jenis --}}
            <label for="jenis" class="text-sm font-medium text-gray-700 self-center">Jenis</label>
            <div class="md:col-span-2">
                <input type="text" name="jenis" id="jenis" placeholder="Contoh: Makanan Berat" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-brand-orange focus:border-brand-orange">
            </div>

            {{-- Input SKU --}}
            <label for="sku" class="text-sm font-medium text-gray-700 self-center">SKU</label>
            <div class="md:col-span-2">
                <input type="text" name="sku" id="sku" placeholder="Contoh: MK01" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-brand-orange focus:border-brand-orange">
            </div>

            {{-- Input Harga Satuan --}}
            <label for="harga_satuan" class="text-sm font-medium text-gray-700 self-center">Harga Satuan</label>
            <div class="md:col-span-2">
                <input type="number" name="harga_satuan" id="harga_satuan" placeholder="Contoh: 10000" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-brand-orange focus:border-brand-orange">
            </div>

            {{-- Input Satuan --}}
            <label for="satuan" class="text-sm font-medium text-gray-700 self-center">Satuan</label>
            <div class="md:col-span-2">
                <input type="text" name="satuan" id="satuan" placeholder="Contoh: Pieces" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-brand-orange focus:border-brand-orange">
            </div>
        </div>

        {{-- Tabel Preview (Opsional) --}}
        {{-- Di aplikasi nyata, tabel ini bisa diisi otomatis menggunakan JavaScript saat form diisi --}}
        <div class="mt-8">
            <p class="text-sm text-gray-600 mb-2">Preview Data</p>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-800 uppercase bg-[#FDEBDD]">
                        <tr>
                            <th scope="col" class="px-6 py-3">SKU</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Jenis</th>
                            <th scope="col" class="px-6 py-3">Harga Satuan</th>
                            <th scope="col" class="px-6 py-3">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border">
                            <td class="px-6 py-4 text-center text-gray-400">-</td>
                            <td class="px-6 py-4 text-center text-gray-400">-</td>
                            <td class="px-6 py-4 text-center text-gray-400">-</td>
                            <td class="px-6 py-4 text-center text-gray-400">-</td>
                            <td class="px-6 py-4 text-center text-gray-400">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Tombol Aksi --}}
        <div class="flex justify-end items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('produk.index') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md shadow-sm">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
