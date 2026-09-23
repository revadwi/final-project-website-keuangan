<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Kategori;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->query('mode', 'month'); // Default to month
        $kategoriFilter = $request->query('kategori', 'ALL');
        
        // JIKA PENGGUNA HANYA MEMBUKA HALAMAN (TIDAK MENGUNDUH)
        if ($request->query('export') !== 'csv') {
            $kategoris = Kategori::all();

            // Hitung ringkasan keseluruhan
            $totalPemasukan = Transaksi::where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
            $totalPengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
            $totalSaldo = $totalPemasukan - $totalPengeluaran;

            // Hitung ringkasan bulanan (semua waktu)
            $monthlyData = Transaksi::selectRaw('
                    YEAR(tanggal) as year, 
                    MONTH(tanggal) as month, 
                    SUM(CASE WHEN jenis_transaksi = "Pemasukan" THEN jumlah ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN jenis_transaksi = "Pengeluaran" THEN jumlah ELSE 0 END) as pengeluaran
                ')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

            $overviewPerBulan = [];
            foreach ($monthlyData as $data) {
                $bulanNama = Carbon::createFromDate($data->year, $data->month, 1)->translatedFormat('M');
                $saldo = $data->pemasukan - $data->pengeluaran;
                
                $overviewPerBulan[] = [
                    'year' => $data->year,
                    'month' => $data->month,
                    'bulan_nama' => $bulanNama,
                    'pemasukan' => $data->pemasukan,
                    'pengeluaran' => $data->pengeluaran,
                    'saldo' => $saldo,
                ];
            }

            return view('laporan', compact(
                'mode', 'kategoriFilter', 'kategoris', 
                'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 'overviewPerBulan'
            ));
        }

        // --- MULAI LOGIKA PENGUNDUHAN ---
        $query = Transaksi::with(['akunDebit.kategori', 'akunKredit.kategori', 'hutang', 'piutang.project', 'project']);
        
        // Filter Kategori
        if ($kategoriFilter !== 'ALL') {
            $query->where(function($q) use ($kategoriFilter) {
                $q->whereHas('akunDebit.kategori', function($q2) use ($kategoriFilter) {
                    $q2->where('nama_kategori', $kategoriFilter);
                })->orWhereHas('akunKredit.kategori', function($q2) use ($kategoriFilter) {
                    $q2->where('nama_kategori', $kategoriFilter);
                });
            });
        }

        // Filter Waktu
        if ($mode === 'range') {
            $start = $request->query('start');
            $end = $request->query('end');
            if ($start) $query->whereDate('tanggal', '>=', $start);
            if ($end) $query->whereDate('tanggal', '<=', $end);
        } elseif ($mode === 'month') {
            $month = $request->query('month', date('Y-m'));
            $date = Carbon::parse($month . '-01');
            $query->whereYear('tanggal', $date->year)->whereMonth('tanggal', $date->month);
        } else {
            $year = $request->query('year', date('Y'));
            $query->whereYear('tanggal', $year);
        }

        // Ambil Data Mentah (Bukan Agregasi) untuk Jurnal Umum
        $transactions = $query->orderBy('tanggal', 'asc')->get();

        $jurnal_rows = [];
        $no = 1;
        foreach($transactions as $trx) {
            $tanggal = Carbon::parse($trx->tanggal);
            $docUrl = $trx->dokumentasi ? asset('storage/' . $trx->dokumentasi) : '';
            
            // Baris 1: Debit (Akun Tujuan)
            $akunDebit = $trx->akunDebit;
            
            $aktivitasDebit = 'Operasi';
            $kategoriDebit = '-';
            $nomorAkunDebit = '-';
            $namaAkunDebit = '-';

            if ($akunDebit) {
                $aktivitasDebit = $akunDebit->aktivitas_arus_kas;
                $kategoriDebit = $akunDebit->kategori ? $akunDebit->kategori->nama_kategori : '-';
                $nomorAkunDebit = $akunDebit->nomor_akun;
                $namaAkunDebit = $akunDebit->nama_akun;
            } elseif ($trx->hutang_id && $trx->hutang) {
                $kategoriDebit = 'Kewajiban / Hutang';
                $namaAkunDebit = $trx->hutang->jenis_hutang;
            }

            $namaProject = '-';
            if ($trx->project) {
                $namaProject = $trx->project->nama_project;
            } elseif ($trx->piutang && $trx->piutang->project) {
                $namaProject = $trx->piutang->project->nama_project;
            }

            $nomorUrutPiutang = $trx->piutang ? $trx->piutang->nomor_urut : '-';
            $nomorUrutHutang = $trx->hutang ? $trx->hutang->nomor_urut : '-';

            $jurnal_rows[] = [
                'no' => $no,
                'tanggal' => $tanggal->format('j-M-y'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->format('Y'),
                'nama_project' => $namaProject,
                'nomor_urut_piutang' => $nomorUrutPiutang,
                'nomor_urut_hutang' => $nomorUrutHutang,
                'aktivitas_arus_kas' => $aktivitasDebit,
                'kategori_nama_akun' => $kategoriDebit,
                'nomor_akun' => $nomorAkunDebit,
                'nama_akun' => $namaAkunDebit,
                'deskripsi_transaksi' => $trx->keterangan,
                'debet' => $trx->jumlah,
                'kredit' => 0,
                'dokumentasi' => $docUrl,
                'keterangan_warna' => $trx->jenis_transaksi == 'Pemasukan' ? 'Otomatis (Masuk)' : 'Input Manual',
                'is_debit' => true,
                'jenis_transaksi' => $trx->jenis_transaksi
            ];
            
            // Baris 2: Kredit (Akun Sumber)
            $akunKredit = $trx->akunKredit;
            
            $aktivitasKredit = 'Operasi';
            $kategoriKredit = '-';
            $nomorAkunKredit = '-';
            $namaAkunKredit = '-';

            if ($akunKredit) {
                $aktivitasKredit = $akunKredit->aktivitas_arus_kas;
                $kategoriKredit = $akunKredit->kategori ? $akunKredit->kategori->nama_kategori : '-';
                $nomorAkunKredit = $akunKredit->nomor_akun;
                $namaAkunKredit = $akunKredit->nama_akun;
            } elseif ($trx->piutang_id && $trx->piutang) {
                $kategoriKredit = 'Aset / Piutang';
                $namaAkunKredit = $trx->piutang->jenis_piutang;
            }

            $jurnal_rows[] = [
                'no' => '', // Kosongkan agar menyatu dengan transaksi di atasnya
                'tanggal' => $tanggal->format('j-M-y'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->format('Y'),
                'nama_project' => $namaProject,
                'nomor_urut_piutang' => $nomorUrutPiutang,
                'nomor_urut_hutang' => $nomorUrutHutang,
                'aktivitas_arus_kas' => $aktivitasKredit,
                'kategori_nama_akun' => $kategoriKredit,
                'nomor_akun' => $nomorAkunKredit,
                'nama_akun' => $namaAkunKredit,
                'deskripsi_transaksi' => $trx->keterangan,
                'debet' => 0,
                'kredit' => $trx->jumlah,
                'dokumentasi' => $docUrl,
                'keterangan_warna' => $trx->jenis_transaksi == 'Pengeluaran' ? 'Otomatis (Keluar)' : 'Input Manual',
                'is_debit' => false,
                'jenis_transaksi' => $trx->jenis_transaksi
            ];
            $no++;
        }

        // Kalkulasi Overview Kas Per Bulan (Bulanan Sebenarnya)
        $overview_per_bulan = [];
        $grouped_bulan = $transactions->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->translatedFormat('F Y');
        });
        
        foreach($grouped_bulan as $bulan => $items) {
            $debet = $items->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
            $kredit = $items->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
            $overview_per_bulan[] = [
                'bulan' => $bulan,
                'debet' => number_format($debet, 0, ',', '.'),
                'kredit' => number_format($kredit, 0, ',', '.'),
            ];
        }

        // Kalkulasi Overview Harian (List Balance Harian)
        $overview_harian = [];
        $grouped_harian = $transactions->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->translatedFormat('j-M-y');
        });
        
        foreach($grouped_harian as $tanggal => $items) {
            $debet = $items->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
            $kredit = $items->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
            $overview_harian[] = [
                'tanggal' => $tanggal,
                'debet' => number_format($debet, 0, ',', '.'),
                'kredit' => number_format($kredit, 0, ',', '.'),
            ];
        }

        // Kalkulasi Overview Kas Per Akun
        $overview_per_akun = [];
        $akun_stats = [];
        
        foreach($transactions as $trx) {
            $akun = $trx->jenis_transaksi == 'Pemasukan' ? $trx->akunDebit : $trx->akunKredit;
            $nama_akun = $akun ? $akun->nama_akun : 'Lainnya';
            
            if(!isset($akun_stats[$nama_akun])) {
                $akun_stats[$nama_akun] = ['debet' => 0, 'kredit' => 0];
            }
            if ($trx->jenis_transaksi == 'Pemasukan') {
                $akun_stats[$nama_akun]['debet'] += $trx->jumlah;
            } else {
                $akun_stats[$nama_akun]['kredit'] += $trx->jumlah;
            }
        }
        
        ksort($akun_stats); // Urutkan sesuai abjad nama akun
        
        foreach($akun_stats as $nama => $stats) {
            $overview_per_akun[] = [
                'akun' => $nama,
                'debet' => number_format($stats['debet'], 0, ',', '.'),
                'kredit' => number_format($stats['kredit'], 0, ',', '.'),
                'balance' => number_format($stats['debet'] - $stats['kredit'], 0, ',', '.')
            ];
        }

        // Export as HTML-to-Excel
        return response(view('exports.jurnal_umum', compact('jurnal_rows', 'overview_per_bulan', 'overview_per_akun', 'overview_harian')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Jurnal_Umum.xls"');
    }
}
