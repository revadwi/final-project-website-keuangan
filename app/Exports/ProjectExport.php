<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\Perusahaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ProjectExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    public function collection(): \Illuminate\Support\Collection
    {
        $active_id = session('active_perusahaan_id', Perusahaan::first()->id ?? null);
        
        $projects = Project::where('perusahaan_id', $active_id)
            ->with(['transaksis' => function ($query) {
                $query->where('jenis_transaksi', 'Pemasukan');
            }])->get();

        foreach ($projects as $project) {
            $project->nominal_terbayar = $project->transaksis->sum('jumlah');
            $project->nominal_piutang = $project->nominal_project - $project->nominal_terbayar;
            
            if ($project->nominal_project > 0) {
                $project->progress = ($project->nominal_terbayar / $project->nominal_project) * 100;
            } else {
                $project->progress = 0;
            }
        }

        return $projects;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Project',
            'Bulan',
            'Tahun',
            'Nama Pelanggan',
            'Nama Perusahaan',
            'Kota',
            'Nama Project',
            'No Penawaran',
            'Jatuh Tempo',
            'Tagihan (Rp)',
            'Tagihan (In mn)',
            'P. Bersih (Rp)',
            'Terbayar (Rp)',
            'Piutang (Rp)',
            'Progress (%)',
            'Status',
        ];
    }

    public function map($project): array
    {
        $this->rowNumber++;
        $tanggal_project = Carbon::parse($project->tanggal_project);

        return [
            $this->rowNumber,
            $tanggal_project->format('d M Y'),
            $tanggal_project->translatedFormat('F'),
            $tanggal_project->format('Y'),
            $project->nama_pelanggan,
            $project->nama_perusahaan,
            $project->kota,
            $project->nama_project,
            $project->no_penawaran ?: '-',
            $project->tanggal_jatuh_tempo ? Carbon::parse($project->tanggal_jatuh_tempo)->format('d M Y') : '-',
            $project->nominal_project,
            round($project->nominal_project / 1000000, 2),
            $project->pendapatan_bersih,
            $project->nominal_terbayar,
            $project->nominal_piutang,
            round($project->progress) . '%',
            $project->status,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            // Style the first row as bold text and green background.
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF10B981']]
            ],
        ];
    }
}
