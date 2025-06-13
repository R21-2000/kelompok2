<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'nama_produk',
        'sku',
        'harga_satuan',
        'jenis',
        'satuan_id'
    ];

    // Relasi: produk milik 1 satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    // Relasi: produk memiliki banyak detail penjualan
    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    // Relasi: produk memiliki banyak stok
    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }
}
