<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        Satuan::insert([
            ['nama_satuan' => 'Pcs'],
            ['nama_satuan' => 'Box'],
            ['nama_satuan' => 'Pack'],
        ]);
    }
}
