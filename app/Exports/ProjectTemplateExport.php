<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectTemplateExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 1;

    public function collection(): \Illuminate\Support\Collection
    {
        // Menyediakan 100 baris kosong untuk diisi oleh pengguna
        return collect(array_fill(0, 100, []));
    }

    public function headings(): array
    {
        return [
            'Tanggal Project',
            'Tenggang Waktu (Hari)',
            'Tanggal Jatuh Tempo',
            'No Penawaran',
            'Nama Pelanggan',
            'Nama Perusahaan',
            'Kota',
            'Nama Project',
            'Deskripsi Project',
            'Harga Dasar',
            'PPN',
            'PPh Final (%)',
            'Nominal Project',
            'Pendapatan Bersih',
            'Status',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $r = $this->rowNumber;

        return [
            '', // A: Tanggal Project
            '', // B: Tenggang Waktu (Hari)
            "=IF(AND(A{$r}<>\"\", B{$r}<>\"\"), A{$r}+B{$r}, \"\")", // C: Jatuh Tempo
            '', // D: No Penawaran
            '', // E: Nama Pelanggan
            '', // F: Nama Perusahaan
            '', // G: Kota
            '', // H: Nama Project
            '', // I: Deskripsi Project
            '', // J: Harga Dasar
            '', // K: PPN
            '', // L: PPh Final (%)
            "=IF(J{$r}<>\"\", J{$r}+K{$r}, \"\")", // M: Nominal Project
            "=IF(J{$r}<>\"\", J{$r}-(J{$r}*(L{$r}/100)), \"\")", // N: Pendapatan Bersih
            'Belum Bayar', // O: Status
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // Format baris pertama (header) dengan warna kuning/orange
        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF59E0B'] // Warna #f59e0b (Amber/Orange)
            ]
        ]);

        // Format kolom tanggal (A dan C) agar terbaca sebagai tanggal di Excel
        $sheet->getStyle('A2:A101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet->getStyle('C2:C101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
}
