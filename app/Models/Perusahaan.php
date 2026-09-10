<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_perusahaan'];

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }

    public function akuns()
    {
        return $this->hasMany(Akun::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
