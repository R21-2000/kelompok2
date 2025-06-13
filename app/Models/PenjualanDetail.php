<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'qty',
        'harga_satuan',
        'subtotal'
    ];

    // Relasi: detail penjualan milik 1 penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    // Relasi: detail penjualan milik 1 produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
