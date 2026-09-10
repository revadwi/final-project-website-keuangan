<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'jenis_kategori', 'perusahaan_id'];

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

    public function akuns()
    {
        return $this->hasMany(Akun::class);
    }
}
