<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;

class RiwayatTransaksiController extends Controller
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
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Hitung total
        $totalPengeluaran = $transaksis->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
        $totalPemasukan = $transaksis->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Kelompokkan berdasarkan tanggal
        $transaksisGrouped = $transaksis->groupBy('tanggal');

        return view('riwayat-transaksi', compact(
            'month', 
            'transaksisGrouped', 
            'totalPengeluaran', 
            'totalPemasukan', 
            'saldo'
        ));
    }
}
