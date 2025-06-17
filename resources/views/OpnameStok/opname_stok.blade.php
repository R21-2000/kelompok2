@extends('layouts.app')

@section('title', 'Opname')
@section('header_title', 'Opname')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Opname Stok</h2>
        <a href="{{ route('stok.daftar') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times text-2xl"></i>
        </a>
    </div>

    {{-- Notifikasi Error --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Form Opname Stok --}}
    <form action="{{ route('stok.storeOpname') }}" method="POST">
        @csrf
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
                        @forelse ($produks as $produk)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $produk->sku }}</td>
                            <td class="px-4 py-3">{{ $produk->nama_produk }}</td>
                            <td class="px-4 py-3">{{ $produk->jenis }}</td>
                            <td class="px-4 py-3 text-right">
                                {{-- Nama input dibuat array agar bisa memproses banyak produk sekaligus --}}
                                <input type="number" name="stok[{{ $produk->id }}]" class="w-24 p-1 border border-gray-300 rounded-md bg-gray-50 text-center" placeholder="Isi stok">
                            </td>
                            <td class="px-4 py-3">{{ $produk->satuan->nama_satuan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Tidak ada produk untuk di-opname. Silakan tambah produk terlebih dahulu.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('stok.daftar') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                    Batal
                </a>
                <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                    Simpan
                </button>
            </div>
        </div>
    </form>
@endsection