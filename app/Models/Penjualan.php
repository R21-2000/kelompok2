<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'no_transaksi',
        'pengguna_id',
        'nama_pelanggan',
        'tanggal_penjualan',
        'metode_pembayaran',
        'waktu_bayar',
    ];

    // Relasi: 1 penjualan dimiliki oleh 1 pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    // Relasi: 1 penjualan memiliki banyak detail penjualan
    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
