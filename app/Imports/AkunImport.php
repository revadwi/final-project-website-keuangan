<?php

namespace App\Imports;

use App\Models\Akun;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);

        // Ambil nilai dengan fallback untuk handle berbagai kemungkinan key dari header Excel
        $nomor_akun = $row['nomor_akun'] ?? $row['no_akun'] ?? null;
        $nama_akun = $row['nama_akun'] ?? null;
        $kategori_nama = $row['kategori'] ?? $row['nama_kategori'] ?? null;
        $arus_kas = $row['arus_kas'] ?? $row['aktivitas_arus_kas'] ?? null;

        // Skip jika data tidak lengkap
        if (!$nomor_akun || !$nama_akun || !$kategori_nama || !$arus_kas) {
            return null;
        }

        // Cari Kategori berdasarkan nama (case-insensitive) di perusahaan yang aktif
        $kategori = Kategori::where('perusahaan_id', $perusahaan_id)
            ->where('nama_kategori', $kategori_nama)
            ->first();

        // Jika kategori tidak ditemukan, lewati baris ini
        if (!$kategori) {
            return null; 
        }

        // Cek duplikasi nomor akun
        $exists = Akun::where('perusahaan_id', $perusahaan_id)
            ->where('nomor_akun', $nomor_akun)
            ->exists();

        if ($exists) {
            return null; // Skip jika nomor akun sudah ada
        }

        return new Akun([
            'nomor_akun'         => $nomor_akun,
            'nama_akun'          => $nama_akun,
            'kategori_id'        => $kategori->id,
            'aktivitas_arus_kas' => ucfirst(strtolower($arus_kas)),
            'perusahaan_id'      => $perusahaan_id,
        ]);
    }
}
