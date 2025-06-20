@extends('layouts.app')

@section('title', 'Satuan')
@section('header_title', 'Satuan')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Satuan</h2>
        {{-- Tombol untuk mengarah ke halaman tambah satuan --}}
        <a href="{{ route('satuan.create') }}" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-300">
            + Tambah Satuan
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Daftar Satuan --}}
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama Satuan
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($satuans as $key => $satuan)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $satuan->nama_satuan }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex gap-2">
                                <a href="{{ route('satuan.edit', $satuan->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('satuan.destroy', $satuan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus satuan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-10 text-gray-500">
                                Tidak ada data satuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
