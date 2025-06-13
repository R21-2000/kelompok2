@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Tambah Stok</h2>
        <a href="{{ url('/masuk-stok') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Form Tambah Stok --}}
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="nama_makanan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Makanan</label>
                <input type="text" id="nama_makanan" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Contoh: Roti Coklat">
            </div>
            <div>
                <label for="jenis" class="block text-sm font-semibold text-gray-700 mb-2">Jenis</label>
                <input type="text" id="jenis" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Contoh: Makanan Berat">
            </div>
            <div class="md:col-span-2">
                <label for="stok_tambah" class="block text-sm font-semibold text-gray-700 mb-2">Stok Tambah</label>
                <input type="number" id="stok_tambah" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="Contoh: 10">
            </div>
        </div>

        {{-- Tabel Preview Stok Masuk (jika ada) --}}
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">Tanggal</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">Jenis</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Masuk</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Akhir</th>
                        <th scope="col" class="px-4 py-3">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Baris placeholder, bisa diisi dengan data dinamis dari input form --}}
                    <tr class="bg-white border-b">
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3 text-right">-</td>
                        <td class="px-4 py-3 text-right">-</td>
                        <td class="px-4 py-3">-</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4">
            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Batal
            </button>
            <button class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                Simpan
            </button>
        </div>
    </div>
@endsection
