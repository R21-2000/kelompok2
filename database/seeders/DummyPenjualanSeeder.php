<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;
use App\Models\Produk;
use Carbon\Carbon;

class DummyPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada User dan Produk
        $pengguna = User::first();
        $produk = Produk::first();

        if (!$pengguna || !$produk) {
            $this->command->info('User atau Produk belum ada. Jalankan UserSeeder & ProdukSeeder dulu.');
            return;
        }

        // Loop untuk membuat 5 data penjualan
        for ($i = 1; $i <= 5; $i++) {
            $tanggal = Carbon::now()->subDays($i);
            $no_transaksi = 'TRX' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $penjualan = Penjualan::create([
                'no_transaksi' => $no_transaksi,
                'pengguna_id' => $pengguna->id,
                'nama_pelanggan' => 'Pelanggan Ke-' . $i,
                'tanggal_penjualan' => $tanggal,
                'metode_pembayaran' => 'tunai',
                'waktu_bayar' => now(), // pastikan ini diisi biar masuk chart
            ]);

            // Tambahkan 1 detail per penjualan
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'qty' => rand(1, 5),
                'harga_satuan' => 15000,
                'subtotal' => rand(20000, 80000),
            ]);
        }

        $this->command->info('Seeder Penjualan: 5 data berhasil dibuat.');
    }
}
