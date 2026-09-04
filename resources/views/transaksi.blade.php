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
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        .tabs {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .tab-btn {
            padding: 12px 24px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s ease;
        }
        .tab-btn:hover {
            color: #1e293b;
        }
        .tab-btn.active {
            color: #1d4ed8;
            border-bottom-color: #1d4ed8;
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .btn-primary {
            background-color: #1d4ed8;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #1e40af;
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }
        
        /* Select2 Custom Styles */
        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #0f172a;
            line-height: normal;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .card-form {
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .account-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 15px;
        }
        .account-section h4 {
            margin-bottom: 10px;
            color: #334155;
            font-size: 14px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
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
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <i class="ri-home-5-line"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/kategori" class="nav-link">
                            <i class="ri-price-tag-3-line"></i><span>Input Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/akun" class="nav-link">
                            <i class="ri-bank-card-line"></i><span>Input Nama Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/transaksi" class="nav-link" style="background: rgba(255,255,255,0.1); border-radius: 8px;">
                            <i class="ri-file-add-line"></i><span>Input Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="ri-history-line"></i><span>Riwayat Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="ri-bar-chart-box-line"></i><span>Grafik</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/laporan" class="nav-link">
                            <i class="ri-file-list-3-line"></i><span>Laporan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-titles">
                    <h1>Input Transaksi</h1>
                    <p>Catat Pemasukan dan Pengeluaran</p>
                </div>
            </header>

            <div class="view-section active" style="display: block; padding: 30px; background: white; border-radius: 12px; margin-top: 20px; max-width: 800px; margin-left: auto; margin-right: auto;">
                
                @if(session('success'))
                    <div class="alert-success">
                        <i class="ri-checkbox-circle-line" style="margin-right: 8px;"></i> {{ session('success') }}
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
                    <button class="tab-btn active" onclick="openTab('pemasukan', this)">Catat Pemasukan</button>
                    <button class="tab-btn" onclick="openTab('pengeluaran', this)">Catat Pengeluaran</button>
                </div>
                
                <!-- TAB PEMASUKAN -->
                <div id="pemasukan" class="tab-content active">
                    <form action="{{ route('transaksi.store') }}" method="POST" class="card-form">
                        @csrf
                        <input type="hidden" name="jenis_transaksi" value="Pemasukan">
                        
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Akun Tujuan (Debit) -->
                        <div class="account-section">
                            <h4><i class="ri-download-line" style="color: #10b981;"></i> Pilih Akun Tujuan (Uang Masuk Ke Mana)</h4>
                            <div style="display: flex; gap: 15px;">
                                <div class="form-group" style="flex: 1;">
                                    <label>Kategori</label>
                                    <select class="select2-search" id="pem_kat_tujuan" onchange="filterAkun('pem_kat_tujuan', 'pem_akun_tujuan')">
                                        <option value="">-- Cari/Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <label>Nama Akun</label>
                                    <select class="select2-search" name="akun_debit_id" id="pem_akun_tujuan" required>
                                        <option value="">-- Pilih Akun --</option>
                                        <!-- Populated via JS -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Akun Sumber (Kredit) -->
                        <div class="account-section">
                            <h4><i class="ri-upload-line" style="color: #f59e0b;"></i> Pilih Akun Sumber (Uang Berasal Dari Mana)</h4>
                            <div style="display: flex; gap: 15px;">
                                <div class="form-group" style="flex: 1;">
                                    <label>Kategori</label>
                                    <select class="select2-search" id="pem_kat_sumber" onchange="filterAkun('pem_kat_sumber', 'pem_akun_sumber')">
                                        <option value="">-- Cari/Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <label>Nama Akun</label>
                                    <select class="select2-search" name="akun_kredit_id" id="pem_akun_sumber" required>
                                        <option value="">-- Pilih Akun --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan Transaksi</label>
                            <input type="text" name="keterangan" required placeholder="Contoh: Penerimaan Pendapatan Jasa">
                        </div>
                        
                        <div class="form-group">
                            <label>Jumlah (Rp)</label>
                            <input type="number" name="jumlah" required min="1" placeholder="0">
                        </div>

                        <button type="submit" class="btn-primary">Simpan Pemasukan</button>
                    </form>
                </div>
                
                <!-- TAB PENGELUARAN -->
                <div id="pengeluaran" class="tab-content">
                    <form action="{{ route('transaksi.store') }}" method="POST" class="card-form">
                        @csrf
                        <input type="hidden" name="jenis_transaksi" value="Pengeluaran">
                        
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Akun Tujuan (Debit) -->
                        <div class="account-section">
                            <h4><i class="ri-money-dollar-box-line" style="color: #ef4444;"></i> Pilih Akun Tujuan (Untuk Keperluan Apa)</h4>
                            <div style="display: flex; gap: 15px;">
                                <div class="form-group" style="flex: 1;">
                                    <label>Kategori</label>
                                    <select class="select2-search" id="peng_kat_tujuan" onchange="filterAkun('peng_kat_tujuan', 'peng_akun_tujuan')">
                                        <option value="">-- Cari/Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <label>Nama Akun</label>
                                    <select class="select2-search" name="akun_debit_id" id="peng_akun_tujuan" required>
                                        <option value="">-- Pilih Akun --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Akun Sumber (Kredit) -->
                        <div class="account-section">
                            <h4><i class="ri-bank-card-line" style="color: #3b82f6;"></i> Pilih Akun Sumber (Dibayar Menggunakan Apa)</h4>
                            <div style="display: flex; gap: 15px;">
                                <div class="form-group" style="flex: 1;">
                                    <label>Kategori</label>
                                    <select class="select2-search" id="peng_kat_sumber" onchange="filterAkun('peng_kat_sumber', 'peng_akun_sumber')">
                                        <option value="">-- Cari/Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <label>Nama Akun</label>
                                    <select class="select2-search" name="akun_kredit_id" id="peng_akun_sumber" required>
                                        <option value="">-- Pilih Akun --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan Transaksi</label>
                            <input type="text" name="keterangan" required placeholder="Contoh: Pembayaran Listrik Bulan Ini">
                        </div>
                        
                        <div class="form-group">
                            <label>Jumlah (Rp)</label>
                            <input type="number" name="jumlah" required min="1" placeholder="0">
                        </div>

                        <button type="submit" class="btn-primary" style="background-color: #ef4444;">Simpan Pengeluaran</button>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Data Akun dari Database
        const allAkuns = @json($akuns);

        $(document).ready(function() {
            // Initialize Select2 on all elements with class select2-search
            $('.select2-search').select2({
                width: '100%',
                placeholder: function(){
                    $(this).data('placeholder');
                }
            });
        });

        // Tab Switching Logic
        function openTab(tabName, elmnt) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            document.getElementById(tabName).classList.add("active");
            elmnt.classList.add("active");
        }

        // Dependent Dropdown Logic
        function filterAkun(kategoriElementId, akunElementId) {
            const selectedKategoriId = document.getElementById(kategoriElementId).value;
            const akunSelect = document.getElementById(akunElementId);
            
            // Clear current options
            akunSelect.innerHTML = '<option value="">-- Pilih Akun --</option>';
            
            // Filter and append new options
            if (selectedKategoriId) {
                const filteredAkuns = allAkuns.filter(akun => akun.kategori_id == selectedKategoriId);
                
                filteredAkuns.forEach(akun => {
                    const option = document.createElement('option');
                    option.value = akun.id;
                    option.text = akun.nomor_akun + ' - ' + akun.nama_akun;
                    akunSelect.appendChild(option);
                });
            }
            
            // Trigger Select2 to update the UI
            $(akunSelect).trigger('change');
        }
    </script>
</body>
</html>
