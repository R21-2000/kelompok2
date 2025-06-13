<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = ['produk_id', 'stok', 'tanggal'];

    // Relasi: stok milik 1 produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
