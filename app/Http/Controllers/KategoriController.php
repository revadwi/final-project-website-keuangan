<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = \App\Models\Kategori::all();
        return view('kategori', compact('kategoris'));
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
