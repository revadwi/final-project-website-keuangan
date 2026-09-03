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
                        <a href="/pemasukan" class="nav-link" data-target="pemasukan">
                            <i class="ri-arrow-left-down-line"></i>
                            <span>Pemasukan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pengeluaran" class="nav-link" data-target="pengeluaran">
                            <i class="ri-arrow-right-up-line"></i>
                            <span>Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/transfer" class="nav-link" data-target="transfer">
                            <i class="ri-arrow-left-right-line"></i>
                            <span>Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/anggaran" class="nav-link" data-target="anggaran">
                            <i class="ri-pie-chart-line"></i>
                            <span>Anggaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/laporan" class="nav-link" data-target="laporan">
                            <i class="ri-file-list-3-line"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/users" class="nav-link" data-target="users">
                            <i class="ri-user-settings-line"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pengaturan" class="nav-link" data-target="pengaturan">
                            <i class="ri-settings-4-line"></i>
                            <span>Pengaturan</span>
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
            <header class="header">
                <div class="header-titles">
                    <h1>Dashboard Admin</h1>
                    <p>Ringkasan keuangan keseluruhan</p>
                </div>
                <div class="header-actions">
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
            }
        });
    </script>
</body>
</html>
