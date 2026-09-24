@extends('layouts.app')
@section('title', 'Hutang Usaha - FinanceHub')
@section('header-title', 'Hutang Usaha')

@section('content')
@push('styles')
<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.5); 
}
.modal-content {
    background-color: #fefefe;
    margin: 10% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    border-radius: 10px;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}
.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
}
.btn-primary {
    background-color: #1d4ed8;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.btn-danger {
    background-color: #dc2626;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
</style>
@endpush

<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2>Data Hutang Usaha</h2>
            <p style="color: #64748b; margin-top: 5px;">Daftar hutang dan kewajiban perusahaan.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('hutangs.export') }}" class="btn-primary" style="background-color: #10b981; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 6px; border: none; font-weight: 500; font-size: 13px;">
                <i class="ri-file-excel-line"></i> Export Excel
            </a>
            @if(Auth::user()->role !== 'viewer')
            <button onclick="openModal('modalImport')" class="btn-primary" style="background-color: #f59e0b; color: white; display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 6px; border: none; font-weight: 500; font-size: 13px; cursor: pointer;">
                <i class="ri-file-upload-line"></i> Import Excel
            </button>
            <a href="{{ route('hutangs.create') }}" class="btn-primary" style="background-color: #0b5394; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 6px; border: none; font-weight: 500; font-size: 13px;">
                <i class="ri-add-line"></i> Tambah Hutang
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
    @endif

    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; overflow-x: auto;">
        <table style="width:100%; text-align:left; border-collapse: collapse; min-width: 100%; font-size: 13px;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; white-space: nowrap;">
                    <th style="padding: 12px 10px; color:#475569;">No</th>
                    <th style="padding: 12px 10px; color:#475569;">Tanggal Dibuat</th>
                    <th style="padding: 12px 10px; color:#475569;">Nomor Urut</th>
                    <th style="padding: 12px 10px; color:#475569;">Akun Hutang</th>
                    <th style="padding: 12px 10px; color:#475569;">Kreditur</th>
                    <th style="padding: 12px 10px; color:#475569;">Keterangan</th>
                    <th style="padding: 12px 10px; color:#475569;">Jatuh Tempo</th>
                    <th style="padding: 12px 10px; color:#475569;">Nominal Awal</th>
                    <th style="padding: 12px 10px; color:#475569;">Bunga (%)</th>
                    <th style="padding: 12px 10px; color:#475569;">Nominal Akhir</th>
                    <th style="padding: 12px 10px; color:#475569;">Dibayarkan</th>
                    <th style="padding: 12px 10px; color:#475569;">Beban Bunga</th>
                    <th style="padding: 12px 10px; color:#475569;">Sisa</th>
                    <th style="padding: 12px 10px; color:#475569;">Status</th>
                    <th style="padding: 12px 10px; color:#475569;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hutangs as $index => $hutang)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 10px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px 10px; white-space: nowrap;">
                        <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($hutang->tanggal_dibuat)->format('d M Y') }}</div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 4px; white-space: nowrap;">Bulan: {{ \Carbon\Carbon::parse($hutang->tanggal_dibuat)->translatedFormat('F') }} | Tahun: {{ \Carbon\Carbon::parse($hutang->tanggal_dibuat)->format('Y') }}</div>
                    </td>
                    <td style="padding: 12px 10px;">{{ $hutang->nomor_urut }}</td>
                    <td style="padding: 12px 10px; font-weight: 600; white-space: nowrap;">{{ $hutang->jenis_hutang }}</td>
                    <td style="padding: 12px 10px; white-space: nowrap;">{{ $hutang->kreditur ?: '-' }}</td>
                    <td style="padding: 12px 10px; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $hutang->keterangan }}">{{ $hutang->keterangan ?: '-' }}</td>
                    <td style="padding: 12px 10px; color: #dc2626; white-space: nowrap;">{{ $hutang->jatuh_tempo ? \Carbon\Carbon::parse($hutang->jatuh_tempo)->format('d M Y') : '-' }}</td>
                    <td style="padding: 12px 10px; white-space: nowrap;">Rp {{ number_format($hutang->nominal_awal, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; text-align: center;">{{ $hutang->bunga_persen }}%</td>
                    <td style="padding: 12px 10px; white-space: nowrap; font-weight: 600;">Rp {{ number_format($hutang->nominal_akhir, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; color: #059669; white-space: nowrap;">Rp {{ number_format($hutang->nominal_dibayarkan, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; white-space: nowrap;">{{ $hutang->beban_bunga == 0 ? 'Rp -' : 'Rp ' . number_format($hutang->beban_bunga, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; color: #dc2626; white-space: nowrap; font-weight: 600;">{{ $hutang->nominal_sisa == 0 ? 'Rp -' : 'Rp ' . number_format($hutang->nominal_sisa, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px;">
                        @if($hutang->status === 'Lunas')
                            <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; white-space: nowrap;">{{ $hutang->status }}</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; white-space: nowrap;">{{ $hutang->status }}</span>
                        @endif
                    </td>
                    <td style="padding: 12px 10px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('hutangs.show', $hutang->id) }}" title="Detail & Pembayaran" style="color: #0b5394; background: #eff6ff; padding: 6px 10px; border-radius: 6px; text-decoration: none;">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if(Auth::user()->role !== 'viewer')
                            <a href="{{ route('hutangs.edit', $hutang->id) }}" title="Edit Hutang" style="color: #f59e0b; background: #fef3c7; padding: 6px 10px; border-radius: 6px; text-decoration: none;" class="action-btn">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('hutangs.destroy', $hutang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hutang ini?')" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Hutang" style="color: #dc2626; background: #fee2e2; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer;">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="15" style="padding: 20px; text-align: center; color: #64748b;">Belum ada data Hutang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Import -->
<div id="modalImport" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalImport')">&times;</span>
        <h2>Import Hutang dari Excel</h2>
        <div style="margin-top: 15px; margin-bottom: 15px;">
            <p style="font-size: 14px; color: #64748b; margin-bottom: 10px;">Silakan unduh template Excel di bawah ini, isi datanya, lalu unggah kembali.</p>
            <a href="{{ route('hutangs.template') }}" class="btn-primary" style="background-color: #10b981; text-decoration: none; display: inline-block; font-size: 14px;"><i class="ri-download-line"></i> Download Template</a>
        </div>
        <form action="{{ route('hutangs.import') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Mengimpor...'; btn.style.opacity = '0.7';">
            @csrf
            <div class="form-group">
                <label>File Excel (.xlsx, .xls, .csv)</label>
                <input type="file" name="file" accept=".xlsx, .xls, .csv" required style="padding: 8px;">
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-danger" onclick="closeModal('modalImport')">Batal</button>
                <button type="submit" class="btn-primary">Import</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).style.display = "block";
    }

    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    }
</script>
@endpush
