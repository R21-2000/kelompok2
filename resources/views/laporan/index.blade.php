@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('header_title', 'Laporan')

@section('content')
    {{-- Header Konten & Aksi --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Laporan Penjualan</h2>
            <p class="text-sm text-gray-500 mt-1">Menampilkan semua transaksi</p>
        </div>
        
        <div class="flex items-center gap-2">
            {{-- Form khusus untuk Sort By --}}
            <form action="{{ route('laporan') }}" method="GET" id="sort-form">
                <select name="sort" onchange="document.getElementById('sort-form').submit()" class="bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg focus:outline-none">
                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Sort: Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Sort: Terlama</option>
                    <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Sort: Total Tertinggi</option>
                    <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Sort: Total Terendah</option>
                </select>
                {{-- Input tersembunyi untuk membawa filter saat sorting --}}
                @foreach(request()->except('sort') as $key => $value)
                     @if(is_array($value))
                        @foreach($value as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
            </form>

            {{-- Tombol Filter --}}
            <button type="button" id="filter-btn" class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg flex items-center">
                <i class="fa-solid fa-filter mr-2 text-gray-500"></i>
                <span>Filter</span>
            </button>

            {{-- Tombol Ekspor Laporan --}}
            <a href="{{ route('laporan.ekspor', request()->query()) }}" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fa-solid fa-file-export mr-2"></i>
                <span>Ekspor Laporan</span>
            </a>

            {{-- Tombol Reset --}}
            <a href="{{ route('laporan') }}" class="text-gray-500 hover:text-gray-800 p-2" title="Reset Filter & Sort">
                <i class="fa-solid fa-arrows-rotate"></i>
            </a>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-800 uppercase bg-[#FDEBDD]">
                    <tr>
                        <th scope="col" class="px-6 py-3">No Transaksi</th>
                        <th scope="col" class="px-6 py-3">Waktu Transaksi</th>
                        <th scope="col" class="px-6 py-3 text-center">Total Kuantitas</th>
                        <th scope="col" class="px-6 py-3">Barang yang Dibeli</th>
                        <th scope="col" class="px-6 py-3">Total Penjualan</th>
                        <th scope="col" class="px-6 py-3">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3">Nama Pelanggan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 align-top">{{ $penjualan->no_transaksi }}</td>
                            <td class="px-6 py-4 align-top">{{ \Carbon\Carbon::parse($penjualan->waktu_bayar)->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 font-semibold text-center align-top">{{ $penjualan->penjualanDetails->sum('qty') }}</td>
                            <td class="px-6 py-4 align-top">
                                <ul class="list-disc list-inside">
                                    @foreach ($penjualan->penjualanDetails as $detail)
                                        <li>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }} <span class="font-semibold">({{ $detail->qty }} pcs)</span></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 align-top">Rp {{ number_format($penjualan->penjualanDetails->sum('subtotal'), 0, ',', '.') }}</td>
                            <td class="px-6 py-4 align-top">{{ $penjualan->metode_pembayaran }}</td>
                            <td class="px-6 py-4 align-top">{{ $penjualan->nama_pelanggan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-10">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal untuk Filter --}}
    <div id="filter-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
            <h3 class="text-2xl font-bold mb-6">Filter Laporan</h3>
            <form action="{{ route('laporan') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Penjualan</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="number" name="minimal" placeholder="Rp Minimal" value="{{ request('minimal') }}" class="w-full p-2 border border-gray-300 rounded-md">
                            <span>-</span>
                            <input type="number" name="maksimal" placeholder="Rp Maksimal" value="{{ request('maksimal') }}" class="w-full p-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                            <option value="">Semua</option>
                            <option value="Tunai" {{ request('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="Kartu Debit/Kredit" {{ request('metode_pembayaran') == 'Kartu Debit/Kredit' ? 'selected' : '' }}>Kartu Debit/Kredit</option>
                            <option value="E-Wallet" {{ request('metode_pembayaran') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>
                    <div>
                         <label class="block text-sm font-medium text-gray-700">Waktu Transaksi</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="date" name="dari" value="{{ request('dari') }}" class="w-full p-2 border border-gray-300 rounded-md">
                            <span>-</span>
                            <input type="date" name="hingga" value="{{ request('hingga') }}" class="w-full p-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" placeholder="Cari nama..." value="{{ request('nama_pelanggan') }}" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                    <button type="button" id="batal-filter-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-md">Batal</button>
                    <button type="submit" class="bg-brand-orange hover:bg-brand-orange-dark text-white font-bold py-2 px-6 rounded-md">Filter</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtn = document.getElementById('filter-btn');
    const filterModal = document.getElementById('filter-modal');
    const batalFilterBtn = document.getElementById('batal-filter-btn');

    filterBtn.addEventListener('click', function () {
        filterModal.classList.remove('hidden');
    });

    batalFilterBtn.addEventListener('click', function () {
        filterModal.classList.add('hidden');
    });

    filterModal.addEventListener('click', function (e) {
        if (e.target === filterModal) {
            filterModal.classList.add('hidden');
        }
    });
});
</script>
@endsection