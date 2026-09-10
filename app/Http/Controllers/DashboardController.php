<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default ke bulan saat ini jika tidak ada parameter month
        $month = $request->query('month', \Carbon\Carbon::now()->format('Y-m'));
        
        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $month);
        } catch (\Exception $e) {
            $date = \Carbon\Carbon::now();
            $month = $date->format('Y-m');
        }

        $year = $date->year;
        $monthNum = $date->month;

        // Ambil transaksi bulan tersebut untuk ringkasan dan transaksi terbaru
        $transaksis = \App\Models\Transaksi::with(['akunDebit.kategori', 'akunKredit.kategori'])
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $monthNum)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Hitung total bulan ini
        $totalPengeluaran = $transaksis->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
        $totalPemasukan = $transaksis->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Hitung pengeluaran per kategori untuk chart Donut
        $kategoriPengeluaran = [];
        foreach ($transaksis->where('jenis_transaksi', 'Pengeluaran') as $trx) {
            $kategoriName = $trx->akunDebit && $trx->akunDebit->kategori ? $trx->akunDebit->kategori->nama_kategori : 'Lainnya';
            if (!isset($kategoriPengeluaran[$kategoriName])) {
                $kategoriPengeluaran[$kategoriName] = 0;
            }
            $kategoriPengeluaran[$kategoriName] += $trx->jumlah;
        }
        arsort($kategoriPengeluaran);

        // Ambil transaksi 1 tahun untuk grafik Arus Kas
        $cashflow = [
            'pemasukan' => array_fill(1, 12, 0),
            'pengeluaran' => array_fill(1, 12, 0),
        ];

        $yearlyTransaksis = \App\Models\Transaksi::whereYear('tanggal', $year)->get();
        foreach ($yearlyTransaksis as $trx) {
            $m = (int) \Carbon\Carbon::parse($trx->tanggal)->format('n');
            if ($trx->jenis_transaksi == 'Pemasukan') {
                $cashflow['pemasukan'][$m] += $trx->jumlah;
            } else {
                $cashflow['pengeluaran'][$m] += $trx->jumlah;
            }
        }
        
        $chartArusKas = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'pemasukan' => array_values($cashflow['pemasukan']),
            'pengeluaran' => array_values($cashflow['pengeluaran']),
        ];

        // Transaksi terbaru (5 saja) untuk di dashboard
        $transaksiTerbaru = $transaksis->take(5);

        return view('dashboard', compact(
            'month',
            'year',
            'totalPengeluaran', 
            'totalPemasukan', 
            'saldo',
            'kategoriPengeluaran',
            'chartArusKas',
            'transaksiTerbaru'
        ));
    }
}
