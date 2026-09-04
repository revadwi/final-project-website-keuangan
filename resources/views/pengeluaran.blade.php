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
            <header class="header">
                <div class="header-titles">
                    <h1>Pengeluaran</h1>
                    <p>Halaman fitur Pengeluaran</p>
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
            <div id="view-pengeluaran" class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
                <h2>Riwayat Pengeluaran</h2>
                <p style="color: #64748b; margin-top: 5px;">Seluruh catatan pengeluaran biaya operasional.</p>
                <div class="transactions-list" style="margin-top:20px; background: #f8fafc; padding: 15px; border-radius: 8px;">
                    <table style="width:100%; text-align:left; border-collapse: collapse;">
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px 10px; color:#475569;">Tanggal</th>
                            <th style="padding: 12px 10px; color:#475569;">Keterangan</th>
                            <th style="padding: 12px 10px; color:#475569;">Jumlah</th>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px 10px;">25 Agu 2026</td>
                            <td style="padding: 12px 10px;">Sewa Cloud Server (AWS)</td>
                            <td style="padding: 12px 10px; color: #dc2626; font-weight: 600;">- Rp 5.200.000</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 10px;">24 Agu 2026</td>
                            <td style="padding: 12px 10px;">Biaya Marketing Ads</td>
                            <td style="padding: 12px 10px; color: #dc2626; font-weight: 600;">- Rp 3.000.000</td>
                        </tr>
                    </table>
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
            }
        });
    </script>
</body>
</html>
