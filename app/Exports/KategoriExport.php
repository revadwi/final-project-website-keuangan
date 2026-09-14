<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class KategoriExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    public function collection(): \Illuminate\Support\Collection
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
        return Kategori::where('perusahaan_id', $perusahaan_id)->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kategori',
            'Jenis Kategori',
        ];
    }

    public function map($kategori): array
    {
        return [
            $kategori->nama_kategori,
            $kategori->jenis_kategori,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF10B981'], // Emerald-500
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF047857'],
                    ],
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Pilihan Jenis Kategori
                $jenisKategoriList = '"Debit,Kredit"';

                // Data Validation untuk Jenis Kategori (Kolom B)
                $validation = $sheet->getCell('B2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input Error');
                $validation->setError('Pilih Debit atau Kredit dari daftar dropdown.');
                $validation->setPromptTitle('Pilih Jenis');
                $validation->setPrompt('Pilih jenis kategori dari daftar dropdown.');
                $validation->setFormula1($jenisKategoriList);

                for ($i = 3; $i <= 1000; $i++) {
                    $sheet->getCell("B{$i}")->setDataValidation(clone $validation);
                }
            },
        ];
    }
}
