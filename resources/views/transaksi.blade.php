<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi - FinanceHub</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="logo.png" alt="FinanceHub" style="max-width: 180px; height: auto; margin-top: -15px; margin-bottom: -15px; margin-left: -5px;">
                </div>
            </div>
            <!-- nav -->
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item"><a href="/dashboard" class="nav-link"><i class="ri-home-5-line"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a href="/kategori" class="nav-link"><i class="ri-price-tag-3-line"></i><span>Input Kategori</span></a></li>
                    <li class="nav-item"><a href="/akun" class="nav-link"><i class="ri-bank-card-line"></i><span>Input Nama Akun</span></a></li>
                    <li class="nav-item"><a href="/transaksi" class="nav-link" style="background: rgba(255,255,255,0.1); border-radius: 8px;"><i class="ri-file-add-line"></i><span>Input Transaksi</span></a></li>
                    <li class="nav-item"><a href="/dashboard#riwayat-transaksi" class="nav-link"><i class="ri-history-line"></i><span>Riwayat Transaksi</span></a></li>
                    <li class="nav-item"><a href="/dashboard#grafik" class="nav-link"><i class="ri-bar-chart-box-line"></i><span>Grafik</span></a></li>
                    <li class="nav-item"><a href="/laporan" class="nav-link"><i class="ri-file-list-3-line"></i><span>Laporan</span></a></li>
                </ul>
                <div class="nav-bottom">
                    <a href="/login" class="nav-link logout-link">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <div style="max-width: 900px; margin: 0 auto; padding-top: 10px;">
                <div class="page-header" style="display: flex; justify-content: center; width: 100%;">
                    <h1 style="margin-bottom: 0;">Input Transaksi</h1>
                </div>

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
                        <form action="{{ route('transaksi.store') }}" method="POST">
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

                            <div class="form-actions">
                                <button type="button" class="btn btn-cancel" onclick="window.location.href='/dashboard'">Batal</button>
                                <button type="submit" class="btn btn-save">Simpan Pemasukan</button>
                            </div>
                        </form>
                    </div>

                    <!-- FORM PENGELUARAN -->
                    <div id="form-pengeluaran" class="tab-content">
                        <form action="{{ route('transaksi.store') }}" method="POST">
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

                            <div class="form-actions">
                                <button type="button" class="btn btn-cancel" onclick="window.location.href='/dashboard'">Batal</button>
                                <button type="submit" class="btn btn-save btn-danger">Simpan Pengeluaran</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const allAkuns = @json($akuns);

        $(document).ready(function() {
            $('.select2-search').select2({
                width: '100%',
                placeholder: function(){
                    $(this).data('placeholder');
                }
            });
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

        function filterAkun(kategoriElementId, akunElementId) {
            const selectedKategoriId = document.getElementById(kategoriElementId).value;
            const akunSelect = document.getElementById(akunElementId);
            
            akunSelect.innerHTML = '<option value="">-- Pilih Akun --</option>';
            
            if (selectedKategoriId) {
                const filteredAkuns = allAkuns.filter(akun => akun.kategori_id == selectedKategoriId);
                
                filteredAkuns.forEach(akun => {
                    const option = document.createElement('option');
                    option.value = akun.id;
                    option.text = akun.nomor_akun + ' - ' + akun.nama_akun;
                    akunSelect.appendChild(option);
                });
            }
            
            $(akunSelect).trigger('change');
        }
    </script>
</body>
</html>
