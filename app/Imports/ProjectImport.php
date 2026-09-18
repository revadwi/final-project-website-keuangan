<?php

namespace App\Imports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ProjectImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);

        $nama_project = $row['nama_project'] ?? null;

        // Jika nama project kosong, skip
        if (!$nama_project) {
            return null;
        }

        // Cek duplikat berdasarkan nama project (untuk perusahaan yang sama)
        $exists = Project::where('perusahaan_id', $perusahaan_id)
            ->where('nama_project', $nama_project)
            ->exists();

        if ($exists) {
            return null; // Skip baris ini
        }

        // Handle Tanggal Project
        $tanggal_project = null;
        if (isset($row['tanggal_project']) && trim($row['tanggal_project']) !== '') {
            $val = trim($row['tanggal_project']);
            if (!str_starts_with($val, '=')) {
                if (is_numeric($val)) {
                    $tanggal_project = Date::excelToDateTimeObject($val)->format('Y-m-d');
                } else {
                    try { $tanggal_project = Carbon::parse($val)->format('Y-m-d'); } catch(\Exception $e) {}
                }
            }
        }

        // Handle Tanggal Jatuh Tempo
        $tanggal_jatuh_tempo = null;
        if (isset($row['tanggal_jatuh_tempo']) && trim($row['tanggal_jatuh_tempo']) !== '') {
            $val = trim($row['tanggal_jatuh_tempo']);
            if (!str_starts_with($val, '=')) {
                if (is_numeric($val)) {
                    $tanggal_jatuh_tempo = Date::excelToDateTimeObject($val)->format('Y-m-d');
                } else {
                    try { $tanggal_jatuh_tempo = Carbon::parse($val)->format('Y-m-d'); } catch(\Exception $e) {}
                }
            }
        }

        return new Project([
            'perusahaan_id' => $perusahaan_id,
            'tanggal_project' => $tanggal_project,
            'tenggang_waktu' => $row['tenggang_waktu_hari'] ?? $row['tenggang_waktu'] ?? null,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'no_penawaran' => $row['no_penawaran'] ?? null,
            'nama_pelanggan' => $row['nama_pelanggan'] ?? null,
            'nama_perusahaan' => $row['nama_perusahaan'] ?? null,
            'kota' => $row['kota'] ?? null,
            'nama_project' => $nama_project,
            'deskripsi_project' => $row['deskripsi_project'] ?? null,
            'harga_dasar' => (isset($row['harga_dasar']) && is_numeric($row['harga_dasar'])) ? floatval($row['harga_dasar']) : 0,
            'ppn' => (isset($row['ppn']) && is_numeric($row['ppn'])) ? floatval($row['ppn']) : 0,
            'pph_final' => (isset($row['pph_final']) && is_numeric($row['pph_final'])) ? floatval($row['pph_final']) : 0,
            'nominal_project' => (isset($row['nominal_project']) && is_numeric($row['nominal_project'])) ? floatval($row['nominal_project']) : 0,
            'pendapatan_bersih' => (isset($row['pendapatan_bersih']) && is_numeric($row['pendapatan_bersih'])) ? floatval($row['pendapatan_bersih']) : 0,
            'status' => $row['status'] ?? 'Belum Lunas',
        ]);
    }
}
