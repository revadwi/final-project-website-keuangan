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

                // Ambil daftar project dinamis dari database
                $active_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
                $projects = Project::where('perusahaan_id', $active_id)->orderBy('nama_project')->pluck('nama_project')->toArray();

                if (!empty($projects)) {
                    // Buat sheet tersembunyi untuk menyimpan opsi nama project
                    $optionsSheet = $spreadsheet->createSheet();
                    $optionsSheet->setTitle('ProjectOptions');
                    $optionsSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                    $rowCount = count($projects);
                    foreach ($projects as $index => $nama_project) {
                        $optionsSheet->setCellValue('A' . ($index + 1), $nama_project);
                    }

                    // Dropdown untuk Nama Project (Kolom D)
                    $validationProject = $sheet->getCell('D2')->getDataValidation();
                    $validationProject->setType(DataValidation::TYPE_LIST);
                    $validationProject->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validationProject->setAllowBlank(true);
                    $validationProject->setShowInputMessage(true);
                    $validationProject->setShowErrorMessage(true);
                    $validationProject->setShowDropDown(true);
                    $validationProject->setErrorTitle('Input Error');
                    $validationProject->setError('Pilih nama project dari daftar yang tersedia.');
                    $validationProject->setPromptTitle('Pilih Project');
                    $validationProject->setPrompt('Silakan pilih nama project (opsional).');
                    
                    // Referensikan formula ke sheet tersembunyi
                    $validationProject->setFormula1('ProjectOptions!$A$1:$A$' . $rowCount);

                    // Terapkan ke baris 2 s.d 101 untuk Nama Project
                    for ($i = 2; $i <= 101; $i++) {
                        $sheet->getCell("D{$i}")->setDataValidation(clone $validationProject);
                    }
                }
            },
        ];
    }
}
