@extends('layouts.app')
@section('title', 'Pendapatan Usaha - FinanceHub')
@section('header-title', 'Pendapatan Usaha (Project)')

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

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2>Data Pendapatan Usaha</h2>
            <p style="color: #64748b; margin-top: 5px;">Daftar kontrak project dan status hutang piutang.</p>
        </div>
        @if(Auth::user()->role !== 'viewer')
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('projects.export') }}" class="btn-primary" style="background-color: #10b981; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; font-size: 13px;">
                <i class="ri-file-excel-line"></i> Export Excel
            </a>
            <button class="btn-primary" style="background-color: #f59e0b; display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; font-size: 13px;" onclick="openModal('modalImport')">
                <i class="ri-file-upload-line"></i> Import Excel
            </button>
            <a href="{{ route('projects.create') }}" class="btn-primary" style="background: #0b5394; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
                <i class="ri-add-line"></i> Tambah Project
            </a>
        </div>
        @endif
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    @endif

    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; overflow-x: auto;">
        <table style="width:100%; text-align:left; border-collapse: collapse; min-width: 1400px; font-size: 13px;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; white-space: nowrap;">
                    <th style="padding: 12px 10px; color:#475569;">No</th>
                    <th style="padding: 12px 10px; color:#475569;">Tanggal & Waktu</th>
                    <th style="padding: 12px 10px; color:#475569;">Client</th>
                    <th style="padding: 12px 10px; color:#475569;">Project</th>
                    <th style="padding: 12px 10px; color:#475569;">Tagihan</th>
                    <th style="padding: 12px 10px; color:#475569;">Tagihan (In mn)</th>
                    <th style="padding: 12px 10px; color:#475569;">P. Bersih</th>
                    <th style="padding: 12px 10px; color:#475569;">Terbayar</th>
                    <th style="padding: 12px 10px; color:#475569;">Piutang</th>
                    <th style="padding: 12px 10px; color:#475569;">Progress</th>
                    <th style="padding: 12px 10px; color:#475569;">Status</th>
                    <th style="padding: 12px 10px; color:#475569;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $index => $project)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 10px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px 10px;">
                        <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($project->tanggal_project)->format('d M Y') }}</div>
                        <div style="font-size: 11px; color: #64748b;">
                            Bulan: {{ \Carbon\Carbon::parse($project->tanggal_project)->translatedFormat('F') }} | 
                            Short: {{ \Carbon\Carbon::parse($project->tanggal_project)->translatedFormat('M') }} | 
                            Tahun: {{ \Carbon\Carbon::parse($project->tanggal_project)->format('Y') }}
                        </div>
                    </td>
                    <td style="padding: 12px 10px;">
                        <div style="font-weight: 600;">{{ $project->nama_pelanggan }}</div>
                        <div style="font-size: 12px; color: #64748b;">{{ $project->nama_perusahaan }}</div>
                        <div style="font-size: 11px; color: #94a3b8;"><i class="ri-map-pin-line"></i> {{ $project->kota ?: '-' }}</div>
                    </td>
                    <td style="padding: 12px 10px;">
                        <div style="font-weight: 600;">{{ $project->nama_project }}</div>
                        <div style="font-size: 11px; color: #64748b;">No: {{ $project->no_penawaran ?: '-' }}</div>
                        <div style="font-size: 11px; color: #dc2626;">Jatuh Tempo: {{ $project->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($project->tanggal_jatuh_tempo)->format('d M Y') : '-' }}</div>
                    </td>
                    <td style="padding: 12px 10px; white-space: nowrap;">Rp {{ number_format($project->nominal_project, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; text-align: center; white-space: nowrap;">{{ round($project->nominal_project / 1000000, 2) }}</td>
                    <td style="padding: 12px 10px; color: #059669; white-space: nowrap;">Rp {{ number_format($project->pendapatan_bersih, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; color: #059669; white-space: nowrap;">Rp {{ number_format($project->nominal_terbayar, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px; color: #dc2626; white-space: nowrap;">Rp {{ number_format($project->nominal_piutang, 0, ',', '.') }}</td>
                    <td style="padding: 12px 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="flex: 1; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                <div style="height: 100%; width: {{ min(100, $project->progress) }}%; background: {{ $project->progress >= 100 ? '#10b981' : '#3b82f6' }};"></div>
                            </div>
                            <span style="font-size: 12px; font-weight: 600;">{{ round($project->progress) }}%</span>
                        </div>
                    </td>
                    <td style="padding: 12px 10px;">
                        @if($project->status === 'Completed')
                            <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; white-space: nowrap;">{{ $project->status }}</span>
                        @elseif($project->status === 'Belum Bayar')
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; white-space: nowrap;">{{ $project->status }}</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; white-space: nowrap;">{{ $project->status }}</span>
                        @endif
                    </td>
                    <td style="padding: 12px 10px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('projects.show', $project->id) }}" title="Detail & Pembayaran" style="color: #0b5394; background: #eff6ff; padding: 6px 10px; border-radius: 6px; text-decoration: none;">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if(Auth::user()->role !== 'viewer')
                            <a href="{{ route('projects.edit', $project->id) }}" title="Edit Project" style="color: #f59e0b; background: #fef3c7; padding: 6px 10px; border-radius: 6px; text-decoration: none;" class="action-btn">
                                <i class="ri-edit-line"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="padding: 20px; text-align: center; color: #64748b;">Belum ada data pendapatan usaha/project.</td>
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
        <h2>Import Project dari Excel</h2>
        <div style="margin-top: 15px; margin-bottom: 15px;">
            <p style="font-size: 14px; color: #64748b; margin-bottom: 10px;">Silakan unduh template Excel di bawah ini, isi datanya, lalu unggah kembali.</p>
            <a href="{{ route('projects.template') }}" class="btn-primary" style="background-color: #10b981; text-decoration: none; display: inline-block; font-size: 14px;"><i class="ri-download-line"></i> Download Template</a>
        </div>
        <form action="{{ route('projects.import') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Mengimpor...'; btn.style.opacity = '0.7';">
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
