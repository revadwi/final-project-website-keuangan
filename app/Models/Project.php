<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'perusahaan_id',
        'tanggal_project',
        'tenggang_waktu',
        'tanggal_jatuh_tempo',
        'no_penawaran',
        'nama_pelanggan',
        'nama_perusahaan',
        'kota',
        'nama_project',
        'deskripsi_project',
        'harga_dasar',
        'ppn',
        'pph_final',
        'nominal_project',
        'pendapatan_bersih',
        'status',
    ];

    protected static function booted()
    {
        static::addGlobalScope('perusahaan', function (\Illuminate\Database\Eloquent\Builder $builder) {
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
        return $this->hasMany(Transaksi::class);
    }
}
