<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        // Default ke bulan saat ini jika tidak ada parameter month
        $month = $request->query('month', Carbon::now()->format('Y-m'));
        
        try {
            $date = Carbon::createFromFormat('Y-m', $month);
        } catch (\Exception $e) {
            $date = Carbon::now();
            $month = $date->format('Y-m');
        }

        $year = $date->year;
        $monthNum = $date->month;

        // Ambil transaksi bulan tersebut
        $transaksis = Transaksi::with(['akunDebit.kategori', 'akunKredit.kategori'])
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $monthNum)
            ->get();

        // Hitung pengeluaran per kategori
        $kategoriPengeluaran = [];
        foreach ($transaksis->where('jenis_transaksi', 'Pengeluaran') as $trx) {
            $kategoriName = $trx->akunDebit && $trx->akunDebit->kategori ? $trx->akunDebit->kategori->nama_kategori : 'Lainnya';
            if (!isset($kategoriPengeluaran[$kategoriName])) {
                $kategoriPengeluaran[$kategoriName] = 0;
            }
            $kategoriPengeluaran[$kategoriName] += $trx->jumlah;
        }
        arsort($kategoriPengeluaran);

        // Hitung pemasukan per kategori
        $kategoriPemasukan = [];
        foreach ($transaksis->where('jenis_transaksi', 'Pemasukan') as $trx) {
            $kategoriName = $trx->akunKredit && $trx->akunKredit->kategori ? $trx->akunKredit->kategori->nama_kategori : 'Lainnya';
            if (!isset($kategoriPemasukan[$kategoriName])) {
                $kategoriPemasukan[$kategoriName] = 0;
            }
            $kategoriPemasukan[$kategoriName] += $trx->jumlah;
        }
        arsort($kategoriPemasukan);

        return view('grafik', compact(
            'month', 
            'kategoriPengeluaran',
            'kategoriPemasukan'
        ));
    }
}
