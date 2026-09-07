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
                    <li class="nav-item active">
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
                        <a href="#" class="nav-link" data-target="riwayat-transaksi">
                            <i class="ri-history-line"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-target="grafik">
                            <i class="ri-bar-chart-box-line"></i>
                            <span>Grafik</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-target="laporan">
                            <i class="ri-file-list-3-line"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-bottom">
                    <a href="/login" class="nav-link logout-link">
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
            <div id="view-dashboard" class="view-section active" style="display: block;">
                <!-- Stats Grid -->
            <div class="stats-grid">
                <!-- Stat Card 1 -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon icon-blue">
                            <i class="ri-wallet-3-line"></i>
                        </div>
                        <span class="stat-title">Total Saldo</span>
                    </div>
                    <div class="stat-value">Rp 245.000.000</div>
                    <div class="stat-change positive">
                        <span>+12.5%</span> dari bulan lalu
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon icon-green">
                            <i class="ri-arrow-left-down-line"></i>
                        </div>
                        <span class="stat-title">Total Pemasukan</span>
                    </div>
                    <div class="stat-value">Rp 120.500.000</div>
                    <div class="stat-change positive">
                        <span>+8.3%</span> dari bulan lalu
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon icon-red">
                            <i class="ri-arrow-right-up-line"></i>
                        </div>
                        <span class="stat-title">Total Pengeluaran</span>
                    </div>
                    <div class="stat-value">Rp 75.200.000</div>
                    <div class="stat-change negative">
                        <span>-3.6%</span> dari bulan lalu
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon icon-purple">
                            <i class="ri-safe-2-line"></i>
                        </div>
                        <span class="stat-title">Sisa Anggaran</span>
                    </div>
                    <div class="stat-value">Rp 45.300.000</div>
                    <div class="stat-change positive">
                        <span>+15.2%</span> dari bulan lalu
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Line Chart -->
                <div class="chart-card line-chart-card">
                    <div class="chart-header">
                        <h3>Grafik Arus Kas</h3>
                        <select class="chart-select">
                            <option>Tahun ini</option>
                            <option>Tahun lalu</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="cashflowChart"></canvas>
                    </div>
                </div>

                <!-- Donut Chart -->
                <div class="chart-card donut-chart-card">
                    <div class="chart-header">
                        <h3>Kategori Pengeluaran</h3>
                    </div>
                    <div class="chart-container donut-container">
                        <canvas id="categoryChart"></canvas>
                        <div class="donut-inner-text">
                            <span class="donut-label">Total</span>
                            <span class="donut-value">Rp 75.200.000</span>
                        </div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="dot dot-blue"></span>
                            <span class="legend-label">Operasional</span>
                            <span class="legend-value">40%</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot dot-cyan"></span>
                            <span class="legend-label">Gaji & Upah</span>
                            <span class="legend-value">30%</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot dot-light-blue"></span>
                            <span class="legend-label">Marketing</span>
                            <span class="legend-value">15%</span>
                        </div>
                        <div class="legend-item">
                            <span class="dot dot-orange"></span>
                            <span class="legend-label">Lainnya</span>
                            <span class="legend-value">15%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="recent-transactions">
                <div class="section-header">
                    <h3>Transaksi Terbaru</h3>
                    <a href="#" class="btn-outline">Lihat Semua</a>
                </div>
                <!-- Since the image is cut off, we add a placeholder for the table -->
                <div class="transactions-list">
                    <p style="color: #8c9eae; font-size: 14px; padding: 20px 0;">Menampilkan data transaksi terbaru...</p>
                </div>
            </div>
            </div> <!-- End of view-dashboard -->

            <!-- New View Sections (Hidden by default) -->
            <div id="view-riwayat-transaksi" class="view-section" style="display: none;">
                <div class="riwayat-container">
                    <!-- Top Summary Header (Blue) -->
                    <div class="riwayat-header-blue">
                        <label class="rh-date-picker" style="position: relative; display: flex;" onclick="try { document.getElementById('riwayat-month-picker').showPicker(); } catch(e) {}">
                            <input type="month" id="riwayat-month-picker" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;" value="2026-09">
                            <span class="rh-year" id="rh-year-display">2026</span>
                            <div class="rh-month">
                                <span id="rh-month-display">Sep</span> <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </label>
                        <div class="rh-stat">
                            <span class="rh-label">Pengeluaran</span>
                            <span class="rh-value" id="rh-pengeluaran-val">0</span>
                        </div>
                        <div class="rh-stat">
                            <span class="rh-label">Pemasukan</span>
                            <span class="rh-value" id="rh-pemasukan-val">0</span>
                        </div>
                        <div class="rh-stat">
                            <span class="rh-label">Saldo</span>
                            <span class="rh-value" id="rh-saldo-val">0</span>
                        </div>
                    </div>
                    
                    <!-- Transactions List -->
                    <div class="riwayat-list-content">
                        <!-- Group by Date 1 -->
                        <div class="riwayat-date-group">
                            <div class="rdg-header">
                                <div class="rdg-date">04 Sep &nbsp;<span class="rdg-day">Jumat</span></div>
                                <div class="rdg-summary">Pengeluaran: 2.500.000 &nbsp; Pemasukan: 0</div>
                            </div>
                            
                            <div class="rdg-items">
                                <!-- Transaction Item -->
                                <div class="rdg-item nav-link-custom" data-target="detail-transaksi">
                                    <div class="rdg-icon icon-blue">
                                        <i class="ri-server-line"></i>
                                    </div>
                                    <div class="rdg-info">
                                        <div class="rdg-title">Pembayaran Hosting Tahunan</div>
                                    </div>
                                    <div class="rdg-amount amount-negative">
                                        -2.500.000
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group by Date 2 -->
                        <div class="riwayat-date-group">
                            <div class="rdg-header">
                                <div class="rdg-date">02 Sep &nbsp;<span class="rdg-day">Rabu</span></div>
                                <div class="rdg-summary">Pengeluaran: 0 &nbsp; Pemasukan: 15.000.000</div>
                            </div>
                            
                            <div class="rdg-items">
                                <!-- Transaction Item -->
                                <div class="rdg-item nav-link-custom" data-target="detail-transaksi">
                                    <div class="rdg-icon icon-green">
                                        <i class="ri-briefcase-line"></i>
                                    </div>
                                    <div class="rdg-info">
                                        <div class="rdg-title">Pemasukan Proyek A</div>
                                    </div>
                                    <div class="rdg-amount amount-positive">
                                        15.000.000
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group by Date 3 -->
                        <div class="riwayat-date-group">
                            <div class="rdg-header">
                                <div class="rdg-date">28 Agu &nbsp;<span class="rdg-day">Jumat</span></div>
                                <div class="rdg-summary">Pengeluaran: 4.200.000 &nbsp; Pemasukan: 0</div>
                            </div>
                            
                            <div class="rdg-items">
                                <!-- Transaction Item -->
                                <div class="rdg-item nav-link-custom" data-target="detail-transaksi">
                                    <div class="rdg-icon icon-orange">
                                        <i class="ri-computer-line"></i>
                                    </div>
                                    <div class="rdg-info">
                                        <div class="rdg-title">Pembelian Inventaris Kantor</div>
                                    </div>
                                    <div class="rdg-amount amount-negative">
                                        -4.200.000
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi Section -->

            <!-- Detail Transaksi Section -->
            <div id="view-detail-transaksi" class="view-section" style="display: none; width: 100%;">
                <div class="detail-card" style="background: var(--bg-card); border-radius: 16px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%;">
                    <!-- Header with Back Button (Left) and Centered Content -->
                    <div style="position: relative; text-align: center; margin-bottom: 40px;">
                        <button class="btn btn-secondary nav-link-custom" data-target="riwayat-transaksi" style="position: absolute; left: 0; top: 0; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-main); font-size: 20px;">
                            <i class="ri-arrow-left-line"></i>
                        </button>
                        
                        <div class="dt-icon-circle" id="dt-icon-color" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; margin: 0 auto 15px auto;">
                            <i class="ri-global-line" id="dt-icon-class"></i>
                        </div>
                        <h2 id="dt-title" style="font-size: 20px; color: var(--text-dark); margin-bottom: 0; font-weight: 600;">bulanan</h2>
                    </div>
                    
                    <!-- Detail Rows -->
                    <div class="detail-body" style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nama Project</div>
                            <div id="dt-tipe" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nomor Urut Piutang</div>
                            <div style="text-align: right; flex: 1;">
                                <div style="color: var(--text-dark); font-weight: 600; font-size: 16px;"><span id="dt-jumlah-utama">0</span></div>
                                <div style="color: var(--text-muted); font-size: 12px; margin-top: 4px;">(IDR <span id="dt-jumlah-sub">0</span>)</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nomor Urut Hutang</div>
                            <div style="text-align: right; flex: 1;">
                                <div style="color: var(--text-dark); font-weight: 500; font-size: 15px;"><span id="dt-tanggal-utama">-</span></div>
                                <div style="color: var(--text-muted); font-size: 12px; margin-top: 4px;">( <span id="dt-tanggal-sub">-</span> )</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Aktivitas Arus Kas</div>
                            <div id="dt-catatan" style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Kategori Nama Akun</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nomor Akun</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Nama Akun</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">Kas</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Catatan Aset Tetap</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Deskripsi Transaksi</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">DEBET</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">KREDIT</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Saldo (Balance)</div>
                            <div style="color: var(--text-dark); font-weight: 500; text-align: right; flex: 1;">-</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 15px;">
                            <div style="color: var(--text-muted); font-size: 14px; width: 150px;">Dokumentasi</div>
                            <div style="text-align: right; flex: 1; display: flex; justify-content: flex-end;">
                                <div style="width: 80px; height: 80px; background-color: var(--bg-main); border: 1px dashed var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 24px;">
                                    <i class="ri-image-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer / Button -->
                    <div class="detail-footer" style="margin-top: 40px;">
                        <button class="btn" style="width: 100%; padding: 15px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; border: none; background: var(--primary); color: white;">
                            Edit
                        </button>
                    </div>
                </div>
            </div>


            <!-- Grafik Section -->
            <div id="view-grafik" class="view-section" style="display: none;">
                <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: 700; color: var(--text-dark); text-align: center;">Grafik</h3>
                <div style="width: 100%; background: var(--bg-card); border-radius: 16px; padding: 25px 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    
                    <!-- Header Controls -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                        <!-- Segmented Control -->
                        <div style="display: flex; background: #f1f5f9; border-radius: 8px; padding: 4px; width: 80%;">
                            <button id="btn-toggle-pemasukan" onclick="toggleGrafikView('pemasukan')" style="flex: 1; padding: 10px 0; background: transparent; border: none; font-weight: 500; color: var(--text-muted); cursor: pointer; font-size: 14px;">Pemasukan</button>
                            <button id="btn-toggle-pengeluaran" onclick="toggleGrafikView('pengeluaran')" style="flex: 1; padding: 10px 0; background: #ffffff; border: none; border-radius: 6px; font-weight: 600; color: var(--text-dark); box-shadow: 0 2px 5px rgba(0,0,0,0.05); cursor: pointer; font-size: 14px;">Pengeluaran</button>
                        </div>
                        <!-- Calendar Icon -->
                        <div style="position: relative; margin-left: 10px; display: flex; align-items: center; gap: 10px;">
                            <span id="grafik-selected-month" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Bulan ini</span>
                            <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                                <input type="month" id="grafik-month-picker" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; left: 0; top: 0; z-index: 10;" onchange="updateGrafikMonth(this.value)">
                                <button style="background: transparent; border: none; color: var(--text-dark); font-size: 24px; display: flex; align-items: center; justify-content: center; padding: 0;">
                                    <i class="ri-calendar-todo-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Time Tabs -->
                    <div id="grafik-content-pengeluaran">


                    <!-- Chart Area -->
                    <div style="display: flex; align-items: center; justify-content: center; gap: 50px; margin: 40px auto 50px; max-width: 800px;">
                        <!-- Donut Chart Container -->
                        <div style="width: 160px; height: 160px; position: relative;">
                            <canvas id="grafikPageDonut"></canvas>
                            <!-- Center Text -->
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%;">
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-dark);">+40,5 juta</div>
                            </div>
                        </div>
                        
                        <!-- Custom Legend -->
                        <div style="flex: 1; max-width: 300px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #eab308;"></span> gaji</div>
                                <div style="font-weight: 600;">51,37%</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #0ea5e9;"></span> bulanan</div>
                                <div style="font-weight: 600;">22,71%</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #ef4444;"></span> event</div>
                                <div style="font-weight: 600;">8,15%</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #10b981;"></span> iklan</div>
                                <div style="font-weight: 600;">8,03%</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #22c55e;"></span> Lainnya</div>
                                <div style="font-weight: 600;">9,72%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Dots -->
                    <div style="display: flex; justify-content: center; gap: 6px; margin-bottom: 30px;">
                        <div style="width: 6px; height: 6px; border-radius: 50%; background: var(--text-dark);"></div>
                        <div style="width: 6px; height: 6px; border-radius: 50%; background: var(--border-color);"></div>
                        <div style="width: 6px; height: 6px; border-radius: 50%; background: var(--border-color);"></div>
                    </div>

                    <!-- Breakdown List -->
                    <div style="display: flex; flex-direction: column;">
                        
                        <!-- Item 1 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #eab308; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-megaphone-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">gaji</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">20.822.000</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 51.37%; height: 100%; background: #eab308; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">51,37%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #0ea5e9; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-global-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">bulanan</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">9.205.448</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 22.71%; height: 100%; background: #0ea5e9; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">22,71%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #ef4444; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-camera-lens-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">event</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">3.303.600</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 8.15%; height: 100%; background: #ef4444; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">8,15%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #10b981; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-graduation-cap-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">iklan</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">3.258.300</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 8.03%; height: 100%; background: #10b981; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">8,03%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 5 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #8b5cf6; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-tv-2-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">Elektronik</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">2.225.653</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 5.49%; height: 100%; background: #8b5cf6; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">5,49%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 6 -->
                        <div style="display: flex; align-items: flex-start; gap: 15px;">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: #10b981; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                <i class="ri-restaurant-2-line"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">Makanan</span>
                                    <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">862.300</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                        <div style="width: 2.12%; height: 100%; background: #10b981; border-radius: 3px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">2,12%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div> <!-- End of content-pengeluaran -->

                    <!-- Pemasukan Content -->
                    <div id="grafik-content-pemasukan" style="display: none;">


                        <!-- Chart Area -->
                        <div style="display: flex; align-items: center; justify-content: center; gap: 50px; margin: 40px auto 50px; max-width: 800px;">
                            <div style="width: 160px; height: 160px; position: relative;">
                                <canvas id="grafikPageDonutPemasukan"></canvas>
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%;">
                                    <div style="font-size: 14px; font-weight: 700; color: var(--text-dark);">+90,6 juta</div>
                                </div>
                            </div>
                            
                            <div style="flex: 1; max-width: 300px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #10b981;"></span> Proyek A</div>
                                    <div style="font-weight: 600;">60,00%</div>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 15px;">
                                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #0ea5e9;"></span> Investasi</div>
                                    <div style="font-weight: 600;">25,00%</div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 15px;">
                                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-dark);"><span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 3px solid #8b5cf6;"></span> Lainnya</div>
                                    <div style="font-weight: 600;">15,00%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Breakdown List -->
                        <div style="display: flex; flex-direction: column;">
                            <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: #10b981; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                    <i class="ri-briefcase-line"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">Proyek A</span>
                                        <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">54.360.000</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 60%; height: 100%; background: #10b981; border-radius: 3px;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">60,00%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: flex-start; gap: 15px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: #0ea5e9; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                    <i class="ri-line-chart-line"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">Investasi</span>
                                        <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">22.650.000</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 25%; height: 100%; background: #0ea5e9; border-radius: 3px;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">25,00%</span>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: #8b5cf6; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0;">
                                    <i class="ri-more-fill"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <span style="font-weight: 600; color: var(--text-dark); font-size: 15px;">Lainnya</span>
                                        <span style="font-weight: 700; color: var(--text-dark); font-size: 15px;">13.590.000</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                                            <div style="width: 15%; height: 100%; background: #8b5cf6; border-radius: 3px;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted); width: 45px; text-align: right;">15,00%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Laporan Section -->
            <!-- Laporan Section -->
            <div id="view-laporan" class="view-section" style="display: none;">
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
                    <!-- Dropdown Pilih Jenis Laporan removed -->
                    <!-- Ringkasan Cards (Pengeluaran & Pemasukan) -->
                    <div style="flex: 1; width: 100%; display: flex; gap: 20px;">
                        
                        <!-- Saldo Total Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(90deg, #7cd0ff 0%, #4db8ff 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(77,184,255,0.3); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, opacity 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.opacity='0.9';" onmouseout="this.style.transform='translateY(0)'; this.style.opacity='1';">
                            <div style="font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Saldo total</div>
                            <div id="card-val-saldo" style="font-size: 28px; font-weight: 700; color: white; letter-spacing: 0.5px;">106.509.113</div>
                        </div>

                        <!-- Pengeluaran Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(90deg, #7cd0ff 0%, #4db8ff 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(77,184,255,0.3); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, opacity 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.opacity='0.9';" onmouseout="this.style.transform='translateY(0)'; this.style.opacity='1';">
                            <div style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 5px;">Pengeluaran</div>
                            <div id="card-val-pengeluaran" style="font-size: 20px; font-weight: 600; color: white; letter-spacing: 0.5px;">589.983.664</div>
                        </div>

                        <!-- Pemasukan Card -->
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(90deg, #7cd0ff 0%, #4db8ff 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(77,184,255,0.3); padding: 25px; color: white; cursor: pointer; transition: transform 0.2s ease, opacity 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.opacity='0.9';" onmouseout="this.style.transform='translateY(0)'; this.style.opacity='1';">
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
                        
                        <button onclick="downloadExcel()" style="display: flex; align-items: center; gap: 8px; background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.backgroundColor='#059669';" onmouseout="this.style.backgroundColor='#10b981';">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path>
                                <path d="M14 2v6h6"></path>
                                <path d="M8 13h2"></path>
                                <path d="M8 17h2"></path>
                                <path d="M14 13h2"></path>
                                <path d="M14 17h2"></path>
                            </svg>
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

        // Grafik Page Donut Chart
        const grafikPageDonutEl = document.getElementById('grafikPageDonut');
        if (grafikPageDonutEl) {
            const ctxGrafikDonut = grafikPageDonutEl.getContext('2d');
            new Chart(ctxGrafikDonut, {
                type: 'doughnut',
                data: {
                    labels: ['Gaji', 'Bulanan', 'Event', 'Iklan', 'Lainnya'],
                    datasets: [{
                        data: [51.37, 22.71, 8.15, 8.03, 9.72],
                        backgroundColor: [
                            '#eab308', // Yellow
                            '#0ea5e9', // Blue
                            '#ef4444', // Red
                            '#10b981', // Green
                            '#22c55e'  // Green
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
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

        // Grafik Page Donut Chart - Pemasukan
        const grafikPageDonutPemasukanEl = document.getElementById('grafikPageDonutPemasukan');
        if (grafikPageDonutPemasukanEl) {
            const ctxGrafikDonutPem = grafikPageDonutPemasukanEl.getContext('2d');
            new Chart(ctxGrafikDonutPem, {
                type: 'doughnut',
                data: {
                    labels: ['Proyek A', 'Investasi', 'Lainnya'],
                    datasets: [{
                        data: [60, 25, 15],
                        backgroundColor: [
                            '#10b981', // Green
                            '#0ea5e9', // Blue
                            '#8b5cf6'  // Purple
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
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

        function toggleGrafikView(type) {
            const btnPengeluaran = document.getElementById('btn-toggle-pengeluaran');
            const btnPemasukan = document.getElementById('btn-toggle-pemasukan');
            const contentPengeluaran = document.getElementById('grafik-content-pengeluaran');
            const contentPemasukan = document.getElementById('grafik-content-pemasukan');

            if (type === 'pengeluaran') {
                btnPengeluaran.style.background = '#ffffff';
                btnPengeluaran.style.fontWeight = '600';
                btnPengeluaran.style.color = 'var(--text-dark)';
                btnPengeluaran.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
                
                btnPemasukan.style.background = 'transparent';
                btnPemasukan.style.fontWeight = '500';
                btnPemasukan.style.color = 'var(--text-muted)';
                btnPemasukan.style.boxShadow = 'none';

                contentPengeluaran.style.display = 'block';
                contentPemasukan.style.display = 'none';
            } else {
                btnPemasukan.style.background = '#ffffff';
                btnPemasukan.style.fontWeight = '600';
                btnPemasukan.style.color = 'var(--text-dark)';
                btnPemasukan.style.boxShadow = '0 2px 5px rgba(0,0,0,0.05)';
                
                btnPengeluaran.style.background = 'transparent';
                btnPengeluaran.style.fontWeight = '500';
                btnPengeluaran.style.color = 'var(--text-muted)';
                btnPengeluaran.style.boxShadow = 'none';

                contentPemasukan.style.display = 'block';
                contentPengeluaran.style.display = 'none';
            }
        }

        function updateGrafikMonth(val) {
            if (!val) return;
            const dateObj = new Date(val + '-01');
            const monthStr = dateObj.toLocaleString('id-ID', { month: 'short' });
            const yearStr = dateObj.getFullYear();
            const formatted = monthStr + ' ' + yearStr;
            
            const selectedMonthEl = document.getElementById('grafik-selected-month');
            if (selectedMonthEl) selectedMonthEl.textContent = formatted;
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
            }

            // Navigation Logic
            const navLinks = document.querySelectorAll('.nav-link[data-target], .nav-link-custom[data-target]');
            const viewSections = document.querySelectorAll('.view-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }
                    
                    const targetId = this.getAttribute('data-target');
                    if (!targetId) return;
                    
                    const targetView = document.getElementById('view-' + targetId);
                    if (targetView) {
                        // Populate Detail Transaksi dynamically
                        if (targetId === 'detail-transaksi') {
                            const titleEl = this.querySelector('.rdg-title');
                            const amountEl = this.querySelector('.rdg-amount');
                            
                            if (titleEl && amountEl) {
                                const title = titleEl.textContent.trim();
                                const amountText = amountEl.textContent.trim();
                                const isPositive = amountEl.classList.contains('amount-positive');
                                
                                // Get Date from parent group
                                const groupDiv = this.closest('.riwayat-date-group');
                                let dateClean = '1 Sep 2026';
                                if (groupDiv) {
                                    const dateRaw = groupDiv.querySelector('.rdg-date').textContent.trim();
                                    // Take text before the day name (e.g. "04 Sep  Jumat" -> "04 Sep")
                                    const dateParts = dateRaw.split(' ');
                                    dateClean = dateParts[0] + ' ' + dateParts[1] + ' 2026';
                                }
                                
                                // Get Icon details
                                const iconDiv = this.querySelector('.rdg-icon');
                                const iEl = iconDiv ? iconDiv.querySelector('i') : null;
                                
                                // Inject into Detail View
                                document.getElementById('dt-title').textContent = title;
                                document.getElementById('dt-catatan').textContent = title.toLowerCase();
                                
                                // Amount and Type
                                document.getElementById('dt-tipe').textContent = isPositive ? 'Pemasukan' : 'Pengeluaran';
                                const numOnly = amountText.replace(/[^0-9.]/g, '');
                                document.getElementById('dt-jumlah-utama').textContent = numOnly;
                                document.getElementById('dt-jumlah-sub').textContent = numOnly;
                                
                                // Date
                                document.getElementById('dt-tanggal-utama').textContent = dateClean;
                                document.getElementById('dt-tanggal-sub').textContent = dateClean + ' 10.00.00 Tambahkan';
                                
                                // Update Icon
                                if (iconDiv && iEl) {
                                    const detailIconCircle = document.getElementById('dt-icon-color');
                                    detailIconCircle.style.backgroundColor = window.getComputedStyle(iconDiv).backgroundColor;
                                    document.getElementById('dt-icon-class').className = iEl.className;
                                }
                            }
                        }

                        // Update active nav item only if it's a sidebar link
                        if (this.classList.contains('nav-link')) {
                            document.querySelectorAll('.nav-item').forEach(item => {
                                item.classList.remove('active');
                            });
                            const navItem = this.closest('.nav-item');
                            if (navItem) navItem.classList.add('active');
                        }
                        
                        // Switch view
                        viewSections.forEach(section => {
                            section.style.display = 'none';
                            section.classList.remove('active');
                        });
                        
                        // Update global header title dynamically
                        const headerTitle = document.querySelector('.header-titles h1');
                        if (headerTitle) {
                            if (targetId === 'riwayat-transaksi') headerTitle.textContent = 'Riwayat Transaksi';
                            else if (targetId === 'detail-transaksi') headerTitle.textContent = 'Detail';
                            else if (targetId === 'grafik') headerTitle.textContent = 'Grafik';
                            else if (targetId === 'laporan') headerTitle.textContent = 'Laporan';
                            else if (targetId === 'dashboard') headerTitle.textContent = 'Dashboard';
                            else headerTitle.textContent = 'Dashboard';
                        }
                        
                        // Hide or show global header completely if needed
                        const globalHeader = document.querySelector('.header');
                        if (globalHeader) {
                            if (targetId === 'grafik') {
                                globalHeader.style.display = 'none';
                            } else {
                                globalHeader.style.display = 'flex';
                            }
                        }
                        
                        targetView.style.display = 'block';
                        setTimeout(() => {
                            targetView.classList.add('active');
                        }, 10);
                    }
                });
            });

            // Date Picker Logic
            const monthPicker = document.getElementById('riwayat-month-picker');
            if (monthPicker) {
                monthPicker.addEventListener('change', function() {
                    if (this.value) {
                        const dateObj = new Date(this.value + '-01');
                        const year = dateObj.getFullYear();
                        // Get short month name in Indonesian (e.g. Jan, Feb, Mar)
                        const monthStr = dateObj.toLocaleString('id-ID', { month: 'short' });
                        
                        document.getElementById('rh-year-display').textContent = year;
                        document.getElementById('rh-month-display').textContent = monthStr;
                    }
                });
            }

            // Calculate Totals Logic
            function calculateRiwayatTotals() {
                let totalPemasukan = 0;
                let totalPengeluaran = 0;
                
                const amountElements = document.querySelectorAll('.rdg-amount');
                amountElements.forEach(el => {
                    const text = el.textContent.trim();
                    // Remove non-numeric characters except minus sign
                    const numericValue = parseInt(text.replace(/[^0-9-]/g, '')) || 0;
                    
                    if (el.classList.contains('amount-positive')) {
                        totalPemasukan += numericValue;
                    } else if (el.classList.contains('amount-negative')) {
                        totalPengeluaran += Math.abs(numericValue);
                    }
                });
                
                const saldo = totalPemasukan - totalPengeluaran;
                
                // Format numbers with dots
                const formatRupiah = (num) => {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                };
                
                const elPemasukan = document.getElementById('rh-pemasukan-val');
                const elPengeluaran = document.getElementById('rh-pengeluaran-val');
                const elSaldo = document.getElementById('rh-saldo-val');
                
                if (elPemasukan) elPemasukan.textContent = formatRupiah(totalPemasukan);
                if (elPengeluaran) elPengeluaran.textContent = formatRupiah(totalPengeluaran);
                if (elSaldo) elSaldo.textContent = formatRupiah(saldo);
            }

            // Run on load
            calculateRiwayatTotals();
            
            // Check URL hash on load to switch view
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const targetLink = document.querySelector(`.nav-link[data-target="${hash}"]`);
                if (targetLink) {
                    targetLink.click();
                }
            }
            
            // Laporan Excel Export Feature
            window.downloadExcel = function() {
                let csv = [];
                let rows = document.querySelectorAll(".laporan-table tr");
                
                for (let i = 0; i < rows.length; i++) {
                    let row = [], cols = rows[i].querySelectorAll("td, th");
                    
                    for (let j = 0; j < cols.length; j++) {
                        // Strip comma, dot, or minus if necessary, or just keep text
                        let text = cols[j].innerText.replace(/"/g, '""');
                        row.push('"' + text + '"');
                    }
                    
                    csv.push(row.join(","));
                }
                
                let csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
                let downloadLink = document.createElement("a");
                downloadLink.download = "Laporan_Keuangan.csv";
                downloadLink.href = window.URL.createObjectURL(csvFile);
                downloadLink.style.display = "none";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            };
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
