<?php

namespace App\Imports;

use App\Models\Piutang;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PiutangImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        // Pengecekan wajib isi
        if (!isset($row['nomor_urut']) || trim($row['nomor_urut']) === '') {
            return null;
        }

        // Cek duplikasi berdasarkan nomor urut di perusahaan yang sama (Global scope handles perusahaan_id check implicitly if set up properly, but let's be safe)
        $active_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
        $exists = Piutang::where('nomor_urut', $row['nomor_urut'])->first();

        if ($exists) {
            // Skip data yang duplikat
            return null;
        }

        // Parse Tanggal Dibuat
        $tanggal_dibuat = null;
        if (isset($row['tanggal_dibuat']) && trim($row['tanggal_dibuat']) !== '') {
            $val = trim($row['tanggal_dibuat']);
            if (!str_starts_with($val, '=')) {
                if (is_numeric($val)) {
                    $tanggal_dibuat = Date::excelToDateTimeObject($val)->format('Y-m-d');
                } else {
                    try { $tanggal_dibuat = Carbon::parse($val)->format('Y-m-d'); } catch(\Exception $e) {}
                }
            }
        }

        // Parse Tanggal Jatuh Tempo
        $jatuh_tempo = null;
        if (isset($row['jatuh_tempo']) && trim($row['jatuh_tempo']) !== '') {
            $val = trim($row['jatuh_tempo']);
            if (!str_starts_with($val, '=')) {
                if (is_numeric($val)) {
                    $jatuh_tempo = Date::excelToDateTimeObject($val)->format('Y-m-d');
                } else {
                    try { $jatuh_tempo = Carbon::parse($val)->format('Y-m-d'); } catch(\Exception $e) {}
                }
            }
        }

        // Find Project by Name
        $project_id = null;
        if (isset($row['nama_project']) && trim($row['nama_project']) !== '') {
            $project = Project::where('nama_project', 'LIKE', '%' . trim($row['nama_project']) . '%')->first();
            if ($project) {
                $project_id = $project->id;
            }
        }

        $bunga = isset($row['bunga_']) ? floatval($row['bunga_']) : (isset($row['bunga']) ? floatval($row['bunga']) : 0);

        return new Piutang([
            'tanggal_dibuat' => $tanggal_dibuat ?: now()->format('Y-m-d'),
            'nomor_urut' => $row['nomor_urut'],
            'jenis_piutang' => $row['akun_piutang'] ?? 'Piutang Usaha',
            'project_id' => $project_id,
            'keterangan' => $row['keterangan'] ?? null,
            'jatuh_tempo' => $jatuh_tempo,
            'nominal_awal' => isset($row['nominal_awal']) ? floatval($row['nominal_awal']) : 0,
            'bunga_persen' => $bunga,
            'status' => $row['status'] ?? 'Belum Lunas',
            'perusahaan_id' => $active_id
        ]);
    }
}
