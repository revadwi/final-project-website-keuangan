<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PiutangExport;
use App\Exports\PiutangTemplateExport;
use App\Imports\PiutangImport;
use Maatwebsite\Excel\Facades\Excel;

class PiutangController extends Controller
{
    public static $jenisPiutang = [
        'Piutang Usaha',
        'Unbilled Accounts Receivable',
        'Cadangan Kerugian Piutang'
    ];

    public function index()
    {
        $piutangs = \App\Models\Piutang::with(['transaksis', 'project'])->orderBy('tanggal_dibuat', 'asc')->get();
        return view('piutangs.index', compact('piutangs'));
    }

    public function export()
    {
        return Excel::download(new PiutangExport, 'piutangs.xlsx');
    }

    public function template()
    {
        return Excel::download(new PiutangTemplateExport, 'template_piutangs.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new PiutangImport, $request->file('file'));

        return redirect()->route('piutangs.index')->with('success', 'Data piutang berhasil diimport. Data duplikat dilewati.');
    }

    public function create()
    {
        $jenis_piutang = self::$jenisPiutang;
        $projects = \App\Models\Project::orderBy('nama_project')->get();

        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulan = date('n');
        $tahun = date('Y');

        $latestPiutangs = \App\Models\Piutang::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->where('nomor_urut', 'like', '%/JN/PTNG/%')
            ->get();

        $maxUrut = 0;
        foreach ($latestPiutangs as $p) {
            $parts = explode('/', $p->nomor_urut);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urut = (int)$parts[0];
                if ($urut > $maxUrut) {
                    $maxUrut = $urut;
                }
            }
        }
        $nomorUrut = $maxUrut + 1;

        $nomorUrutStr = str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);
        $autoNoPiutang = $nomorUrutStr . '/JN/PTNG/' . $bulanRomawi[$bulan] . '/' . $tahun;

        return view('piutangs.create', compact('jenis_piutang', 'projects', 'autoNoPiutang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_dibuat' => 'required|date',
            'nomor_urut' => 'required|string',
            'jenis_piutang' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
            'keterangan' => 'nullable|string',
            'jatuh_tempo' => 'nullable|date',
            'nominal_awal' => 'required|numeric',
            'bunga_persen' => 'required|numeric',
        ]);

        \App\Models\Piutang::create($request->all());

        return redirect()->route('piutangs.index')->with('success', 'Data piutang berhasil ditambahkan.');
    }

    public function show(\App\Models\Piutang $piutang)
    {
        $piutang->load(['transaksis.akunDebit', 'project']);
        $akuns = \App\Models\Akun::with('kategori')->get();
        return view('piutangs.show', compact('piutang', 'akuns'));
    }

    public function edit(\App\Models\Piutang $piutang)
    {
        $jenis_piutang = self::$jenisPiutang;
        $projects = \App\Models\Project::orderBy('nama_project')->get();
        return view('piutangs.edit', compact('piutang', 'jenis_piutang', 'projects'));
    }

    public function update(Request $request, \App\Models\Piutang $piutang)
    {
        $request->validate([
            'tanggal_dibuat' => 'required|date',
            'nomor_urut' => 'required|string',
            'jenis_piutang' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
            'keterangan' => 'nullable|string',
            'jatuh_tempo' => 'nullable|date',
            'nominal_awal' => 'required|numeric',
            'bunga_persen' => 'required|numeric',
        ]);

        $piutang->update($request->all());

        // Update status if nominal_sisa is 0
        if ($piutang->nominal_sisa <= 0 && $piutang->status != 'Lunas') {
            $piutang->update(['status' => 'Lunas']);
        } elseif ($piutang->nominal_sisa > 0 && $piutang->status == 'Lunas') {
            $piutang->update(['status' => 'Belum Lunas']);
        }

        return redirect()->route('piutangs.index')->with('success', 'Data piutang berhasil diupdate.');
    }

    public function destroy(\App\Models\Piutang $piutang)
    {
        if ($piutang->transaksis()->exists()) {
            return redirect()->back()->with('error', 'Gagal dihapus! Data piutang ini sudah memiliki riwayat penerimaan pembayaran.');
        }

        $piutang->delete();

        return redirect()->route('piutangs.index')->with('success', 'Data piutang berhasil dihapus.');
    }

    public function storePayment(Request $request, \App\Models\Piutang $piutang)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'akun_debit_id' => 'required|exists:akuns,id', // Kas/Bank (Bertambah)
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiPath = $request->file('dokumentasi')->store('dokumentasi', 'public');
        }

        \App\Models\Transaksi::create([
            'jenis_transaksi' => 'Pemasukan',
            'tanggal' => $request->tanggal,
            'akun_debit_id' => $request->akun_debit_id, // Uang masuk ke Kas
            // No akun_kredit_id since we aren't linking it to master data for Piutang
            'keterangan' => $request->keterangan ?? ('Penerimaan Piutang: ' . $piutang->jenis_piutang . ($piutang->project ? ' - ' . $piutang->project->nama_project : '')),
            'jumlah' => $request->jumlah,
            'piutang_id' => $piutang->id,
            'dokumentasi' => $dokumentasiPath,
        ]);

        if ($piutang->nominal_sisa <= 0) {
            $piutang->update(['status' => 'Lunas']);
        }

        return redirect()->back()->with('success', 'Penerimaan piutang berhasil dicatat.');
    }
}
