@extends('layouts.app')

@section('content')
    {{-- Header Konten --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">Laporan Transaksi</h2>
        {{-- Tombol atau filter jika diperlukan --}}
    </div>

    {{-- Tabel Laporan Transaksi --}}
    <div class="bg-white p-6 rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3">No Transaksi</th>
                    <th scope="col" class="px-4 py-3">Tanggal</th>
                    <th scope="col" class="px-4 py-3">Waktu Bayar</th>
                    <th scope="col" class="px-4 py-3">Metode Pembayaran</th>
                    <th scope="col" class="px-4 py-3 text-right">Total Penjualan</th>
                    <th scope="col" class="px-4 py-3">Nama Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh baris data, ulangi ini untuk setiap transaksi --}}
                @for ($i = 0; $i < 10; $i++)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">TRX-{{ str_pad($i + 1, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3">{{ date('d M Y', strtotime('-' . $i . ' days')) }}</td>
                    <td class="px-4 py-3">{{ date('H:i', strtotime('-' . ($i * 30) . ' minutes')) }}</td>
                    <td class="px-4 py-3">{{ ['Tunai', 'Kartu', 'E-Wallet'][$i % 3] }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format(rand(50000, 500000), 0, ',', '.') }}</td>
                    <td class="px-4 py-3">Pelanggan {{ $i + 1 }}</td>
                </tr>
                @endfor
                {{-- Akhir contoh baris data --}}
            </tbody>
        </table>
    </div>
@endsection
