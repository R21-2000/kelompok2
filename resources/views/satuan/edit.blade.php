@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Edit Satuan</h2>
        <a href="{{ route('satuan.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Formulir dihubungkan ke route 'satuan.update' dengan metode PUT --}}
    <form action="{{ route('satuan.update', $satuan->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        {{-- Blok untuk menampilkan error validasi --}}
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

        {{-- Input Nama Satuan, diisi dengan data lama --}}
        <div class="mb-6">
            <label for="nama_satuan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Satuan</label>
            <input type="text" name="nama_satuan" id="nama_satuan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" value="{{ old('nama_satuan', $satuan->nama_satuan) }}" required>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 mt-6 pt-4 border-t">
            <a href="{{ route('satuan.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Batal
            </a>
            <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Update
            </button>
        </div>
    </form>
@endsection
