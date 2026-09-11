@extends('layouts.app')
@section('title', 'Input Transaksi - FinanceHub')
@section('header-title', 'Input Transaksi')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.page-header { margin-bottom: 20px; }
        .page-header h1 { font-size: 24px; color: #1e293b; margin: 0 0 5px 0; }
        .page-header p { color: #64748b; font-size: 14px; margin: 0; }
        
        .transaction-card { background: white; border-radius: 10px; padding: 25px; max-width: 900px; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;}
        
        .tabs { display: flex; border-bottom: 1px solid #e2e8f0; margin-bottom: 25px; }
        .tab-btn { padding: 12px 24px; background: none; border: none; font-size: 15px; font-weight: 500; color: #64748b; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -1px; transition: all 0.2s ease; font-family: 'Inter', sans-serif;}
        .tab-btn:hover { color: #1e293b; }
        .tab-btn.active { color: #1d4ed8; border-bottom-color: #1d4ed8; font-weight: 600;}
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155; }
        .form-control { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 14px; color: #1e293b; box-sizing: border-box; }
        .form-control:focus { border-color: #3b82f6; outline: none; }
        
        .select2-container .select2-selection--single { height: 40px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; align-items: center; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { color: #1e293b; line-height: normal; padding-left: 12px; font-size: 14px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; right: 10px;}
        
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;}
        .btn { padding: 10px 20px; border-radius: 6px; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif; border: none; display: flex; align-items: center; gap: 5px;}
        .btn-cancel { background: #f1f5f9; color: #475569; }
        .btn-cancel:hover { background: #e2e8f0; }
        .btn-save { background: #1d4ed8; color: white; }
        .btn-save:hover { background: #1e40af; }
        .btn-save.btn-danger { background: #dc2626; }
        .btn-save.btn-danger:hover { background: #b91c1c; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .alert-success { background-color: #d1fae5; color: #065f46; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;}
        .alert-danger { background-color: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;}
        
        .account-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin-bottom: 20px;}
        .account-box h4 { margin: 0 0 15px 0; font-size: 14px; color: #334155; font-weight: 600;}

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
            }
            .transaction-card {
                padding: 15px !important;
            }
            .select2-container {
                width: 100% !important;
            }
            .tabs {
                display: flex;
            }
            .tab-btn {
                flex: 1;
                padding: 10px;
                font-size: 13px;
                text-align: center;
            }
            .form-actions {
                flex-direction: column;
            }
            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
</style>
@endpush

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-top: 10px;">


                <div class="transaction-card">
                    @if(session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-danger">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab('pemasukan')">Pemasukan</button>
                        <button class="tab-btn" onclick="switchTab('pengeluaran')">Pengeluaran</button>
                    </div>

                    <!-- FORM PEMASUKAN -->
                    <div id="form-pemasukan" class="tab-content active">
                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pemasukan">
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Pendapatan Jasa">
                                </div>
                            </div>
                            
                            <div class="account-box">
                                <h4>Akun Tujuan (Uang Masuk Ke Mana)</h4>
                                <div class="form-grid" style="margin-bottom: 0;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Kategori</label>
                                        <select class="select2-search" id="pem_kat_tujuan" onchange="filterAkun('pem_kat_tujuan', 'pem_akun_tujuan')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Nama Akun</label>
                                        <select class="select2-search" name="akun_debit_id" id="pem_akun_tujuan" required>
                                            <option value="">-- Pilih Akun --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="account-box">
                                <h4>Akun Sumber (Uang Berasal Dari Mana)</h4>
                                <div class="form-grid" style="margin-bottom: 0;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Kategori</label>
                                        <select class="select2-search" id="pem_kat_sumber" onchange="filterAkun('pem_kat_sumber', 'pem_akun_sumber')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Nama Akun</label>
                                        <select class="select2-search" name="akun_kredit_id" id="pem_akun_sumber" required>
                                            <option value="">-- Pilih Akun --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Jumlah (Rp)</label>
                                <input type="number" name="jumlah" class="form-control" required min="1" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label>Bukti Transaksi / Dokumentasi (Opsional)</label>
                                <input type="file" name="dokumentasi" class="form-control" accept="image/*,.pdf">
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-cancel" onclick="window.location.href='/dashboard'">Batal</button>
                                <button type="submit" class="btn btn-save">Simpan Pemasukan</button>
                            </div>
                        </form>
                    </div>

                    <!-- FORM PENGELUARAN -->
                    <div id="form-pengeluaran" class="tab-content">
                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pengeluaran">
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Pembayaran Listrik">
                                </div>
                            </div>
                            
                            <div class="account-box">
                                <h4>Akun Tujuan (Untuk Keperluan Apa)</h4>
                                <div class="form-grid" style="margin-bottom: 0;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Kategori</label>
                                        <select class="select2-search" id="peng_kat_tujuan" onchange="filterAkun('peng_kat_tujuan', 'peng_akun_tujuan')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Nama Akun</label>
                                        <select class="select2-search" name="akun_debit_id" id="peng_akun_tujuan" required>
                                            <option value="">-- Pilih Akun --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="account-box">
                                <h4>Akun Sumber (Dibayar Menggunakan Apa)</h4>
                                <div class="form-grid" style="margin-bottom: 0;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Kategori</label>
                                        <select class="select2-search" id="peng_kat_sumber" onchange="filterAkun('peng_kat_sumber', 'peng_akun_sumber')">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label>Nama Akun</label>
                                        <select class="select2-search" name="akun_kredit_id" id="peng_akun_sumber" required>
                                            <option value="">-- Pilih Akun --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Jumlah (Rp)</label>
                                <input type="number" name="jumlah" class="form-control" required min="1" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label>Bukti Transaksi / Dokumentasi (Opsional)</label>
                                <input type="file" name="dokumentasi" class="form-control" accept="image/*,.pdf">
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-cancel" onclick="window.location.href='/dashboard'">Batal</button>
                                <button type="submit" class="btn btn-save btn-danger">Simpan Pengeluaran</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@push('scripts')
<script>
        const allAkuns = @json($akuns);

        // Populate an akun select with all akuns (or filtered by kategori)
        function populateAkuns(akunElementId, kategoriId) {
            const akunSelect = document.getElementById(akunElementId);
            const currentVal = $(akunSelect).val(); // preserve current selection
            akunSelect.innerHTML = '<option value="">-- Pilih Akun --</option>';

            let list = allAkuns;
            if (kategoriId) {
                list = allAkuns.filter(akun => akun.kategori_id == kategoriId);
            }

            list.forEach(akun => {
                const option = document.createElement('option');
                option.value = akun.id;
                option.text = akun.nomor_akun + ' - ' + akun.nama_akun;
                akunSelect.appendChild(option);
            });

            // Restore previous selection if it still exists in the new list
            if (currentVal && list.find(a => a.id == currentVal)) {
                $(akunSelect).val(currentVal).trigger('change.select2');
            } else {
                $(akunSelect).val('').trigger('change.select2');
            }
        }

        $(document).ready(function() {
            $('.select2-search').select2({
                width: '100%',
                placeholder: function(){
                    $(this).data('placeholder');
                }
            });

            // Pre-populate all akun dropdowns with ALL akuns on page load
            populateAkuns('pem_akun_tujuan', null);
            populateAkuns('pem_akun_sumber', null);
            populateAkuns('peng_akun_tujuan', null);
            populateAkuns('peng_akun_sumber', null);

            // Listen for akun selection changes to auto-fill kategori
            $('#pem_akun_tujuan').on('change', function() { autoFillKategori(this.value, 'pem_kat_tujuan'); });
            $('#pem_akun_sumber').on('change', function() { autoFillKategori(this.value, 'pem_kat_sumber'); });
            $('#peng_akun_tujuan').on('change', function() { autoFillKategori(this.value, 'peng_kat_tujuan'); });
            $('#peng_akun_sumber').on('change', function() { autoFillKategori(this.value, 'peng_kat_sumber'); });
        });

        function switchTab(type) {
            const tabs = document.getElementsByClassName("tab-btn");
            const contents = document.getElementsByClassName("tab-content");
            
            for (let i = 0; i < contents.length; i++) {
                contents[i].classList.remove("active");
                tabs[i].classList.remove("active");
            }
            
            document.getElementById('form-' + type).classList.add("active");
            
            if (type === 'pemasukan') {
                tabs[0].classList.add("active");
            } else {
                tabs[1].classList.add("active");
            }
        }

        let isAutoFilling = false;

        // When kategori is selected manually, filter akuns
        function filterAkun(kategoriElementId, akunElementId) {
            if (isAutoFilling) {
                isAutoFilling = false;
                return; // Skip — this was triggered by autoFillKategori, not by user
            }
            const selectedKategoriId = document.getElementById(kategoriElementId).value;
            populateAkuns(akunElementId, selectedKategoriId || null);
        }

        // When akun is selected, auto-fill the paired kategori dropdown
        function autoFillKategori(akunId, kategoriElementId) {
            if (!akunId) return;
            const akun = allAkuns.find(a => a.id == akunId);
            if (akun && akun.kategori_id) {
                isAutoFilling = true;
                $('#' + kategoriElementId).val(akun.kategori_id).trigger('change');
            }
        }
    </script>
@endpush
