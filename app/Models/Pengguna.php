<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $fillable = ['nama', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
