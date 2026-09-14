<?php

namespace App\Imports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriImport implements ToModel, WithHeadingRow
{

    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);

        // Ambil nilai dengan fallback untuk handle berbagai kemungkinan key dari header
        $nama_kategori = $row['nama_kategori'] ?? null;
        $jenis_kategori = $row['jenis_kategori'] ?? $row['jenis_kategori_debitkredit'] ?? $row['jenis_kategori_debit_kredit'] ?? null;

        // Skip baris jika nama atau jenis kosong
        if (!$nama_kategori || !$jenis_kategori) {
            return null;
        }

        // Cek duplikat
        $exists = Kategori::where('perusahaan_id', $perusahaan_id)
            ->where('nama_kategori', $nama_kategori)
            ->exists();

        if ($exists) {
            return null; // Skip baris ini
        }

        return new Kategori([
            'nama_kategori'  => $nama_kategori,
            'jenis_kategori' => ucfirst(strtolower($jenis_kategori)),
            'perusahaan_id'  => $perusahaan_id,
        ]);
    }
}
