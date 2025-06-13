@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Stok</h2>
        {{-- Tombol sekarang mengarah ke rute /tambah-stok dan teksnya diubah --}}
        <button onclick="window.location.href='{{ url('/opname-stok;" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-300 flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Opname Stok
        </button>
    </div>

    {{-- Filter dan Tabel Daftar Stok --}}
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
            {{-- Dropdown Jumlah Stok --}}
            <div class="relative w-full md:w-auto">
                <select id="jumlah_stok_filter" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-orange-dark" onchange="toggleStockRangeInputs()">
                    <option value="all">Jumlah Stok</option>
                    <option value="range">Rentang Jumlah Stok Akhir</option>
                </select>
            </div>
        </div>

        {{-- Input Rentang Jumlah Stok (hidden by default) --}}
        <div id="stock_range_inputs" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 hidden">
            <div>
                <label for="min_stok" class="block text-sm font-semibold text-gray-700 mb-2">MIN</label>
                <input type="number" id="min_stok" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="0">
            </div>
            <div>
                <label for="maks_stok" class="block text-sm font-semibold text-gray-700 mb-2">MAKS</label>
                <input type="number" id="maks_stok" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" placeholder="0">
            </div>
            <div class="md:col-span-2 flex justify-end gap-4">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                    Reset
                </button>
                <button class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">
                    Proses
                </button>
            </div>
        </div>

        {{-- Tabel Daftar Stok --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">SKU</th>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">Jenis</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Awal</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Masuk</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Terjual</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Opname</th>
                        <th scope="col" class="px-4 py-3 text-right">Stok Akhir</th>
                        <th scope="col" class="px-4 py-3">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh baris data --}}
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">MK1</td>
                        <td class="px-4 py-3">Kue Leker</td>
                        <td class="px-4 py-3">Makanan Ringan</td>
                        <td class="px-4 py-3 text-right">31</td>
                        <td class="px-4 py-3 text-right">5</td>
                        <td class="px-4 py-3 text-right">34</td>
                        <td class="px-4 py-3 text-right">0</td>
                        <td class="px-4 py-3 text-right">2</td>
                        <td class="px-4 py-3">Pieces</td>
                    </tr>
                    {{-- Akhir contoh baris data --}}
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleStockRangeInputs() {
            const selectElement = document.getElementById('jumlah_stok_filter');
            const stockRangeInputs = document.getElementById('stock_range_inputs');

            if (selectElement.value === 'range') {
                stockRangeInputs.classList.remove('hidden');
            } else {
                stockRangeInputs.classList.add('hidden');
            }
        }
    </script>
@endsection
