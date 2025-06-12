<?php

namespace Database\Seeders;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'nama_produk' => 'Cookies',
            'harga_satuan' => 15000,
            'jenis' => 'Makanan',
            'sku' => 'SKU001',
            'satuan_id' => 1, // Asumsikan satuan_id 1 sudah ada di tabel satuan
        ]);
    }
}
