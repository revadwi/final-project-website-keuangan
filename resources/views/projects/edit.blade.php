@extends('layouts.app')
@section('title', 'Edit Project - FinanceHub')
@section('header-title', 'Edit Pendapatan Usaha')

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Form Edit Project: {{ $project->nama_project }}</h2>
        <a href="{{ route('projects.index') }}" class="btn-outline" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; color: #475569; text-decoration: none; font-weight: 500;">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Data Klien & Waktu</h3>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Project <span style="color:red">*</span></label>
                <input type="date" name="tanggal_project" value="{{ old('tanggal_project', $project->tanggal_project) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tenggang Waktu (Hari) <span style="color:red">*</span></label>
                <input type="number" name="tenggang_waktu" id="tenggang_waktu" value="{{ old('tenggang_waktu', $project->tenggang_waktu) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" onchange="calculateJatuhTempo()">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', $project->tanggal_jatuh_tempo) }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">No Penawaran / Invoice</label>
                <input type="text" name="no_penawaran" value="{{ old('no_penawaran', $project->no_penawaran) }}" placeholder="Contoh: INV-2026-001" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nama Pelanggan (PIC)</label>
                <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $project->nama_pelanggan) }}" placeholder="Contoh: Budi Santoso" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nama Perusahaan / Klien</label>
                <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $project->nama_perusahaan) }}" placeholder="Contoh: PT Angin Ribut" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Kota Klien</label>
                <input type="text" name="kota" value="{{ old('kota', $project->kota) }}" placeholder="Contoh: Jakarta" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-top: 10px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Detail Project & Nilai</h3>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nama Project <span style="color:red">*</span></label>
                <input type="text" name="nama_project" value="{{ old('nama_project', $project->nama_project) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Deskripsi Project</label>
                <textarea name="deskripsi_project" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; resize: vertical;">{{ old('deskripsi_project', $project->deskripsi_project) }}</textarea>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Harga Dasar (DPP) <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="harga_dasar" id="harga_dasar" value="{{ old('harga_dasar', $project->harga_dasar) }}" required style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">PPN (Nominal)</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="ppn" id="ppn" value="{{ old('ppn', $project->ppn) }}" required style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">PPh Final (%) <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; right: 15px; top: 10px; color: #64748b;">%</span>
                    <input type="number" step="0.01" name="pph_final" id="pph_final" value="{{ old('pph_final', $project->pph_final) }}" required style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Total Tagihan / Nominal Project</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="nominal_project_display" id="nominal_project" value="{{ old('nominal_project', $project->nominal_project) }}" required readonly style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; background: #f1f5f9; font-weight: bold; color: #0f172a;">
                </div>
                <small style="color: #64748b; font-size: 12px;">Harga Dasar + PPN</small>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Pendapatan Bersih</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="pendapatan_bersih_display" id="pendapatan_bersih" value="{{ old('pendapatan_bersih', $project->pendapatan_bersih) }}" readonly style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; background: #f1f5f9; font-weight: bold; color: #059669;">
                </div>
                <small style="color: #64748b; font-size: 12px;">Harga Dasar - (Harga Dasar * PPh Final %)</small>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Status</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <option value="Belum Bayar" {{ old('status', $project->status) == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="On Progress" {{ old('status', $project->status) == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; justify-content: flex-end;">
            <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #0b5394; color: white; font-weight: 500; cursor: pointer;">
                Update Project
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function calculateJatuhTempo() {
        let tgl = document.querySelector('input[name="tanggal_project"]').value;
        let tenggang = document.getElementById('tenggang_waktu').value;
        
        if(tgl && tenggang) {
            let date = new Date(tgl);
            date.setDate(date.getDate() + parseInt(tenggang));
            
            let y = date.getFullYear();
            let m = String(date.getMonth() + 1).padStart(2, '0');
            let d = String(date.getDate()).padStart(2, '0');
            
            document.getElementById('tanggal_jatuh_tempo').value = `${y}-${m}-${d}`;
        }
    }

    function calculateTotal() {
        let dpp = parseFloat(document.getElementById('harga_dasar').value) || 0;
        let ppn = parseFloat(document.getElementById('ppn').value) || 0;
        let pphPercent = parseFloat(document.getElementById('pph_final').value) || 0;
        
        let tagihan = dpp + ppn;
        let bersih = dpp - (dpp * (pphPercent / 100));

        document.getElementById('nominal_project').value = tagihan;
        document.getElementById('pendapatan_bersih').value = bersih;
    }

    document.querySelector('input[name="tanggal_project"]').addEventListener('change', calculateJatuhTempo);
</script>
@endpush
