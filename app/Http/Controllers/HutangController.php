<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\HutangExport;
use App\Exports\HutangTemplateExport;
use App\Imports\HutangImport;
use Maatwebsite\Excel\Facades\Excel;

class HutangController extends Controller
{
    public static $jenisHutang = [
        'Hutang Usaha',
        'Unbilled Accounts Payable',
        'Hutang Lain Lain',
        'Hutang Gaji',
        'Hutang Deviden',
        'Pendapatan Diterima Di Muka',
        'Utang Investor',
        'Sarana Kantor Terhutang',
        'Bunga Terhutang',
        'Biaya Terhutang Lainnya',
        'Hutang Bank',
        'PPN Keluaran',
        'Hutang Pajak - PPh 21',
        'Hutang Pajak - PPh 22',
        'Hutang Pajak - PPh 23',
        'Hutang Pajak - PPh 29',
        'Hutang Pajak - Pph Pasal 4 Ayat 2',
        'Hutang Pajak Lainnya',
        'Hutang dari Pemegang Saham',
        'Kewajiban Lancar Lainnya',
        'Kewajiban Manfaat Karyawan'
    ];

    public function index()
    {
        $hutangs = \App\Models\Hutang::with('transaksis')->orderBy('tanggal_dibuat', 'asc')->get();
        return view('hutangs.index', compact('hutangs'));
    }

    public function export()
    {
        return Excel::download(new HutangExport, 'hutangs.xlsx');
    }

    public function template()
    {
        return Excel::download(new HutangTemplateExport, 'template_hutangs.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new HutangImport, $request->file('file'));

        return redirect()->route('hutangs.index')->with('success', 'Data hutang berhasil diimport. Data duplikat dilewati.');
    }

    public function create()
    {
        $jenis_hutang = self::$jenisHutang;
        return view('hutangs.create', compact('jenis_hutang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_dibuat' => 'required|date',
            'nomor_urut' => 'required|string',
            'jenis_hutang' => 'required|string',
            'kreditur' => 'required|string',
            'keterangan' => 'nullable|string',
            'jatuh_tempo' => 'nullable|date',
            'nominal_awal' => 'required|numeric',
            'bunga_persen' => 'required|numeric',
        ]);

        \App\Models\Hutang::create($request->all());

        return redirect()->route('hutangs.index')->with('success', 'Data hutang berhasil ditambahkan.');
    }

    public function show(\App\Models\Hutang $hutang)
    {
        $hutang->load('transaksis.akunKredit');
        $akuns = \App\Models\Akun::with('kategori')->get();
        return view('hutangs.show', compact('hutang', 'akuns'));
    }

    public function edit(\App\Models\Hutang $hutang)
    {
        $jenis_hutang = self::$jenisHutang;
        return view('hutangs.edit', compact('hutang', 'jenis_hutang'));
    }

    public function update(Request $request, \App\Models\Hutang $hutang)
    {
        $request->validate([
            'tanggal_dibuat' => 'required|date',
            'nomor_urut' => 'required|string',
            'jenis_hutang' => 'required|string',
            'kreditur' => 'required|string',
            'keterangan' => 'nullable|string',
            'jatuh_tempo' => 'nullable|date',
            'nominal_awal' => 'required|numeric',
            'bunga_persen' => 'required|numeric',
        ]);

        $hutang->update($request->all());

        // Update status if nominal_sisa is 0
        if ($hutang->nominal_sisa <= 0 && $hutang->status != 'Lunas') {
            $hutang->update(['status' => 'Lunas']);
        } elseif ($hutang->nominal_sisa > 0 && $hutang->status == 'Lunas') {
            $hutang->update(['status' => 'Belum Lunas']);
        }

        return redirect()->route('hutangs.index')->with('success', 'Data hutang berhasil diupdate.');
    }

    public function storePayment(Request $request, \App\Models\Hutang $hutang)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'akun_kredit_id' => 'required|exists:akuns,id', // Kas/Bank (Berkurang)
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        \App\Models\Transaksi::create([
            'jenis_transaksi' => 'Pengeluaran',
            'tanggal' => $request->tanggal,
            'akun_kredit_id' => $request->akun_kredit_id, // Uang keluar dari Kas
            // No akun_debit_id since we aren't linking it to master data for Hutang
            'keterangan' => $request->keterangan ?? ('Pembayaran Hutang: ' . $hutang->jenis_hutang . ' - ' . $hutang->kreditur),
            'jumlah' => $request->jumlah,
            'hutang_id' => $hutang->id,
        ]);

        if ($hutang->nominal_sisa <= 0) {
            $hutang->update(['status' => 'Lunas']);
        }

        return redirect()->back()->with('success', 'Pembayaran hutang berhasil dicatat.');
    }
}
