<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = ['nama_satuan'];

    // Relasi: 1 satuan memiliki banyak produk
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
