@extends('layouts.app')
@section('title', 'Riwayat Transaksi - FinanceHub')
@section('header-title', 'Riwayat Transaksi')

@section('content')
<!-- Riwayat Transaksi Section -->
<div id="view-riwayat-transaksi" class="view-section active" style="display: block;">
    <div class="riwayat-container">
        <!-- Top Summary Header (Blue) -->
        <div class="riwayat-header-blue">
            <label class="rh-date-picker" style="position: relative; display: flex;" onclick="try { document.getElementById('riwayat-month-picker').showPicker(); } catch(e) {}">
                <input type="month" id="riwayat-month-picker" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;" value="{{ $month ?? date('Y-m') }}" onchange="window.location.href = '/riwayat-transaksi?month=' + this.value">
                @php
                    $currentMonth = $month ?? date('Y-m');
                    $carbonDate = \Carbon\Carbon::parse($currentMonth . '-01');
                    \Carbon\Carbon::setLocale('id');
                @endphp
                <span class="rh-year" id="rh-year-display">{{ $carbonDate->format('Y') }}</span>
                <div class="rh-month">
                    <span id="rh-month-display">{{ $carbonDate->translatedFormat('M') }}</span> <i class="ri-arrow-down-s-line"></i>
                </div>
            </label>
            <div class="rh-stat">
                <span class="rh-label">Pengeluaran</span>
                <span class="rh-value" id="rh-pengeluaran-val">{{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="rh-stat">
                <span class="rh-label">Pemasukan</span>
                <span class="rh-value" id="rh-pemasukan-val">{{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="rh-stat">
                <span class="rh-label">Saldo</span>
                <span class="rh-value" id="rh-saldo-val">{{ number_format($saldo ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Transactions List -->
        <div class="riwayat-list-content">
            @if(isset($transaksisGrouped) && $transaksisGrouped->count() > 0)
                @foreach($transaksisGrouped as $tanggal => $transaksis)
                    @php
                        $tglCarbon = \Carbon\Carbon::parse($tanggal);
                        $dailyPengeluaran = $transaksis->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
                        $dailyPemasukan = $transaksis->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
                    @endphp
                    <!-- Group by Date -->
                    <div class="riwayat-date-group">
                        <div class="rdg-header">
                            <div class="rdg-date">{{ $tglCarbon->format('d M') }} &nbsp;<span class="rdg-day">{{ $tglCarbon->translatedFormat('l') }}</span></div>
                            <div class="rdg-summary">Pengeluaran: {{ number_format($dailyPengeluaran, 0, ',', '.') }} &nbsp; Pemasukan: {{ number_format($dailyPemasukan, 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="rdg-items">
                            @foreach($transaksis as $trx)
                                <div class="rdg-item nav-link-custom" 
                                        data-id="{{ $trx->id }}"
                                        data-jenis="{{ $trx->jenis_transaksi }}"
                                        data-keterangan="{{ $trx->keterangan }}"
                                        data-jumlah="{{ number_format($trx->jumlah, 0, ',', '.') }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}"
                                        data-akun="{{ $trx->jenis_transaksi == 'Pemasukan' ? ($trx->akunKredit->nama_akun ?? '-') : ($trx->akunDebit->nama_akun ?? '-') }}"
                                        data-kategori="{{ $trx->jenis_transaksi == 'Pemasukan' ? ($trx->akunKredit->kategori->nama_kategori ?? '-') : ($trx->akunDebit->kategori->nama_kategori ?? '-') }}"
                                        data-nomor="{{ $trx->jenis_transaksi == 'Pemasukan' ? ($trx->akunKredit->nomor_akun ?? '-') : ($trx->akunDebit->nomor_akun ?? '-') }}"
                                        data-arus-kas="{{ $trx->jenis_transaksi == 'Pemasukan' ? ($trx->akunKredit->aktivitas_arus_kas ?? '-') : ($trx->akunDebit->aktivitas_arus_kas ?? '-') }}"
                                        data-dokumentasi="{{ $trx->dokumentasi ? asset('storage/' . $trx->dokumentasi) : '' }}"
                                        onclick="showDetailTransaksi(this)" style="cursor: pointer;">
                                    <div class="rdg-icon {{ $trx->jenis_transaksi == 'Pemasukan' ? 'icon-green' : 'icon-blue' }}">
                                        <i class="{{ $trx->jenis_transaksi == 'Pemasukan' ? 'ri-arrow-left-down-line' : 'ri-arrow-right-up-line' }}"></i>
                                    </div>
                                    <div class="rdg-info">
                                        <div class="rdg-title">{{ $trx->keterangan }}</div>
                                    </div>
                                    <div class="rdg-amount {{ $trx->jenis_transaksi == 'Pemasukan' ? 'amount-positive' : 'amount-negative' }}">
                                        {{ $trx->jenis_transaksi == 'Pemasukan' ? '+' : '-' }}{{ number_format($trx->jumlah, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div style="padding: 30px; text-align: center; color: var(--text-muted);">
                    Belum ada transaksi untuk bulan ini.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detail Transaksi Section -->
<div id="view-detail-transaksi" class="view-section" style="display: none; width: 100%;">
    <div class="detail-card" style="background: var(--bg-card); border-radius: 16px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%;">
        <!-- Header with Back Button (Left) and Centered Content -->
        <div style="position: relative; text-align: center; margin-bottom: 40px;">
            <button onclick="hideDetailTransaksi()" style="position: absolute; left: 0; top: 0; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-main); font-size: 20px;">
                <i class="ri-arrow-left-line"></i>
            </button>
            
            <div class="dt-icon-circle" id="dt-icon-color" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; margin: 0 auto 15px auto;">
                <i class="ri-global-line" id="dt-icon-class"></i>
            </div>
            <h2 id="dt-title" style="font-size: 20px; color: var(--text-dark); margin-bottom: 0; font-weight: 600;">-</h2>
        </div>
        
        <!-- Detail Rows -->
        <div class="detail-body" style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Tanggal</div>
                <div id="dt-tanggal" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Aktivitas Arus Kas</div>
                <div id="dt-arus-kas" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Kategori Akun</div>
                <div id="dt-kategori-akun" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nomor Akun</div>
                <div id="dt-nomor-akun" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nama Akun</div>
                <div id="dt-nama-akun" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Deskripsi Transaksi</div>
                <div id="dt-deskripsi" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Jumlah</div>
                <div id="dt-jumlah" style="color: var(--text-dark); font-weight: 700; text-align: right; flex: 1;">-</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px;">
                <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Dokumentasi</div>
                <div style="text-align: right; flex: 1; display: flex; justify-content: flex-end;" id="dt-dokumentasi-container">
                    <div style="width: 80px; height: 80px; background-color: var(--bg-main); border: 1px dashed var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 24px;">
                        <i class="ri-image-line"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer / Button -->
        <div class="detail-footer" style="margin-top: 40px;">
            <a id="dt-edit-btn" href="#" class="btn" style="display: block; text-align: center; width: 100%; padding: 15px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; border: none; background: var(--primary); color: white; text-decoration: none;">
                Edit
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showDetailTransaksi(element) {
        // Hide list view, show detail view
        document.getElementById('view-riwayat-transaksi').style.display = 'none';
        document.getElementById('view-detail-transaksi').style.display = 'block';

        // Extract data
        const id = element.getAttribute('data-id');
        const jenis = element.getAttribute('data-jenis');
        const keterangan = element.getAttribute('data-keterangan');
        const jumlah = element.getAttribute('data-jumlah');
        const tanggal = element.getAttribute('data-tanggal');
        const akun = element.getAttribute('data-akun');
        const kategori = element.getAttribute('data-kategori');
        const nomor = element.getAttribute('data-nomor');
        const arusKas = element.getAttribute('data-arus-kas');
        const dokumentasi = element.getAttribute('data-dokumentasi');

        // Populate detail view
        document.getElementById('dt-title').innerText = keterangan;
        document.getElementById('dt-tanggal').innerText = tanggal;
        document.getElementById('dt-arus-kas').innerText = arusKas || '-';
        document.getElementById('dt-kategori-akun').innerText = kategori;
        document.getElementById('dt-nomor-akun').innerText = nomor;
        document.getElementById('dt-nama-akun').innerText = akun;
        document.getElementById('dt-deskripsi').innerText = keterangan;
        document.getElementById('dt-jumlah').innerText = 'Rp ' + jumlah;

        const iconContainer = document.getElementById('dt-icon-color');
        const iconClass = document.getElementById('dt-icon-class');
        
        if (jenis === 'Pemasukan') {
            iconContainer.style.backgroundColor = '#10b981'; // Green
            iconClass.className = 'ri-arrow-left-down-line';
            document.getElementById('dt-jumlah').style.color = '#10b981';
        } else {
            iconContainer.style.backgroundColor = '#3b82f6'; // Blue
            iconClass.className = 'ri-arrow-right-up-line';
            document.getElementById('dt-jumlah').style.color = '#ef4444'; // Red for negative
        }

        const dokContainer = document.getElementById('dt-dokumentasi-container');
        if (dokumentasi) {
            if (dokumentasi.endsWith('.pdf')) {
                dokContainer.innerHTML = `<a href="${dokumentasi}" target="_blank" style="color: var(--primary);"><i class="ri-file-pdf-line" style="font-size: 32px;"></i></a>`;
            } else {
                dokContainer.innerHTML = `<a href="${dokumentasi}" target="_blank"><img src="${dokumentasi}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;"></a>`;
            }
        } else {
            dokContainer.innerHTML = `
                <div style="width: 80px; height: 80px; background-color: var(--bg-main); border: 1px dashed var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 24px;">
                    <i class="ri-image-line"></i>
                </div>
            `;
        }

        // Set Edit Link
        document.getElementById('dt-edit-btn').href = '/transaksi/' + id + '/edit';
    }

    function hideDetailTransaksi() {
        document.getElementById('view-detail-transaksi').style.display = 'none';
        document.getElementById('view-riwayat-transaksi').style.display = 'block';
    }
</script>
@endpush
