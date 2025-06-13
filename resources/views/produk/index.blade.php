@extends('layouts.app')

{{-- Mengatur judul halaman untuk tag <title> --}}
@section('title', 'Daftar Produk')

{{-- Mengatur judul yang akan tampil di header oranye --}}
@section('header_title', 'Produk')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800 self-start md:self-center">Daftar Produk</h2>
        <a href="{{ route('produk.create') }}" class="w-full md:w-auto bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center">
        <i class="fa-solid fa-plus mr-2"></i>
        <span>Tambah Produk</span>
</a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center">
        <div class="flex-1 w-full">
            <input type="text" placeholder="Cari berdasarkan nama atau SKU ..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange">
        </div>
        <div class="flex-none">
             <input type="text" placeholder="01 Mei 2025 - 31 Mei 2025" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange">
        </div>
        <div class="flex-none">
            <select class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange">
                <option>Sortir Berdasarkan</option>
                <option>Nama A-Z</option>
                <option>Nama Z-A</option>
                <option>Harga Termurah</option>
                <option>Harga Termahal</option>
            </select>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-800 uppercase bg-[#FDEBDD]">
                    <tr>
                        <th scope="col" class="px-6 py-3">SKU</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Jenis</th>
                        <th scope="col" class="px-6 py-3">Harga Satuan</th>
                        <th scope="col" class="px-6 py-3">Satuan</th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">MK1</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Kue Leker</td>
                        <td class="px-6 py-4">Makanan Ringan</td>
                        <td class="px-6 py-4">Rp. 2.000,00</td>
                        <td class="px-6 py-4">Pieces</td>
                        <td class="px-6 py-4 text-right">
                             <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                             <a href="#" class="font-medium text-red-600 hover:underline ml-4">Hapus</a>
                        </td>
                    </tr>

                    {{-- Ini adalah contoh bagaimana Anda akan menampilkan data dari database menggunakan Blade loop --}}
                    {{-- @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $product->sku }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">{{ $product->category }}</td>
                            <td class="px-6 py-4">Rp. {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $product->unit }}</td>
                            <td class="px-6 py-4 text-right">
                                 <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                                 <a href="#" class="font-medium text-red-600 hover:underline ml-4">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
