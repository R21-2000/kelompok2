<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = ['nama', 'email', 'password', 'role'];

    // Kolom yang disembunyikan ketika data model di-serialize ke JSON
    protected $hidden = ['password'];

    // Relasi: 1 pengguna memiliki banyak penjualan
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
