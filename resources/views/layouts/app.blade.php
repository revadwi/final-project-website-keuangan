<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinanceHub')</title>
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}?v={{ time() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="{{ asset('logo.png') }}" alt="Jobnation IT Outsource" style="max-width: 180px; height: auto; margin-top: -15px; margin-bottom: -15px; margin-left: -5px;">
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" class="nav-link">
                            <i class="ri-home-5-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}" {!! Auth::user()->role === 'viewer' ? 'style="opacity: 0.5; pointer-events: none;" title="Akses Ditolak"' : '' !!}>
                        <a href="/kategori" class="nav-link">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Input Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('akun*') ? 'active' : '' }}" {!! Auth::user()->role === 'viewer' ? 'style="opacity: 0.5; pointer-events: none;" title="Akses Ditolak"' : '' !!}>
                        <a href="/akun" class="nav-link">
                            <i class="ri-bank-card-line"></i>
                            <span>Input Nama Akun</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('transaksi*') && !request()->is('riwayat-transaksi') ? 'active' : '' }}" {!! Auth::user()->role === 'viewer' ? 'style="opacity: 0.5; pointer-events: none;" title="Akses Ditolak"' : '' !!}>
                        <a href="/transaksi" class="nav-link">
                            <i class="ri-file-add-line"></i>
                            <span>Input Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('riwayat-transaksi*') ? 'active' : '' }}" {!! Auth::user()->role === 'viewer' ? 'style="opacity: 0.5; pointer-events: none;" title="Akses Ditolak"' : '' !!}>
                        <a href="/riwayat-transaksi" class="nav-link">
                            <i class="ri-history-line"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('grafik*') ? 'active' : '' }}">
                        <a href="/grafik" class="nav-link">
                            <i class="ri-bar-chart-box-line"></i>
                            <span>Grafik</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="/laporan" class="nav-link">
                            <i class="ri-file-list-3-line"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-bottom">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button class="icon-btn mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="ri-menu-line"></i>
                    </button>
                    @hasSection('header-title')
                    <div class="header-titles">
                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: var(--text-dark);">@yield('header-title')</h1>
                    </div>
                    @endif
                </div>
                
                <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                    @php
                        $perusahaans = \App\Models\Perusahaan::all();
                        $active_id = session('active_perusahaan_id', $perusahaans->first()->id ?? null);
                    @endphp
                    @if($perusahaans->count() > 0)
                    <div class="worksheet-dropdown" style="position: relative; display: flex; align-items: center; gap: 8px;">
                        <form action="{{ route('perusahaan.switch', 'SWITCH_ID') }}" method="POST" id="switchWorksheetForm" style="display: none;">
                            @csrf
                        </form>
                        <select onchange="var form = document.getElementById('switchWorksheetForm'); form.action = '{{ url('/perusahaan/switch') }}/' + this.value; form.submit();" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-weight: 600; color: #0b5394; cursor: pointer; outline: none; appearance: auto; min-width: 200px;">
                            @foreach($perusahaans as $p)
                                <option value="{{ $p->id }}" {{ $active_id == $p->id ? 'selected' : '' }}>
                                    🏢 {{ $p->nama_perusahaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if(Auth::user()->role !== 'viewer')
                    <button type="button" onclick="openWorksheetModal()" style="width: 36px; height: 36px; border-radius: 8px; border: none; background: #0b5394; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;" title="Tambah Worksheet">
                        <i class="ri-add-line" style="font-size: 20px;"></i>
                    </button>
                    @endif

                    <button class="icon-btn">
                        <i class="ri-notification-3-line"></i>
                    </button>
                    <div class="user-profile">
                        <div class="avatar">
                            <img src="https://ui-avatars.com/api/?name=Admin+Finance&background=cbd5e1&color=334155" alt="User">
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
            
        </main>
    </div>
    

    <!-- Modal Tambah Worksheet -->
    <div id="worksheetModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 18px; color: #1e293b;">Tambah Worksheet Baru</h3>
                <button type="button" onclick="closeWorksheetModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <form action="{{ url('/perusahaan') }}" method="POST" onsubmit="var btn = document.getElementById('submitBtnWorksheet'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #475569; font-size: 14px; font-weight: 500;">Nama Perusahaan / Worksheet</label>
                    <input type="text" name="nama_perusahaan" required placeholder="Contoh: PT Sukses Makmur" style="width: 100%; padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; transition: border-color 0.2s;">
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeWorksheetModal()" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; color: #475569; cursor: pointer; font-weight: 500;">Batal</button>
                    <button id="submitBtnWorksheet" type="submit" style="padding: 10px 15px; border-radius: 8px; border: none; background: #0b5394; color: white; cursor: pointer; font-weight: 500;">Simpan & Buat</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }

        function openWorksheetModal() {
            var modal = document.getElementById('worksheetModal');
            modal.style.display = 'flex';
        }
        function closeWorksheetModal() {
            var modal = document.getElementById('worksheetModal');
            modal.style.display = 'none';
        }
        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('worksheetModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
