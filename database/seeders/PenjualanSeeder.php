<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pengguna;
use App\Models\Produk;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 1 pengguna dan 1 produk sebagai contoh
        $pengguna = Pengguna::first();
        $produk = Produk::first();

        // Buat data penjualan
        $penjualan = Penjualan::create([
            'no_transaksi' => 'TRX001',
            'pengguna_id' => $pengguna->id,
            'nama_pelanggan' => 'Budi Santoso',
            'tanggal_penjualan' => Carbon::now(),
            'metode_pembayaran' => 'tunai',
        ]);

        // Buat detail penjualan
        PenjualanDetail::create([
            'penjualan_id' => $penjualan->id,
            'produk_id' => $produk->id,
            'qty' => 2,
            'harga_satuan' => 15000,
            'subtotal' => 30000,
        ]);
    }
}
