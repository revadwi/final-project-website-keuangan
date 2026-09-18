<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Transaksi;
use App\Models\Akun;
use App\Exports\ProjectExport;
use App\Exports\ProjectTemplateExport;
use App\Imports\ProjectImport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'viewer') {
            abort(403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        // Load projects with sum of their transactions
        $projects = Project::with(['transaksis' => function ($query) {
            // Only sum Pemasukan? Well, if it's a project income, it should be Pemasukan
            // Or we just sum all if the payment form specifically creates 'Pemasukan'
            $query->where('jenis_transaksi', 'Pemasukan');
        }])->get();

        foreach ($projects as $project) {
            $project->nominal_terbayar = $project->transaksis->sum('jumlah');
            $project->nominal_piutang = $project->nominal_project - $project->nominal_terbayar;
            
            if ($project->nominal_project > 0) {
                $project->progress = ($project->nominal_terbayar / $project->nominal_project) * 100;
            } else {
                $project->progress = 0;
            }

            if ($project->nominal_piutang <= 0 && $project->nominal_terbayar > 0) {
                $project->status = 'Completed';
                Project::where('id', $project->id)->update(['status' => 'Completed']);
            } elseif ($project->nominal_terbayar > 0 && $project->nominal_piutang > 0) {
                if ($project->status === 'Belum Bayar') {
                    $project->status = 'On Progress';
                    Project::where('id', $project->id)->update(['status' => 'On Progress']);
                }
            }
        }

        return view('projects.index', compact('projects'));
    }

    public function export()
    {
        return Excel::download(new ProjectExport, 'projects.xlsx');
    }

    public function template()
    {
        return Excel::download(new ProjectTemplateExport, 'template_projects.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new ProjectImport, $request->file('file'));

        return redirect()->route('projects.index')->with('success', 'Data project berhasil diimport. Data duplikat dilewati.');
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_project' => 'required|date',
            'tenggang_waktu' => 'required|integer',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'no_penawaran' => 'nullable|string',
            'nama_pelanggan' => 'nullable|string',
            'nama_perusahaan' => 'nullable|string',
            'kota' => 'nullable|string',
            'nama_project' => 'required|string',
            'deskripsi_project' => 'nullable|string',
            'harga_dasar' => 'required|numeric',
            'ppn' => 'required|numeric',
            'pph_final' => 'required|numeric',
        ]);

        $data['nominal_project'] = $data['harga_dasar'] + $data['ppn'];
        $data['pendapatan_bersih'] = $data['harga_dasar'] - ($data['harga_dasar'] * ($data['pph_final'] / 100));
        $data['status'] = 'Belum Bayar';

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project)
    {
        $project->load(['transaksis.akunDebit', 'transaksis.akunKredit']);
        $project->nominal_terbayar = $project->transaksis->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
        $project->nominal_piutang = $project->nominal_project - $project->nominal_terbayar;
        
        $akuns = Akun::with('kategori')->get();
        
        $default_debit = $akuns->where('nama_akun', 'Kas')->first()?->id 
            ?? $akuns->filter(function($a) { return $a->kategori && $a->kategori->nama_kategori == 'Kas & Bank'; })->first()?->id 
            ?? '';
            
        $default_kredit = $akuns->where('nama_akun', 'Pendapatan Jasa')->first()?->id 
            ?? $akuns->filter(function($a) { return $a->kategori && in_array($a->kategori->nama_kategori, ['Pendapatan', 'Pendapatan Lainnya']); })->first()?->id 
            ?? '';

        return view('projects.show', compact('project', 'akuns', 'default_debit', 'default_kredit'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'tanggal_project' => 'required|date',
            'tenggang_waktu' => 'required|integer',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'no_penawaran' => 'nullable|string',
            'nama_pelanggan' => 'nullable|string',
            'nama_perusahaan' => 'nullable|string',
            'kota' => 'nullable|string',
            'nama_project' => 'required|string',
            'deskripsi_project' => 'nullable|string',
            'harga_dasar' => 'required|numeric',
            'ppn' => 'required|numeric',
            'pph_final' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $data['nominal_project'] = $data['harga_dasar'] + $data['ppn'];
        $data['pendapatan_bersih'] = $data['harga_dasar'] - ($data['harga_dasar'] * ($data['pph_final'] / 100));

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diupdate.');
    }

    public function destroy(Project $project)
    {
        // Fitur hapus dinonaktifkan untuk menjaga integritas data keuangan
        abort(403, 'Akses hapus dinonaktifkan.');
    }

    public function storePayment(Request $request, Project $project)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'akun_debit_id' => 'required|exists:akuns,id', // Kas / Bank (Bertambah)
            'akun_kredit_id' => 'required|exists:akuns,id|different:akun_debit_id', // Pendapatan (Bertambah)
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Transaksi::create([
            'jenis_transaksi' => 'Pemasukan',
            'tanggal' => $request->tanggal,
            'akun_debit_id' => $request->akun_debit_id,
            'akun_kredit_id' => $request->akun_kredit_id,
            'keterangan' => $request->keterangan ?? ('Pembayaran Project: ' . $project->nama_project),
            'jumlah' => $request->jumlah,
            'project_id' => $project->id,
            // 'perusahaan_id' is handled by model booted creating event
        ]);

        return redirect()->route('projects.show', $project->id)->with('success', 'Pembayaran berhasil dicatat.');
    }
}
