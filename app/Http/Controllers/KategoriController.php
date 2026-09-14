<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'viewer') {
            abort(403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $kategoris = \App\Models\Kategori::all();
        return view('kategori', compact('kategoris'));
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\KategoriExport, 'kategori.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\KategoriImport, $request->file('file'));

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diimport. Data yang sudah ada dilewati.');
    }

    public function template()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\KategoriTemplateExport, 'template_kategori.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:255',
                Rule::unique('kategoris', 'nama_kategori')->where('perusahaan_id', session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null))
            ],
            'jenis_kategori' => 'required|in:Debit,Kredit',
        ]);

        \App\Models\Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:255',
                Rule::unique('kategoris', 'nama_kategori')->ignore($id)->where('perusahaan_id', session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null))
            ],
            'jenis_kategori' => 'required|in:Debit,Kredit',
        ]);

        $kategori = \App\Models\Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = \App\Models\Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
