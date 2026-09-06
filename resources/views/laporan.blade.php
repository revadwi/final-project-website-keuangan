<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FinanceHub</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="logo.png" alt="Jobnation IT Outsource" style="max-width: 180px; height: auto; margin-top: -15px; margin-bottom: -15px; margin-left: -5px;">
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link" data-target="dashboard">
                            <i class="ri-home-5-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/kategori" class="nav-link" data-target="input-kategori">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Input Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/akun" class="nav-link" data-target="input-nama-akun">
                            <i class="ri-bank-card-line"></i>
                            <span>Input Nama Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/transaksi" class="nav-link" data-target="input-transaksi">
                            <i class="ri-file-add-line"></i>
                            <span>Input Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard#riwayat-transaksi" class="nav-link" data-target="riwayat-transaksi">
                            <i class="ri-history-line"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard#grafik" class="nav-link" data-target="grafik">
                            <i class="ri-bar-chart-box-line"></i>
                            <span>Grafik</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="/laporan" class="nav-link" data-target="laporan">
                            <i class="ri-file-list-3-line"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-bottom">
                    <a href="/index" class="nav-link logout-link">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header" style="position: relative; display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
                <div class="header-titles" style="text-align: center;">
                    <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: var(--text-dark);">Laporan</h1>
                </div>
                <div class="header-actions" style="position: absolute; right: 0;">
                    <button class="icon-btn">
                        <i class="ri-notification-3-line"></i>
                    </button>
                    <div class="user-profile">
                        <div class="avatar">
                            <img src="https://ui-avatars.com/api/?name=Admin+Finance&background=cbd5e1&color=334155" alt="User">
                        </div>
                        <div class="user-info">
                            <span class="user-name">Admin Finance</span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- View Sections Container -->
            <div id="view-laporan" class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">

                <!-- Header Laporan -->
                <div style="display: flex; justify-content: flex-end; align-items: flex-start; margin-bottom: 30px;">
                    <div style="position: relative; display: inline-block;">
                        <!-- Tombol Kalender Utama -->
                        <button onclick="var p = document.getElementById('calendar-popup-filter'); p.style.display = p.style.display === 'none' ? 'block' : 'none';" style="background: white; border: 1px solid var(--border-color); padding: 8px 15px 8px 35px; border-radius: 6px; font-size: 14px; font-weight: 500; color: var(--text-dark); cursor: pointer; outline: none; display: flex; align-items: center; gap: 8px; min-width: 220px; justify-content: space-between;">
                            <i class="ri-calendar-2-line" style="position: absolute; left: 12px; color: var(--text-muted);"></i>
                            <span id="calendar-display-text">Semua Waktu</span>
                            <i class="ri-arrow-down-s-line" style="color: var(--text-muted);"></i>
                        </button>
                        
                        <!-- Popup Kalender -->
                        <!-- Popup Kalender -->
                        <div id="calendar-popup-filter" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1px solid var(--border-color); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 20px; z-index: 100; width: 320px;">
                            <!-- Tabs (Harian, Bulanan, Tahunan) -->
                            <div style="display: flex; gap: 5px; margin-bottom: 20px; background: #f1f5f9; padding: 4px; border-radius: 8px;">
                                <button onclick="setCalMode('range')" id="btn-mode-range" style="flex:1; padding: 8px; background: white; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600; color:var(--text-dark); box-shadow:0 1px 3px rgba(0,0,0,0.1);">Harian</button>
                                <button onclick="setCalMode('month')" id="btn-mode-month" style="flex:1; padding: 8px; background: transparent; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:500; color:var(--text-muted);">Bulanan</button>
                                <button onclick="setCalMode('year')" id="btn-mode-year" style="flex:1; padding: 8px; background: transparent; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:500; color:var(--text-muted);">Tahunan</button>
                            </div>
                            
                            <!-- Konten Range Picker -->
                            <div id="cal-content-range">
                                <div style="margin-bottom: 15px;">
                                    <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Dari Tanggal</label>
                                    <input type="date" id="cal-input-start" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif;">
                                </div>
                                <div style="margin-bottom: 20px;">
                                    <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Sampai Tanggal</label>
                                    <input type="date" id="cal-input-end" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif;">
                                </div>
                            </div>
                            
                            <!-- Konten Month Picker -->
                            <div id="cal-content-month" style="display:none; margin-bottom: 20px;">
                                <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Pilih Bulan</label>
                                <input type="month" id="cal-input-month" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif;">
                            </div>
                            
                            <!-- Konten Year Picker -->
                            <div id="cal-content-year" style="display:none; margin-bottom: 20px;">
                                <label style="display:block; font-size:12px; font-weight:500; color:var(--text-muted); margin-bottom:5px;">Pilih Tahun</label>
                                <select id="cal-input-year" style="width: 100%; border: 1px solid var(--border-color); padding: 10px 12px; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'18\' height=\'18\'><path fill=\'none\' d=\'M0 0h24v24H0z\'/><path d=\'M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z\' fill=\'rgba(148,163,184,1)\'/></svg>') no-repeat right 12px center;">
                                    <option>2026</option>
                                    <option>2025</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                            </div>
                            
                            <div style="display:flex; justify-content:flex-end; gap:10px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                                <button onclick="document.getElementById('calendar-popup-filter').style.display='none'" style="padding: 8px 16px; background: white; border: 1px solid var(--border-color); border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; color: var(--text-dark);">Batal</button>
                                <button onclick="applyCalFilter()" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Terapkan</button>
                            </div>
                        </div>
                        
                        <script>
                            var currentCalMode = 'range';
                            var originalTableHtml = null;
                            
                            function setCalMode(mode) {
                                currentCalMode = mode;
                                // Reset buttons
                                document.getElementById('btn-mode-range').style.background = 'transparent';
                                document.getElementById('btn-mode-range').style.boxShadow = 'none';
                                document.getElementById('btn-mode-range').style.fontWeight = '500';
                                document.getElementById('btn-mode-range').style.color = 'var(--text-muted)';
                                
                                document.getElementById('btn-mode-month').style.background = 'transparent';
                                document.getElementById('btn-mode-month').style.boxShadow = 'none';
                                document.getElementById('btn-mode-month').style.fontWeight = '500';
                                document.getElementById('btn-mode-month').style.color = 'var(--text-muted)';
                                
                                document.getElementById('btn-mode-year').style.background = 'transparent';
                                document.getElementById('btn-mode-year').style.boxShadow = 'none';
                                document.getElementById('btn-mode-year').style.fontWeight = '500';
                                document.getElementById('btn-mode-year').style.color = 'var(--text-muted)';
                                
                                // Hide all contents
                                document.getElementById('cal-content-range').style.display = 'none';
                                document.getElementById('cal-content-month').style.display = 'none';
                                document.getElementById('cal-content-year').style.display = 'none';
                                
                                // Activate selected
                                document.getElementById('btn-mode-' + mode).style.background = 'white';
                                document.getElementById('btn-mode-' + mode).style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                                document.getElementById('btn-mode-' + mode).style.fontWeight = '600';
                                document.getElementById('btn-mode-' + mode).style.color = 'var(--text-dark)';
                                
                                document.getElementById('cal-content-' + mode).style.display = 'block';
                            }
                            
                            function applyCalFilter() {
                                var text = "Semua Waktu";
                                var title = "Ringkasan Semua Waktu";
                                var colHeader = "Waktu";
                                
                                if (currentCalMode === 'range') {
                                    var start = document.getElementById('cal-input-start').value;
                                    var end = document.getElementById('cal-input-end').value;
                                    if (start && end) {
                                        text = start + " s/d " + end;
                                    } else if (start) {
                                        text = "Mulai " + start;
                                    } else if (end) {
                                        text = "Sampai " + end;
                                    }
                                    title = "Ringkasan Harian";
                                    colHeader = "Tanggal";
                                } else if (currentCalMode === 'month') {
                                    var val = document.getElementById('cal-input-month').value;
                                    if (val) {
                                        var parts = val.split('-');
                                        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                        if (parts.length === 2) {
                                            text = months[parseInt(parts[1]) - 1] + " " + parts[0];
                                        }
                                    }
                                    title = "Ringkasan Bulanan";
                                    colHeader = "Bulan";
                                } else if (currentCalMode === 'year') {
                                    var val = document.getElementById('cal-input-year').value;
                                    if (val) text = "Tahun " + val;
                                    title = "Ringkasan Tahunan";
                                    colHeader = "Tahun";
                                }
                                
                                document.getElementById('calendar-display-text').textContent = text;
                                document.getElementById('calendar-popup-filter').style.display = 'none';
                                
                                var titleEl = document.getElementById('tabel-title');
                                if (titleEl) titleEl.textContent = title;
                                var colEl = document.getElementById('tabel-col-header');
                                if (colEl) colEl.textContent = colHeader;
                                
                                var tbody = document.getElementById('tabel-body');
                                if (tbody) {
                                    if (!originalTableHtml) {
                                        originalTableHtml = tbody.innerHTML;
                                    }
                                    
                                    var valSaldo = document.getElementById('card-val-saldo');
                                    var valKeluar = document.getElementById('card-val-pengeluaran');
                                    var valMasuk = document.getElementById('card-val-pemasukan');
                                    
                                    if (currentCalMode === 'range') {
                                        tbody.innerHTML = `
                                            <tr><td colspan="2">01 Sep 2026</td><td>15.000</td><td>0</td><td class="text-red">-15.000</td></tr>
                                            <tr><td colspan="2">02 Sep 2026</td><td>50.000</td><td>100.000</td><td>50.000</td></tr>
                                            <tr><td colspan="2">03 Sep 2026</td><td>10.000</td><td>0</td><td class="text-red">-10.000</td></tr>
                                            <tr><td colspan="2">04 Sep 2026</td><td>0</td><td>250.000</td><td>250.000</td></tr>
                                            <tr><td colspan="2">05 Sep 2026</td><td>100.000</td><td>0</td><td class="text-red">-100.000</td></tr>
                                        `;
                                        if (valSaldo) valSaldo.textContent = "175.000";
                                        if (valKeluar) valKeluar.textContent = "175.000";
                                        if (valMasuk) valMasuk.textContent = "350.000";
                                    } else if (currentCalMode === 'year') {
                                        tbody.innerHTML = `
                                            <tr><td colspan="2">2026</td><td>589.983.664</td><td>696.492.777</td><td>106.509.113</td></tr>
                                            <tr><td colspan="2">2025</td><td>125.400.000</td><td>150.000.000</td><td>24.600.000</td></tr>
                                            <tr><td colspan="2">2024</td><td>90.000.000</td><td>95.000.000</td><td>5.000.000</td></tr>
                                        `;
                                        if (valSaldo) valSaldo.textContent = "136.109.113";
                                        if (valKeluar) valKeluar.textContent = "805.383.664";
                                        if (valMasuk) valMasuk.textContent = "941.492.777";
                                    } else {
                                        tbody.innerHTML = originalTableHtml;
                                        if (valSaldo) valSaldo.textContent = "106.509.113";
                                        if (valKeluar) valKeluar.textContent = "589.983.664";
                                        if (valMasuk) valMasuk.textContent = "696.492.777";
                                    }
                                }
                            }
                        </script>
                    </div>
                </div>

                <!-- Pilihan Laporan & Ringkasan -->
                <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
                    <!-- Ringkasan Cards (Pengeluaran & Pemasukan) -->
                    <div style="flex: 1; width: 100%; display: flex; gap: 20px;">
                        
                        <!-- Saldo Total Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #2563eb; border-radius: 12px; box-shadow: 0 4px 15px rgba(37,99,235,0.2); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, background 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='#1d4ed8';" onmouseout="this.style.transform='translateY(0)'; this.style.background='#2563eb';">
                            <div style="font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Saldo total</div>
                            <div id="card-val-saldo" style="font-size: 28px; font-weight: 700; color: white; letter-spacing: 0.5px;">106.509.113</div>
                        </div>

                        <!-- Pengeluaran Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #2563eb; border-radius: 12px; box-shadow: 0 4px 15px rgba(37,99,235,0.2); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, background 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='#1d4ed8';" onmouseout="this.style.transform='translateY(0)'; this.style.background='#2563eb';">
                            <div style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 5px;">Pengeluaran</div>
                            <div id="card-val-pengeluaran" style="font-size: 20px; font-weight: 600; color: white; letter-spacing: 0.5px;">589.983.664</div>
                        </div>

                        <!-- Pemasukan Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #2563eb; border-radius: 12px; box-shadow: 0 4px 15px rgba(37,99,235,0.2); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, background 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='#1d4ed8';" onmouseout="this.style.transform='translateY(0)'; this.style.background='#2563eb';">
                            <div style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 5px;">Pemasukan</div>
                            <div id="card-val-pemasukan" style="font-size: 20px; font-weight: 600; color: white; letter-spacing: 0.5px;">696.492.777</div>
                        </div>

                    </div>
                </div>

                <!-- Tabel Ringkasan Bulanan -->
                <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--border-color); overflow: hidden;">
                    <!-- Header Tabel -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid #f1f5f9;">
                        <h3 id="tabel-title" style="font-size: 18px; font-weight: 700; color: var(--text-dark); margin: 0;">Ringkasan Bulanan</h3>
                        
                        <button onclick="downloadExcel()" style="display: flex; align-items: center; gap: 8px; background: white; color: #10b981; border: 1px solid #10b981; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.backgroundColor='#10b981'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#10b981';">
                            <i class="ri-file-excel-2-line" style="font-size: 16px;"></i>
                            Unduh Excel
                        </button>
                    </div>
                    
                    <!-- Table content -->
                    <div style="overflow-x: auto;">
                        <style>
                            .laporan-table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            .laporan-table th, .laporan-table td {
                                padding: 15px 25px;
                                text-align: left;
                                font-size: 14px;
                            }
                            .laporan-table th {
                                font-weight: 700;
                                color: var(--text-dark);
                                border-bottom: 1px solid #f1f5f9;
                                background: #f8fafc;
                            }
                            .laporan-table tr {
                                border-bottom: 1px solid #f1f5f9;
                            }
                            .laporan-table tr:last-child {
                                border-bottom: none;
                            }
                            .text-red { color: #ef4444; }
                        </style>
                        <table class="laporan-table" id="tabel-ringkasan">
                            <thead>
                                <tr>
                                    <th id="tabel-col-header" colspan="2">Bulan</th>
                                    <th>Pengeluaran</th>
                                    <th>Pemasukan</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-body">
                                <!-- 2026 Data -->
                                <tr>
                                    <td rowspan="9" style="vertical-align: middle; font-weight: 700; color: var(--text-dark); width: 80px; border-right: 1px solid #f1f5f9; text-align: center;">2026</td>
                                    <td>Sep</td>
                                    <td>119.275</td>
                                    <td>1.300.000</td>
                                    <td>1.180.725</td>
                                </tr>
                                <tr>
                                    <td>Agu</td>
                                    <td>33.658.862</td>
                                    <td>45.040.702</td>
                                    <td>11.381.840</td>
                                </tr>
                                <tr>
                                    <td>Jul</td>
                                    <td>60.665.495</td>
                                    <td>31.402.940</td>
                                    <td class="text-red">-29.262.555</td>
                                </tr>
                                <tr>
                                    <td>Jun</td>
                                    <td>40.528.911</td>
                                    <td>48.160.258</td>
                                    <td>7.631.347</td>
                                </tr>
                                <tr>
                                    <td>Mei</td>
                                    <td>33.447.797</td>
                                    <td>42.360.460</td>
                                    <td>8.912.663</td>
                                </tr>
                                <tr>
                                    <td>Apr</td>
                                    <td>34.890.788</td>
                                    <td>46.579.591</td>
                                    <td>11.688.803</td>
                                </tr>
                                <tr>
                                    <td>Mar</td>
                                    <td>37.518.514</td>
                                    <td>46.905.643</td>
                                    <td>9.387.129</td>
                                </tr>
                                <tr>
                                    <td>Feb</td>
                                    <td>45.689.704</td>
                                    <td>55.884.032</td>
                                    <td>10.194.328</td>
                                </tr>
                                <tr>
                                    <td>Jan</td>
                                    <td>43.333.332</td>
                                    <td>60.237.124</td>
                                    <td>16.903.792</td>
                                </tr>
                                
                                <!-- 2025 Data -->
                                <tr style="border-top: 1px solid #e2e8f0;">
                                    <td rowspan="4" style="vertical-align: middle; font-weight: 700; color: var(--text-dark); border-right: 1px solid #f1f5f9; text-align: center;">2025</td>
                                    <td>Des</td>
                                    <td>41.328.886</td>
                                    <td>55.492.794</td>
                                    <td>14.163.908</td>
                                </tr>
                                <tr>
                                    <td>Nov</td>
                                    <td>18.866.380</td>
                                    <td>29.422.003</td>
                                    <td>10.555.623</td>
                                </tr>
                                <tr>
                                    <td>Okt</td>
                                    <td>32.078.568</td>
                                    <td>32.441.497</td>
                                    <td>362.929</td>
                                </tr>
                                <tr>
                                    <td>Sep</td>
                                    <td>47.235.680</td>
                                    <td>39.148.983</td>
                                    <td class="text-red">-8.086.697</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            </main>

    </div>

    <!-- Chart Configuration Script -->
    <script>
        // Cashflow Chart (Line/Area)
        const cashflowEl = document.getElementById('cashflowChart');
        if (cashflowEl) {
        const ctxLine = cashflowEl.getContext('2d');
        
        // Gradient for Pemasukan
        const gradientBlue = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, 'rgba(29, 78, 216, 0.2)');
        gradientBlue.addColorStop(1, 'rgba(29, 78, 216, 0)');

        // Gradient for Pengeluaran
        const gradientCyan = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientCyan.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradientCyan.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: [32, 55, 49, 58, 75, 53, 56, 50, 75, 65, 82, 75], // sample data in millions
                        borderColor: '#1d4ed8', // Dark Toska
                        backgroundColor: gradientBlue,
                        borderWidth: 2,
                        pointBackgroundColor: '#1d4ed8',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Pengeluaran',
                        data: [12, 31, 40, 24, 32, 35, 25, 52, 27, 42, 49, 54], // sample data in millions
                        borderColor: '#10b981', // Toska
                        backgroundColor: gradientCyan,
                        borderWidth: 2,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'start',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            boxHeight: 8,
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1e293b',
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#94a3b8', font: { family: "'Inter', sans-serif", size: 12 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9', drawBorder: false, borderDash: [5, 5] },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: "'Inter', sans-serif", size: 12 },
                            callback: function(value) {
                                return value + 'M';
                            },
                            stepSize: 25,
                            max: 100,
                            min: 0
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        }

        // Category Chart (Donut)
        const donutEl = document.getElementById('categoryChart');
        if (donutEl) {
        const ctxDonut = donutEl.getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Operasional', 'Gaji & Upah', 'Marketing', 'Lainnya'],
                datasets: [{
                    data: [40, 30, 15, 15],
                    backgroundColor: [
                        '#1d4ed8', // Blue
                        '#10b981', // Green
                        '#60a5fa', // Light Blue
                        '#34d399'  // Light Green
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // makes it a thin donut
                plugins: {
                    legend: {
                        display: false // We use custom HTML legend
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });

                }

        // Terapkan aturan tampilan berdasarkan Role dari localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const userRole = localStorage.getItem('userRole');
            const userEmail = localStorage.getItem('userEmail');
            
            // Set nama user dari email
            if (userEmail) {
                const nameDisplay = userEmail.split('@')[0];
                document.querySelector('.user-name').textContent = nameDisplay;
            }

            if (userRole === 'viewer') {
                // Ubah role pengguna
                document.querySelector('.user-role').textContent = 'Viewer';
                
                // Sembunyikan menu-menu Admin (User Management & Pengaturan)
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    const text = item.textContent.trim();
                    if (text.includes('User Management') || text.includes('Pengaturan')) {
                        item.style.display = 'none';
                    }
                });
                
                // Sembunyikan tombol-tombol atau aksi yang tidak boleh diakses viewer
                const actionLinks = document.querySelectorAll('a.btn-outline, button.action-btn');
                actionLinks.forEach(link => {
                    link.style.display = 'none'; 
                });

                // Disable forms
                document.querySelectorAll('input, select').forEach(inp => {
                    inp.disabled = true;
                });
            } else {
                // Set default tampilan ke Administrator
                document.querySelector('.user-role').textContent = 'Administrator';
                
                // Aktifkan fitur Download PDF
                const btnPdf = document.getElementById('btn-download-pdf');
                if (btnPdf) {
                    btnPdf.addEventListener('click', function() {
                        // Membuat dummy file text untuk mensimulasikan PDF
                        const text = "Laporan Keuangan Bulan Agustus 2026\n\nTotal Saldo: Rp 245.000.000\nPemasukan: Rp 120.500.000\nPengeluaran: Rp 75.200.000";
                        const blob = new Blob([text], { type: 'text/plain' });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'Laporan_Agustus.txt'; // Menggunakan txt agar bisa dibuka langsung sebagai simulasi
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                        alert("File laporan telah berhasil diunduh!");
                    });
                }

                // Aktifkan fitur Download Excel
                const btnExcel = document.getElementById('btn-download-excel');
                if (btnExcel) {
                    btnExcel.addEventListener('click', function() {
                        // Membuat file CSV sederhana sebagai simulasi Excel
                        const csv = "Tanggal,Keterangan,Jumlah\n01 Sept 2026,Pendapatan Proyek IT,25000000\n28 Agu 2026,Pencairan Invoice,12500000\n25 Agu 2026,Sewa Cloud Server,-5200000";
                        const blob = new Blob([csv], { type: 'text/csv' });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'Data_Transaksi.csv'; // CSV file yang bisa dibuka di Excel
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                        alert("File data transaksi (CSV) telah berhasil diunduh!");
                    });
                }
            }
        });
    </script>

    <script>
        function downloadExcel() {
            var table = document.getElementById("tabel-ringkasan");
            var rows = table.querySelectorAll("tr");
            var csv = [];
            
            // Parse table to CSV
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");
                
                for (var j = 0; j < cols.length; j++) {
                    // Strip HTML and get inner text
                    var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").trim();
                    // Escape double quotes
                    data = data.replace(/"/g, '""');
                    // Quote the string
                    row.push('"' + data + '"');
                }
                csv.push(row.join(","));
            }
            
            var csvContent = csv.join("\n");
            
            // Get current period from the filter button text
            var periodText = document.getElementById("calendar-display-text").innerText || "Semua_Waktu";
            var period = periodText.replace(/[^a-zA-Z0-9]/g, "_"); // sanitize filename
            var filename = "Laporan_Keuangan_" + period + ".csv";
            
            // Trigger download
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement("a");
            if (link.download !== undefined) {
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    </script>

</body>
</html>
