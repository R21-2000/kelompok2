<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = ['produk_id', 'stok_tambah', 'tanggal'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
