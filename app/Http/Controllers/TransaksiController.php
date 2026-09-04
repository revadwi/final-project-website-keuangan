<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        $akuns = \App\Models\Akun::with('kategori')->get();
        return view('transaksi', compact('kategoris', 'akuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'tanggal' => 'required|date',
            'akun_debit_id' => 'required|exists:akuns,id',
            'akun_kredit_id' => 'required|exists:akuns,id|different:akun_debit_id',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:1',
        ]);

        \App\Models\Transaksi::create($request->all());

        return redirect()->route('transaksi.create')->with('success', 'Transaksi ' . $request->jenis_transaksi . ' berhasil dicatat.');
    }
}
