@extends('layouts.app')

@section('title', 'Stok')
@section('header_title', 'Stok')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Tambah Stok Masuk</h2>
        {{-- Tombol untuk kembali ke halaman daftar stok --}}
        <a href="{{ url('/daftar-stok') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Formulir dihubungkan ke route 'stok.store' dengan metode POST --}}
    <form action="{{ route('stok.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
        @csrf {{-- Token CSRF wajib untuk keamanan --}}

        {{-- Menampilkan error validasi jika ada --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Dropdown untuk memilih produk --}}
            <div class="md:col-span-2">
                <label for="produk_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Produk</label>
                {{-- Dropdown ini akan diisi oleh variabel $produks dari StokController@create --}}
                <select name="produk_id" id="produk_id" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" required>
                    <option value="">-- Pilih Produk yang Akan Ditambah Stoknya --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->nama_produk }} (SKU: {{ $produk->sku }})</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Input untuk jumlah stok yang ditambahkan --}}
            <div class="md:col-span-2">
                <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Stok yang Ditambahkan</label>
                {{-- Nama input "jumlah" sesuai dengan yang dibutuhkan oleh StokController@store --}}
                <input type="number" name="jumlah" id="jumlah" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Contoh: 10" required min="1">
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ url('/daftar-stok') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Batal
            </a>
            <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Simpan
            </button>
        </div>
    </form>
@endsection