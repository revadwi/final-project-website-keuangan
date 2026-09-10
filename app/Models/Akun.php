<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Akun extends Model
{
    protected $fillable = ['kategori_id', 'nama_akun', 'nomor_akun', 'aktivitas_arus_kas', 'perusahaan_id'];

    protected static function booted()
    {
        static::addGlobalScope('perusahaan', function (Builder $builder) {
            $active_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
            if ($active_id) {
                $builder->where('perusahaan_id', $active_id);
            }
        });

        static::creating(function ($model) {
            $active_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
            if ($active_id) {
                $model->perusahaan_id = $active_id;
            }
        });
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

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
