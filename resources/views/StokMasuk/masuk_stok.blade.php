@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Masuk Stok</h2>
        {{-- Tombol Tambah Stok yang sekarang mengarah ke rute /tambah-stok --}}
        <button onclick="window.location.href='{{ url('/tambah-stok;" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-300 flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Stok
        </button>
    </div>

    {{-- Filter dan Tabel Daftar Masuk --}}
    <div class="bg-white p-6 rounded-lg shadow-sm">
        {{-- Area Filter --}}
        <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
            <div class="relative w-full md:w-1/3">
                <input type="text" placeholder="Cari..." class="w-full p-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-orange-dark">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative w-full md:w-auto flex items-center">
                <input type="text" value="01 Mei 2025 - 31 Mei 2025" class="w-full p-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-orange-dark">
                <i class="fa-solid fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        {{-- Tabel Daftar Masuk --}}
        <div class="overflow-x-auto">
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
                    {{-- Contoh baris data, ulangi ini untuk setiap item masuk stok --}}
                    @for ($i = 0; $i < 5; $i++)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ date('d M Y', strtotime('-' . $i . ' days')) }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Produk Masuk {{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ ['Makanan Ringan', 'Minuman', 'Dessert'][$i % 3] }}</td>
                        <td class="px-4 py-3 text-right">{{ rand(10, 50) }}</td>
                        <td class="px-4 py-3 text-right">{{ rand(50, 200) }}</td>
                        <td class="px-4 py-3">{{ ['Pieces', 'Boxes', 'Pcs'][$i % 3] }}</td>
                    </tr>
                    @endfor
                    {{-- Akhir contoh baris data --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
