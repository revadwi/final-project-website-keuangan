<?php

namespace App\Imports;

use App\Models\Hutang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class HutangImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row): ?\Illuminate\Database\Eloquent\Model
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);

        $nomor_urut = $row['nomor_urut'] ?? null;
        $kreditur = $row['kreditur'] ?? null;

        // Skip jika data utama kosong
        if (!$nomor_urut || !$kreditur) {
            return null;
        }

        // Cek duplikat berdasarkan nomor urut (untuk perusahaan yang sama)
        $exists = Hutang::where('perusahaan_id', $perusahaan_id)
            ->where('nomor_urut', $nomor_urut)
            ->exists();

        if ($exists) {
            return null; // Skip baris ini
        }

        // Handle Tanggal Dibuat
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

        // Handle Tanggal Jatuh Tempo
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

        return new Hutang([
            'perusahaan_id' => $perusahaan_id,
            'tanggal_dibuat' => $tanggal_dibuat ?: date('Y-m-d'),
            'nomor_urut' => $nomor_urut,
            'jenis_hutang' => $row['akun_hutang'] ?? $row['jenis_hutang'] ?? 'Hutang Usaha',
            'kreditur' => $kreditur,
            'keterangan' => $row['keterangan'] ?? null,
            'jatuh_tempo' => $jatuh_tempo,
            'nominal_awal' => isset($row['nominal_awal']) ? floatval($row['nominal_awal']) : 0,
            'bunga_persen' => isset($row['bunga']) ? floatval($row['bunga']) : (isset($row['bunga_persen']) ? floatval($row['bunga_persen']) : 0),
            'status' => $row['status'] ?? 'Belum Lunas',
        ]);
    }
}
