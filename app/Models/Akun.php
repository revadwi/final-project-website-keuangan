<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $fillable = ['kategori_id', 'nama_akun', 'nomor_akun', 'aktivitas_arus_kas'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksiDebit()
    {
        return $this->hasMany(Transaksi::class, 'akun_debit_id');
    }

    public function transaksiKredit()
    {
        return $this->hasMany(Transaksi::class, 'akun_kredit_id');
    }
}
