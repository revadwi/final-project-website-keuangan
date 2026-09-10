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
            return view('laporan', compact('mode', 'kategoriFilter', 'kategoris'));
        }

        // --- MULAI LOGIKA PENGUNDUHAN ---
        $query = Transaksi::with(['akunDebit.kategori', 'akunKredit.kategori']);
        
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
            $jurnal_rows[] = [
                'no' => $no,
                'tanggal' => $tanggal->format('j-M-y'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->format('Y'),
                'aktivitas_arus_kas' => $akunDebit ? $akunDebit->aktivitas_arus_kas : 'Operasi',
                'kategori_nama_akun' => $akunDebit && $akunDebit->kategori ? $akunDebit->kategori->nama_kategori : '-',
                'nomor_akun' => $akunDebit ? $akunDebit->nomor_akun : '-',
                'nama_akun' => $akunDebit ? $akunDebit->nama_akun : '-',
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
            $jurnal_rows[] = [
                'no' => '', // Kosongkan agar menyatu dengan transaksi di atasnya
                'tanggal' => $tanggal->format('j-M-y'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->format('Y'),
                'aktivitas_arus_kas' => $akunKredit ? $akunKredit->aktivitas_arus_kas : 'Operasi',
                'kategori_nama_akun' => $akunKredit && $akunKredit->kategori ? $akunKredit->kategori->nama_kategori : '-',
                'nomor_akun' => $akunKredit ? $akunKredit->nomor_akun : '-',
                'nama_akun' => $akunKredit ? $akunKredit->nama_akun : '-',
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
