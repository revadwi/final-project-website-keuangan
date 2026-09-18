<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Hutang extends Model
{
    //
    protected $fillable = [
        'tanggal_dibuat',
        'nomor_urut',
        'jenis_hutang',
        'kreditur',
        'keterangan',
        'jatuh_tempo',
        'nominal_awal',
        'bunga_persen',
        'status',
        'perusahaan_id'
    ];

    protected $appends = ['nominal_akhir', 'nominal_dibayarkan', 'nominal_sisa', 'beban_bunga'];

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

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'hutang_id');
    }

    public function getNominalAkhirAttribute()
    {
        return $this->nominal_awal + ($this->nominal_awal * ($this->bunga_persen / 100));
    }

    public function getBebanBungaAttribute()
    {
        if ($this->nominal_dibayarkan <= $this->nominal_awal) {
            return 0;
        }
        return $this->nominal_dibayarkan - $this->nominal_awal;
    }

    public function getNominalDibayarkanAttribute()
    {
        return collect($this->transaksis)->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
    }

    public function getNominalSisaAttribute()
    {
        return $this->nominal_akhir - $this->nominal_dibayarkan;
    }
}
