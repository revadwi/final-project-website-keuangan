@extends('layouts.app')
@section('title', 'Tambah Piutang - FinanceHub')
@section('header-title', 'Tambah Piutang Usaha')

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Form Tambah Piutang Baru</h2>
        <a href="{{ route('piutangs.index') }}" class="btn-outline" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; color: #475569; text-decoration: none; font-weight: 500;">
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

    <form action="{{ route('piutangs.store') }}" method="POST" style="max-width: 800px;">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Informasi Piutang</h3>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Dibuat <span style="color:red">*</span></label>
                <input type="date" name="tanggal_dibuat" value="{{ old('tanggal_dibuat', date('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nomor Urut <span style="color:red">*</span></label>
                <input type="text" name="nomor_urut" value="{{ old('nomor_urut', $autoNoPiutang ?? '') }}" required placeholder="Contoh: 01/JN/PTNG/XII/2025" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Akun Piutang <span style="color:red">*</span></label>
                <select name="jenis_piutang" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <option value="" disabled selected>-- Pilih Akun Piutang --</option>
                    @foreach($jenis_piutang as $jh)
                        <option value="{{ $jh }}" {{ old('jenis_piutang') == $jh ? 'selected' : '' }}>{{ $jh }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nama Project</label>
                <select name="project_id" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <option value="" selected>-- Tanpa Project (Isi Keterangan Jika Perlu) --</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_project }}</option>
                    @endforeach
                </select>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Keterangan</label>
                <textarea name="keterangan" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; resize: vertical;" placeholder="Catatan tambahan (Opsional)">{{ old('keterangan') }}</textarea>
            </div>

            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-top: 10px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Nominal & Jatuh Tempo</h3>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nominal Awal <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="nominal_awal" id="nominal_awal" value="{{ old('nominal_awal', 0) }}" required style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Bunga (%) <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; right: 15px; top: 10px; color: #64748b;">%</span>
                    <input type="number" step="0.01" name="bunga_persen" id="bunga_persen" value="{{ old('bunga_persen', 0) }}" required style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nominal Akhir (Estimasi)</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" id="nominal_akhir" value="0" readonly style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; background: #f1f5f9; font-weight: bold; color: #0f172a;">
                </div>
                <small style="color: #64748b; font-size: 12px;">Nominal Awal + Bunga</small>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; justify-content: flex-end;">
            <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #0b5394; color: white; font-weight: 500; cursor: pointer;">
                Simpan Piutang Baru
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function calculateTotal() {
        let nominal = parseFloat(document.getElementById('nominal_awal').value) || 0;
        let bunga = parseFloat(document.getElementById('bunga_persen').value) || 0;
        
        let akhir = nominal + (nominal * (bunga / 100));

        document.getElementById('nominal_akhir').value = akhir;
    }

    // Initialize calc
    calculateTotal();
</script>
@endpush
