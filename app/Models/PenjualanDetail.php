<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'qty',
        'harga_satuan',
        'subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
