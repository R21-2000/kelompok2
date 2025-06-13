<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'no_transaksi',
        'pengguna_id',
        'nama_pelanggan',
        'tanggal_penjualan',
        'metode_pembayaran',
        'waktu_bayar',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
