@extends('layouts.app')
@section('title', 'Laporan - FinanceHub')
@section('header-title', 'Laporan')

@section('content')
<!-- Laporan Section -->
<style>
    .filter-tab { padding: 10px; text-align: center; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; color: var(--text-muted); transition: all 0.2s; }
    .filter-tab.active-tab { background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-weight: 600; color: var(--text-dark); }
    .laporan-form { padding: 40px; }
    .range-inputs { display: flex; gap: 15px; }
    
    @media (max-width: 768px) {
        .laporan-form { padding: 20px !important; }
        .filter-tab { font-size: 11px !important; padding: 8px 2px !important; }
        .range-inputs { flex-direction: column !important; gap: 10px !important; }
        .export-btn { width: 100%; justify-content: center; font-size: 14px !important; }
        .filter-tabs-container { flex-wrap: wrap; }
    }
</style>
<div id="view-laporan" class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
    <div style="max-width: 800px; margin: 0 auto; padding-top: 20px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: #e0f2fe; color: #0284c7; border-radius: 50%; margin-bottom: 20px;">
                <i class="ri-file-excel-2-line" style="font-size: 32px;"></i>
            </div>
            <h2 style="font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0 0 10px 0;">Pusat Unduh Laporan</h2>
            <p style="font-size: 15px; color: var(--text-muted); margin: 0; max-width: 500px; margin-left: auto; margin-right: auto;">Konfigurasi saringan data yang Anda perlukan. Sistem akan menghasilkan file Laporan yang siap digunakan.</p>
        </div>

        <!-- Konfigurasi Panel -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid var(--border-color); overflow: hidden; margin-bottom: 30px;">
            <form action="/laporan" method="GET" class="laporan-form">
                <!-- 1. Filter Kategori -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Saring Kategori</label>
                    <div style="position: relative;">
                        <select name="kategori" id="export-kategori" style="width: 100%; border: 1px solid var(--border-color); padding: 14px 15px; border-radius: 8px; font-size: 15px; outline: none; background-color: #f8fafc; cursor: pointer; appearance: none;">
                            <option value="ALL" {{ $kategoriFilter == 'ALL' ? 'selected' : '' }}>Semua Kategori (Digabung)</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->nama_kategori }}" {{ $kategoriFilter == $kat->nama_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <i class="ri-arrow-down-s-line" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 20px; color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <!-- 2. Filter Waktu -->
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Saring Rentang Waktu</label>
                    
                    <div class="filter-tabs-container" style="display: flex; gap: 5px; margin-bottom: 15px; background: #f1f5f9; padding: 5px; border-radius: 8px;">
                        <label style="flex:1;">
                            <input type="radio" name="mode" value="range" {{ $mode == 'range' ? 'checked' : '' }} onchange="toggleFilterMode('range')" style="display:none;">
                            <div class="filter-tab {{ $mode == 'range' ? 'active-tab' : '' }}" id="tab-range">Harian (Range)</div>
                        </label>
                        <label style="flex:1;">
                            <input type="radio" name="mode" value="month" {{ $mode == 'month' ? 'checked' : '' }} onchange="toggleFilterMode('month')" style="display:none;">
                            <div class="filter-tab {{ $mode == 'month' ? 'active-tab' : '' }}" id="tab-month">Bulanan</div>
                        </label>
                        <label style="flex:1;">
                            <input type="radio" name="mode" value="year" {{ $mode == 'year' ? 'checked' : '' }} onchange="toggleFilterMode('year')" style="display:none;">
                            <div class="filter-tab {{ $mode == 'year' ? 'active-tab' : '' }}" id="tab-year">Tahunan</div>
                        </label>
                    </div>
                    
                    <!-- Konten Range Picker -->
                    <div id="filter-range" style="display: {{ $mode == 'range' ? 'block' : 'none' }};">
                        <div class="range-inputs">
                            <div style="flex: 1;">
                                <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Dari Tanggal</label>
                                <input type="date" name="start" value="{{ request('start') }}" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px;">
                            </div>
                            <div style="flex: 1;">
                                <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Sampai Tanggal</label>
                                <input type="date" name="end" value="{{ request('end') }}" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Konten Month Picker -->
                    <div id="filter-month" style="display: {{ $mode == 'month' ? 'block' : 'none' }};">
                        <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Pilih Bulan</label>
                        <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px;">
                    </div>
                    
                    <!-- Konten Year Picker -->
                    <div id="filter-year" style="display: {{ $mode == 'year' ? 'block' : 'none' }};">
                        <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Pilih Tahun</label>
                        <select name="year" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px;">
                            <option value="2026" {{ request('year', date('Y')) == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ request('year', date('Y')) == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2024" {{ request('year', date('Y')) == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2023" {{ request('year', date('Y')) == '2023' ? 'selected' : '' }}>2023</option>
                        </select>
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" name="export" value="csv" class="export-btn" style="padding: 14px 28px; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);"><i class="ri-download-2-line" style="font-size: 18px;"></i> Unduh Laporan (CSV)</button>
                </div>
            </form>
        </div>




    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFilterMode(mode) {
        document.getElementById('filter-range').style.display = 'none';
        document.getElementById('filter-month').style.display = 'none';
        document.getElementById('filter-year').style.display = 'none';
        
        document.getElementById('tab-range').classList.remove('active-tab');
        document.getElementById('tab-month').classList.remove('active-tab');
        document.getElementById('tab-year').classList.remove('active-tab');
        
        document.getElementById('filter-' + mode).style.display = 'block';
        document.getElementById('tab-' + mode).classList.add('active-tab');
    }
</script>
@endpush
