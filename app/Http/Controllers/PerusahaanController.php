<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Perusahaan::all();
        return view('perusahaan.index', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255|unique:perusahaans,nama_perusahaan'
        ]);

        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan
        ]);

        return redirect()->back()->with('success', 'Perusahaan berhasil ditambahkan');
    }

    public function switch($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        session(['active_perusahaan_id' => $perusahaan->id]);
        
        return redirect()->back()->with('success', 'Berhasil beralih ke Worksheet: ' . $perusahaan->nama_perusahaan);
    }
}
