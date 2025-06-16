@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('header_title', 'Produk')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800 self-start md:self-center">Daftar Produk</h2>
        <a href="{{ route('produk.create') }}" class="w-full md:w-auto bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-plus mr-2"></i>
            <span>Tambah Produk</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filter Bar --}}
    {{-- 1. Filter bar dibungkus form dengan method GET --}}
    <form action="{{ route('produk.index') }}" method="GET">
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center">
            <div class="flex-1 w-full">
                {{-- 2. Input search diberi name="search" --}}
                <input type="text" name="search" placeholder="Cari berdasarkan nama atau SKU ..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange" value="{{ request('search') }}">
            </div>
            
            {{-- Input tanggal sudah dihapus --}}

            <div class="flex-none">
                {{-- 3. Select sort diberi name="sort" dan event onchange --}}
                <select name="sort" class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange" onchange="this.form.submit()">
                    <option value="">Sortir Berdasarkan</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </div>
        </div>
    </form>

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
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $produk->sku }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $produk->nama_produk }}</td>
                            <td class="px-6 py-4">{{ $produk->jenis }}</td>
                            <td class="px-6 py-4">Rp. {{ number_format($produk->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $produk->satuan->nama_satuan }}</td>
                            
                            {{-- 4. Tata letak tombol aksi diperbaiki --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-x-4">
                                    <a href="{{ route('produk.edit', $produk->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                Tidak ada data produk yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection