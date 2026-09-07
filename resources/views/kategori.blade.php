<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - FinanceHub</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
        }
        .btn-primary {
            background-color: #1d4ed8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #dc2626;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-warning {
            background-color: #f59e0b;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
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
                        <a href="{{ route('kategori.index') }}" class="nav-link" style="background: rgba(255,255,255,0.1); border-radius: 8px;">
                            <i class="ri-price-tag-3-line"></i><span>Input Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('akun.index') }}" class="nav-link">
                            <i class="ri-bank-card-line"></i><span>Input Nama Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/transaksi" class="nav-link">
                            <i class="ri-file-add-line"></i><span>Input Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard#riwayat-transaksi" class="nav-link">
                            <i class="ri-history-line"></i><span>Riwayat Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard#grafik" class="nav-link">
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
            <header class="header" style="display: flex; justify-content: center; width: 100%;">
                <div class="header-titles" style="text-align: center;">
                    <h1 style="margin-bottom: 0;">Kategori</h1>
                </div>
            </header>

            <div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Daftar Kategori</h2>
                    <button class="btn-primary" onclick="openModal('modalCreate')"><i class="ri-add-line"></i> Tambah Kategori</button>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <div style="position: relative; width: 400px; max-width: 100%;">
                        <i class="ri-search-line" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 18px;"></i>
                        <input type="text" id="searchInput" placeholder="Cari kategori..." style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Inter', sans-serif; outline: none; font-size: 14px; color: #334155; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
                
                <div class="transactions-list" style="background: white;">
                    <table style="width:100%; text-align:left; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background-color: #f8fafc;">
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">No</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px;">Nama Kategori</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px;">Jenis Kategori</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px; text-align: center; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kategoriTableBody">
                        @foreach($kategoris as $index => $kategori)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px 10px;">{{ $index + 1 }}</td>
                            <td style="padding: 12px 10px;">{{ $kategori->nama_kategori }}</td>
                            <td style="padding: 12px 10px;">
                                <span style="padding: 4px 8px; border-radius: 4px; background: {{ $kategori->jenis_kategori == 'Kredit' ? '#fee2e2' : '#d1fae5' }}; color: {{ $kategori->jenis_kategori == 'Kredit' ? '#dc2626' : '#059669' }}; font-size: 12px; font-weight: 600;">
                                    {{ $kategori->jenis_kategori }}
                                </span>
                            </td>
                            <td style="padding: 12px 10px; text-align: center;">
                                <button class="btn-warning" onclick="openEditModal({{ $kategori->id }}, '{{ $kategori->nama_kategori }}', '{{ $kategori->jenis_kategori }}')"><i class="ri-edit-line"></i></button>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($kategoris->isEmpty())
                        <tr>
                            <td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada data kategori.</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Create -->
    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalCreate')">&times;</span>
            <h2>Tambah Kategori Baru</h2>
            <form action="{{ route('kategori.store') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kategori</label>
                    <select name="jenis_kategori" required>
                        <option value="Debit">Debit</option>
                        <option value="Kredit">Kredit</option>
                    </select>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn-danger" onclick="closeModal('modalCreate')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalEdit')">&times;</span>
            <h2>Edit Kategori</h2>
            <form id="formEdit" method="POST" style="margin-top: 20px;">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" id="edit_nama_kategori" name="nama_kategori" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kategori</label>
                    <select id="edit_jenis_kategori" name="jenis_kategori" required>
                        <option value="Debit">Debit</option>
                        <option value="Kredit">Kredit</option>
                    </select>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn-danger" onclick="closeModal('modalEdit')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "block";
        }

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        function openEditModal(id, nama, jenis) {
            document.getElementById('formEdit').action = '/kategori/' + id;
            document.getElementById('edit_nama_kategori').value = nama;
            document.getElementById('edit_jenis_kategori').value = jenis;
            openModal('modalEdit');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#kategoriTableBody tr');
            
            rows.forEach(row => {
                // Skip the "Belum ada data" row if it exists and has only 1 cell
                if (row.cells.length === 1) return;
                
                let nama = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                let jenis = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
                
                if (nama.indexOf(filter) > -1 || jenis.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
