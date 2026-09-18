<?php

namespace App\Exports;

use App\Models\Piutang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PiutangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $rowNumber = 0;

    public function collection(): \Illuminate\Support\Collection
    {
        $active_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
        
        return Piutang::with('project')
            ->where('perusahaan_id', $active_id)
            ->orderBy('tanggal_dibuat', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Dibuat',
            'Bulan',
            'Tahun',
            'Nomor Urut',
            'Akun Piutang',
            'Nama Project',
            'Keterangan',
            'Jatuh Tempo',
            'Nominal Awal',
            'Bunga (%)',
            'Nominal Akhir',
            'Nominal Terbayar',
            'Nominal Sisa',
            'Pendapatan Bunga',
            'Status',
        ];
    }

    public function map($piutang): array
    {
        $this->rowNumber++;
        $date = Carbon::parse($piutang->tanggal_dibuat);
        
        return [
            $this->rowNumber,
            $date->format('Y-m-d'),
            $date->translatedFormat('F'),
            $date->format('Y'),
            $piutang->nomor_urut,
            $piutang->jenis_piutang,
            $piutang->project ? $piutang->project->nama_project : '-',
            $piutang->keterangan ?: '-',
            $piutang->jatuh_tempo ? Carbon::parse($piutang->jatuh_tempo)->format('Y-m-d') : '-',
            $piutang->nominal_awal,
            $piutang->bunga_persen,
            $piutang->nominal_akhir,
            $piutang->nominal_dibayarkan,
            $piutang->nominal_sisa,
            $piutang->pendapatan_bunga,
            $piutang->status,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF10B981'] // Green header to match UI
                ]
            ],
        ];
    }
}
