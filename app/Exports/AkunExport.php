<?php

namespace App\Exports;

use App\Models\Akun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Models\Kategori;

class AkunExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    public function collection(): \Illuminate\Support\Collection
    {
        $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
        return Akun::with('kategori')->where('perusahaan_id', $perusahaan_id)->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Akun',
            'Nama Akun',
            'Kategori',
            'Arus Kas',
        ];
    }

    public function map($akun): array
    {
        return [
            $akun->nomor_akun,
            $akun->nama_akun,
            $akun->kategori ? $akun->kategori->nama_kategori : '-',
            $akun->aktivitas_arus_kas,
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
                
                // Ambil daftar kategori aktif
                $perusahaan_id = session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null);
                $kategoris = Kategori::where('perusahaan_id', $perusahaan_id)->pluck('nama_kategori')->toArray();
                
                // Pilihan Arus Kas
                $arusKas = ['Operasi', 'Investasi', 'Pendanaan'];

                $kategoriList = '"' . implode(',', $kategoris) . '"';
                $arusKasList = '"' . implode(',', $arusKas) . '"';

                // Data Validation untuk Kategori (Kolom C)
                $validationKategori = $sheet->getCell('C2')->getDataValidation();
                $validationKategori->setType(DataValidation::TYPE_LIST);
                $validationKategori->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationKategori->setAllowBlank(false);
                $validationKategori->setShowInputMessage(true);
                $validationKategori->setShowErrorMessage(true);
                $validationKategori->setShowDropDown(true);
                $validationKategori->setErrorTitle('Input Error');
                $validationKategori->setError('Nilai tidak ada di dalam daftar Kategori.');
                $validationKategori->setPromptTitle('Pilih Kategori');
                $validationKategori->setPrompt('Pilih kategori dari daftar dropdown.');
                $validationKategori->setFormula1($kategoriList);

                for ($i = 3; $i <= 1000; $i++) {
                    $sheet->getCell("C{$i}")->setDataValidation(clone $validationKategori);
                }

                // Data Validation untuk Arus Kas (Kolom D)
                $validationArusKas = $sheet->getCell('D2')->getDataValidation();
                $validationArusKas->setType(DataValidation::TYPE_LIST);
                $validationArusKas->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationArusKas->setAllowBlank(false);
                $validationArusKas->setShowInputMessage(true);
                $validationArusKas->setShowErrorMessage(true);
                $validationArusKas->setShowDropDown(true);
                $validationArusKas->setErrorTitle('Input Error');
                $validationArusKas->setError('Nilai tidak ada di dalam daftar Arus Kas.');
                $validationArusKas->setPromptTitle('Pilih Arus Kas');
                $validationArusKas->setPrompt('Pilih aktivitas arus kas dari daftar dropdown.');
                $validationArusKas->setFormula1($arusKasList);
                
                for ($i = 3; $i <= 1000; $i++) {
                    $sheet->getCell("D{$i}")->setDataValidation(clone $validationArusKas);
                }
            },
        ];
    }
}
