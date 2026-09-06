<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'jenis_transaksi',
        'tanggal',
        'akun_debit_id',
        'akun_kredit_id',
        'keterangan',
        'jumlah'
    ];

    public function akunDebit()
    {
        return $this->belongsTo(Akun::class, 'akun_debit_id');
    }

    public function akunKredit()
    {
        return $this->belongsTo(Akun::class, 'akun_kredit_id');
    }
}
