<?php

namespace App\Exports;

use App\Models\Hutang;
use App\Models\Perusahaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HutangExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    public function collection(): \Illuminate\Support\Collection
    {
        $active_id = session('active_perusahaan_id', Perusahaan::first()->id ?? null);
        
        $hutangs = Hutang::where('perusahaan_id', $active_id)
            ->with('transaksis')
            ->orderBy('tanggal_dibuat', 'asc')
            ->get();

        return $hutangs;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Dibuat',
            'Bulan',
            'Tahun',
            'Nomor Urut',
            'Akun Hutang',
            'Kreditur',
            'Keterangan',
            'Jatuh Tempo',
            'Nominal Awal',
            'Bunga (%)',
            'Nominal Akhir',
            'Dibayarkan',
            'Beban Bunga',
            'Sisa',
            'Status',
        ];
    }

    public function map($hutang): array
    {
        $this->rowNumber++;
        $tanggal_dibuat = Carbon::parse($hutang->tanggal_dibuat);

        return [
            $this->rowNumber,
            $tanggal_dibuat->format('d M Y'),
            $tanggal_dibuat->translatedFormat('F'),
            $tanggal_dibuat->format('Y'),
            $hutang->nomor_urut,
            $hutang->jenis_hutang,
            $hutang->kreditur,
            $hutang->keterangan,
            $hutang->jatuh_tempo ? Carbon::parse($hutang->jatuh_tempo)->format('d M Y') : '-',
            $hutang->nominal_awal,
            $hutang->bunga_persen . '%',
            $hutang->nominal_akhir,
            $hutang->nominal_dibayarkan,
            $hutang->beban_bunga,
            $hutang->nominal_sisa,
            $hutang->status,
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
