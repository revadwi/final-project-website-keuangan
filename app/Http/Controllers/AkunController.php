<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = \App\Models\Akun::with('kategori')->get();
        $kategoris = \App\Models\Kategori::all();
        return view('akun', compact('akuns', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_akun' => 'required|string|max:255',
            'nomor_akun' => [
                'required', 'string', 'max:255',
                Rule::unique('akuns', 'nomor_akun')->where('perusahaan_id', session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null))
            ],
            'aktivitas_arus_kas' => 'required|in:Operasi,Investasi,Pendanaan',
        ]);

        \App\Models\Akun::create($request->all());

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_akun' => 'required|string|max:255',
            'nomor_akun' => [
                'required', 'string', 'max:255',
                Rule::unique('akuns', 'nomor_akun')->ignore($id)->where('perusahaan_id', session('active_perusahaan_id', \App\Models\Perusahaan::first()->id ?? null))
            ],
            'aktivitas_arus_kas' => 'required|in:Operasi,Investasi,Pendanaan',
        ]);

        $akun = \App\Models\Akun::findOrFail($id);
        $akun->update($request->all());

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $akun = \App\Models\Akun::findOrFail($id);
        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
