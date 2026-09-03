<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanceHub - Kelola Keuangan Perusahaan Anda</title>
    <link rel="stylesheet" href="landing.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="FinanceHub Logo">
        </div>
        <ul class="nav-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#fitur">Fitur Utama</a></li>
            <li><a href="#testimoni">Testimoni</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="/login" class="btn btn-outline">Masuk</a>
            <a href="/login" class="btn btn-primary">Coba Gratis</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero" id="beranda">
        <div class="hero-bg-shapes">
            <div class="hero-shape-1"></div>
            <div class="hero-shape-2"></div>
        </div>
        
        <div class="hero-content">
            <div class="badge">#1 Software Akuntansi 2026</div>
            <h1>Sistem Kelola Keuangan Terbaik untuk Bisnis Anda</h1>
            <p>Pantau arus kas, buat anggaran, dan hasilkan laporan keuangan yang akurat dalam hitungan detik. Semua dalam satu dashboard yang elegan.</p>
            <div class="hero-buttons">
                <a href="/login" class="btn btn-primary">Mulai Sekarang</a>
                <a href="#fitur" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        
        <div class="hero-image">
            <!-- Mockup Dashboard Image Simulation -->
            <div class="dashboard-mockup">
                <!-- We simulate a dashboard screenshot using inline CSS to look like a UI -->
                <div style="padding: 15px; border-bottom: 1px solid #f1f5f9; display: flex; gap: 10px;">
                    <div style="width:12px; height:12px; border-radius:50%; background:#ef4444;"></div>
                    <div style="width:12px; height:12px; border-radius:50%; background:#f59e0b;"></div>
                    <div style="width:12px; height:12px; border-radius:50%; background:#10b981;"></div>
                </div>
                <div style="padding: 20px; display: flex; gap: 20px;">
                    <div style="width: 20%; background: #f8fafc; border-radius: 10px; height: 300px; padding: 15px;">
                        <div style="height: 10px; background: #cbd5e1; border-radius: 5px; margin-bottom: 15px; width: 80%;"></div>
                        <div style="height: 10px; background: #e2e8f0; border-radius: 5px; margin-bottom: 10px;"></div>
                        <div style="height: 10px; background: #e2e8f0; border-radius: 5px; margin-bottom: 10px;"></div>
                        <div style="height: 10px; background: #e2e8f0; border-radius: 5px; margin-bottom: 10px;"></div>
                    </div>
                    <div style="width: 80%; display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; gap: 15px;">
                            <div style="flex:1; background: rgba(29, 78, 216, 0.05); border: 1px solid rgba(29, 78, 216, 0.1); height: 80px; border-radius: 10px; padding: 15px;">
                                <div style="font-size:12px; color:#64748b; margin-bottom:8px;">Total Saldo</div>
                                <div style="font-size:20px; font-weight:700; color:#0f172a;">Rp 245M</div>
                            </div>
                            <div style="flex:1; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); height: 80px; border-radius: 10px; padding: 15px;">
                                <div style="font-size:12px; color:#64748b; margin-bottom:8px;">Pemasukan</div>
                                <div style="font-size:20px; font-weight:700; color:#0f172a;">Rp 120M</div>
                            </div>
                        </div>
                        <div style="flex: 1; background: #f8fafc; border-radius: 10px; position:relative; overflow:hidden;">
                            <div style="position:absolute; bottom:0; width:100%; height:150px; background: linear-gradient(0deg, rgba(29,78,216,0.1) 0%, rgba(255,255,255,0) 100%);"></div>
                            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="position:absolute; bottom:0; width:100%; height:100px;">
                                <path d="M0 30 L0 15 Q 25 5, 50 15 T 100 10 L 100 30 Z" fill="rgba(29,78,216,0.3)"/>
                                <path d="M0 15 Q 25 5, 50 15 T 100 10" fill="none" stroke="#1d4ed8" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features" id="fitur">
        <div class="section-header">
            <h2>Lebih dari sekadar pencatatan</h2>
            <p>FinanceHub dilengkapi dengan berbagai alat analisis dan pelaporan otomatis yang akan menghemat ratusan jam kerja Anda.</p>
        </div>
        
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon icon-blue">
                    <i class="ri-pie-chart-line"></i>
                </div>
                <h3>Dashboard Analitik</h3>
                <p>Pantau arus kas Anda secara visual melalui grafik interaktif dan informatif secara real-time.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon icon-green">
                    <i class="ri-file-list-3-line"></i>
                </div>
                <h3>Laporan Otomatis</h3>
                <p>Ekspor laporan keuangan format PDF atau Excel hanya dengan satu kali klik tanpa perlu rekap manual.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon icon-dark">
                    <i class="ri-user-settings-line"></i>
                </div>
                <h3>Multi Pengguna & Hak Akses</h3>
                <p>Atur siapa saja tim Anda yang memiliki akses sebagai Admin atau sekadar Viewer (Read-Only).</p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta">
        <h2>Siap mengubah cara Anda mengelola keuangan?</h2>
        <p>Bergabunglah dengan ribuan perusahaan lain yang telah mempercayakan sistem manajemen keuangan mereka kepada FinanceHub.</p>
        <a href="/login" class="btn btn-primary">Daftar Sekarang - Gratis</a>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="logo" style="margin-bottom: 20px;">
                <img src="logo.png" alt="Logo" style="height: 30px;">
            </div>
            <p>&copy; 2026 Jobnation IT Outsource. Semua hak dilindungi undang-undang.</p>
        </div>
    </footer>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
