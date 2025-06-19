<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User; // <-- GANTI dari Pengguna jadi User
use App\Models\Produk;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        // Pakai User, bukan Pengguna
        $pengguna = User::first();
        $produk = Produk::first();

        // Cek dulu, kalau belum ada User atau Produk, skip biar errornya jelas
        if (!$pengguna || !$produk) {
            $this->command->info('User atau Produk belum ada. Jalankan UserSeeder & ProdukSeeder dulu.');
            return;
        }

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
