@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Opname Stok</h2>
        <a href="{{ url('/daftar-stok') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Form Opname Stok --}}
    <div class="bg-white p-6 rounded-lg shadow-sm">
        {{-- Tabel Opname Stok --}}
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">SKU</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">Jenis</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Opname</th>
                        <th scope="col" class="px-4 py-3">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh baris data, ini adalah placeholder --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">MK1</td>
                        <td class="px-4 py-3">Kue Leker</td>
                        <td class="px-4 py-3">Makanan Ringan</td>
                        <td class="px-4 py-3 text-right">
                            <input type="number" value="2" class="w-20 p-1 border border-gray-300 rounded-md bg-gray-100 text-center">
                        </td>
                        <td class="px-4 py-3">Pieces</td>
                    </tr>
                    {{-- Anda bisa menambahkan lebih banyak baris di sini secara dinamis --}}
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
