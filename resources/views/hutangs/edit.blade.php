@extends('layouts.app')
@section('title', 'Edit Hutang - FinanceHub')
@section('header-title', 'Edit Hutang Usaha')

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Form Edit Hutang: {{ $hutang->nomor_urut }}</h2>
        <a href="{{ route('hutangs.index') }}" class="btn-outline" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; color: #475569; text-decoration: none; font-weight: 500;">
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

    <form action="{{ route('hutangs.update', $hutang->id) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Informasi Hutang</h3>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Dibuat <span style="color:red">*</span></label>
                <input type="date" name="tanggal_dibuat" value="{{ old('tanggal_dibuat', $hutang->tanggal_dibuat) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nomor Urut <span style="color:red">*</span></label>
                <input type="text" name="nomor_urut" value="{{ old('nomor_urut', $hutang->nomor_urut) }}" required placeholder="Contoh: 01/JN/HU/XII/2025" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Akun Hutang <span style="color:red">*</span></label>
                <select name="jenis_hutang" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <option value="" disabled>-- Pilih Akun Hutang --</option>
                    @foreach($jenis_hutang as $jh)
                        <option value="{{ $jh }}" {{ old('jenis_hutang', $hutang->jenis_hutang) == $jh ? 'selected' : '' }}>{{ $jh }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Kreditur <span style="color:red">*</span></label>
                <input type="text" name="kreditur" value="{{ old('kreditur', $hutang->kreditur) }}" required placeholder="Contoh: Bank BCA / Tn. Budi" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Keterangan</label>
                <textarea name="keterangan" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; resize: vertical;" placeholder="Catatan tambahan (Opsional)">{{ old('keterangan', $hutang->keterangan) }}</textarea>
            </div>

            <div style="grid-column: 1 / -1;">
                <h3 style="font-size: 16px; color: #1e293b; margin-top: 10px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Nominal & Jatuh Tempo</h3>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Tanggal Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo', $hutang->jatuh_tempo) }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Nominal Awal <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 10px; color: #64748b;">Rp</span>
                    <input type="number" name="nominal_awal" id="nominal_awal" value="{{ old('nominal_awal', $hutang->nominal_awal) }}" required style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">Bunga (%) <span style="color:red">*</span></label>
                <div style="position: relative;">
                    <span style="position: absolute; right: 15px; top: 10px; color: #64748b;">%</span>
                    <input type="number" step="0.01" name="bunga_persen" id="bunga_persen" value="{{ old('bunga_persen', $hutang->bunga_persen) }}" required style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;" oninput="calculateTotal()">
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
            <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #f59e0b; color: white; font-weight: 500; cursor: pointer;">
                Update Hutang
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
