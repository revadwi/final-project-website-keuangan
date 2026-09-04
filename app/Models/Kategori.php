<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'jenis_kategori'];

    public function akuns()
    {
        return $this->hasMany(Akun::class);
    }
}
