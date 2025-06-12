<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
     protected $fillable = ['nama_produk', 'jenis', 'sku', 'harga_satuan', 'satuan_id'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
