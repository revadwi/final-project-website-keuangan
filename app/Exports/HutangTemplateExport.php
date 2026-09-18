<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HutangTemplateExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
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
            'Tanggal Dibuat',
            'Nomor Urut',
            'Akun Hutang',
            'Kreditur',
            'Keterangan',
            'Jatuh Tempo',
            'Nominal Awal',
            'Bunga (%)',
            'Nominal Akhir',
            'Status',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $r = $this->rowNumber;

        return [
            '', // A: Tanggal Dibuat
            '', // B: Nomor Urut
            '', // C: Akun Hutang
            '', // D: Kreditur
            '', // E: Keterangan
            '', // F: Jatuh Tempo
            '', // G: Nominal Awal
            '', // H: Bunga (%)
            "=IF(G{$r}<>\"\", G{$r}+(G{$r}*(H{$r}/100)), \"\")", // I: Nominal Akhir
            'Belum Lunas', // J: Status
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // Format baris pertama (header) dengan warna kuning/orange
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF59E0B'] // Warna #f59e0b (Amber/Orange)
            ]
        ]);

        // Format kolom tanggal (A dan F) agar terbaca sebagai tanggal di Excel
        $sheet->getStyle('A2:A101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet->getStyle('F2:F101')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $spreadsheet = $sheet->getParent();

                // 1. Buat sheet tersembunyi untuk menyimpan opsi dropdown yang panjang
                $optionsSheet = $spreadsheet->createSheet();
                $optionsSheet->setTitle('Options');
                $optionsSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                // 2. Ambil seluruh opsi akun hutang dari controller
                $jenisHutang = \App\Http\Controllers\HutangController::$jenisHutang;
                $rowCount = count($jenisHutang);

                // 3. Tulis opsi ke dalam sheet tersembunyi
                foreach ($jenisHutang as $index => $jenis) {
                    $optionsSheet->setCellValue('A' . ($index + 1), $jenis);
                }

                // Dropdown untuk Akun Hutang (Kolom C)
                $validation = $sheet->getCell('C2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input Error');
                $validation->setError('Pilih akun dari daftar yang tersedia.');
                $validation->setPromptTitle('Pilih Akun');
                $validation->setPrompt('Silakan pilih salah satu kategori akun hutang.');
                // Referensikan formula ke sheet tersembunyi
                $validation->setFormula1('Options!$A$1:$A$' . $rowCount);

                // Terapkan ke baris 2 s.d 101
                for ($i = 2; $i <= 101; $i++) {
                    $sheet->getCell("C{$i}")->setDataValidation(clone $validation);
                }
            },
        ];
    }
}
