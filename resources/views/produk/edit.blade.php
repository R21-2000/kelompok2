@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Edit Produk</h2>
        <a href="{{ route('produk.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Formulir dihubungkan ke route 'produk.update' dengan metode PUT --}}
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT') {{-- Metode PUT untuk proses update --}}

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Input Nama Produk, diisi dengan data lama --}}
            <div class="md:col-span-1">
                <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
            </div>

            {{-- Input SKU, diisi dengan data lama --}}
            <div class="md:col-span-1">
                <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">SKU (Kode Unik Produk)</label>
                <input type="text" name="sku" id="sku" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" value="{{ old('sku', $produk->sku) }}" required>
            </div>

            {{-- Input Jenis, diisi dengan data lama --}}
            <div class="md:col-span-1">
                <label for="jenis" class="block text-sm font-semibold text-gray-700 mb-2">Jenis</label>
                <input type="text" name="jenis" id="jenis" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" value="{{ old('jenis', $produk->jenis) }}" required>
            </div>

            {{-- Dropdown Satuan, dipilih berdasarkan data lama --}}
            <div class="md:col-span-1">
                <label for="satuan_id" class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                <select name="satuan_id" id="satuan_id" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" required>
                    <option value="">Pilih Satuan</option>
                    @foreach($satuans as $satuan)
                        <option value="{{ $satuan->id }}" {{ old('satuan_id', $produk->satuan_id) == $satuan->id ? 'selected' : '' }}>
                            {{ $satuan->nama_satuan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Input Harga Satuan, diisi dengan data lama --}}
            <div class="md:col-span-2">
                <label for="harga_satuan" class="block text-sm font-semibold text-gray-700 mb-2">Harga Satuan</label>
                <input type="number" name="harga_satuan" id="harga_satuan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" value="{{ old('harga_satuan', $produk->harga_satuan) }}" required>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 mt-6 pt-4 border-t">
            <a href="{{ route('produk.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Batal
            </a>
            <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Update
            </button>
        </div>
    </form>
@endsection