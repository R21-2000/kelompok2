@extends('layouts.app')

@section('title', 'Satuan')
@section('header_title', 'Satuan')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Tambah Satuan Baru</h2>
        <a href="{{ route('satuan.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Formulir dihubungkan ke route 'satuan.store' dengan metode POST --}}
    <form action="{{ route('satuan.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
        @csrf {{-- Token CSRF untuk keamanan --}}

        <div class="mb-6">
            <label for="nama_satuan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Satuan</label>
            <input type="text" name="nama_satuan" id="nama_satuan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Contoh: Pcs, Cup, Botol" required>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 mt-6 pt-4 border-t">
            <a href="{{ route('satuan.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Batal
            </a>
            <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Simpan
            </button>
        </div>
    </form>
@endsection
