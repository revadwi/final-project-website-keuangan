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
            'dokumentasi' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $data['dokumentasi'] = $path;
        }

        \App\Models\Transaksi::create($data);

        return redirect()->route('transaksi.create')->with('success', 'Transaksi ' . $request->jenis_transaksi . ' berhasil dicatat.');
    }

    public function edit($id)
    {
        $transaksi = \App\Models\Transaksi::findOrFail($id);
        $kategoris = \App\Models\Kategori::all();
        $akuns = \App\Models\Akun::with('kategori')->get();
        return view('transaksi-edit', compact('transaksi', 'kategoris', 'akuns'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = \App\Models\Transaksi::findOrFail($id);

        $request->validate([
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'tanggal' => 'required|date',
            'akun_debit_id' => 'required|exists:akuns,id',
            'akun_kredit_id' => 'required|exists:akuns,id|different:akun_debit_id',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:1',
            'dokumentasi' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('dokumentasi')) {
            // Delete old file if exists
            if ($transaksi->dokumentasi && \Illuminate\Support\Facades\Storage::disk('public')->exists($transaksi->dokumentasi)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->dokumentasi);
            }
            $path = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $data['dokumentasi'] = $path;
        }

        $transaksi->update($data);

        return redirect()->route('dashboard', ['#riwayat-transaksi'])->with('success', 'Transaksi ' . $request->jenis_transaksi . ' berhasil diperbarui.');
    }
}
