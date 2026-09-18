<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaksi extends Model
{
    protected $fillable = [
        'jenis_transaksi',
        'tanggal',
        'akun_debit_id',
        'akun_kredit_id',
        'keterangan',
        'jumlah',
        'dokumentasi',
        'perusahaan_id',
        'project_id',
        'hutang_id',
        'piutang_id'
    ];

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

    public function akunDebit()
    {
        return $this->belongsTo(Akun::class, 'akun_debit_id');
    }

    public function akunKredit()
    {
        return $this->belongsTo(Akun::class, 'akun_kredit_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function hutang()
    {
        return $this->belongsTo(Hutang::class);
    }

    public function piutang()
    {
        return $this->belongsTo(Piutang::class);
    }
}
