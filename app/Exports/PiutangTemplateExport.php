<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\Models\Project;

class PiutangTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    public function array(): array
    {
        $rows = [];
        for ($i = 2; $i <= 101; $i++) {
            $rows[] = [
                '', // Tanggal Dibuat
                '', // Nomor Urut
                '', // Akun Piutang
                '', // Nama Project
                '', // Keterangan
                '', // Jatuh Tempo
                '', // Nominal Awal
                '', // Bunga (%)
                "=G{$i}+(G{$i}*(H{$i}/100))", // Nominal Akhir
                'Belum Lunas', // Status
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'Tanggal Dibuat',
            'Nomor Urut',
            'Akun Piutang',
            'Nama Project',
            'Keterangan',
            'Jatuh Tempo',
            'Nominal Awal',
            'Bunga (%)',
            'Nominal Akhir',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // Format tanggal (String literal instead of constant to avoid compatibility issues)
        $sheet->getStyle('A2:A101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet->getStyle('F2:F101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        
        // Header styling (Amber/Orange to match UI pattern)
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF59E0B']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $spreadsheet = $sheet->getParent();

                // Dropdown untuk Akun Piutang (Kolom C)
                $validationAkun = $sheet->getCell('C2')->getDataValidation();
                $validationAkun->setType(DataValidation::TYPE_LIST);
                $validationAkun->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationAkun->setAllowBlank(false);
                $validationAkun->setShowInputMessage(true);
                $validationAkun->setShowErrorMessage(true);
                $validationAkun->setShowDropDown(true);
                $validationAkun->setErrorTitle('Input Error');
                $validationAkun->setError('Pilih akun dari daftar yang tersedia.');
                $validationAkun->setPromptTitle('Pilih Akun');
                $validationAkun->setPrompt('Silakan pilih salah satu kategori akun piutang.');
                $validationAkun->setFormula1('"Piutang Usaha,Unbilled Accounts Receivable,Cadangan Kerugian Piutang"');

                // Terapkan ke baris 2 s.d 101 untuk Akun Piutang
                for ($i = 2; $i <= 101; $i++) {
                    $sheet->getCell("C{$i}")->setDataValidation(clone $validationAkun);
                }

            },
        ];
    }
}
