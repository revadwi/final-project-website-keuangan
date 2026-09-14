@extends('layouts.app')
@section('title', 'Kategori - FinanceHub')
@section('header-title', 'Kategori')

@push('styles')
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

        /* Mobile specific adjustments for table */
        @media (max-width: 768px) {
            .transactions-list table th,
            .transactions-list table td {
                padding: 8px 4px !important;
                font-size: 12px !important;
                word-wrap: break-word;
            }
            .transactions-list table th:nth-child(1),
            .transactions-list table td:nth-child(1) {
                width: 10% !important;
            }
            .transactions-list table th:nth-child(2),
            .transactions-list table td:nth-child(2) {
                width: 35% !important;
            }
            .transactions-list table th:nth-child(3),
            .transactions-list table td:nth-child(3) {
                width: 30% !important;
            }
            .transactions-list table th:nth-child(4),
            .transactions-list table td:nth-child(4) {
                width: 25% !important;
            }
            .transactions-list .btn-warning,
            .transactions-list .btn-danger {
                padding: 4px 6px !important;
                font-size: 11px !important;
                margin: 2px !important;
            }
            .transactions-list table td span {
                font-size: 10px !important;
                padding: 2px 4px !important;
            }
        }
</style>
@endpush

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <h2>Daftar Kategori</h2>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ route('kategori.export') }}" class="btn-primary" style="background-color: #10b981; text-decoration: none;"><i class="ri-file-excel-line"></i> Export Excel</a>
                        <button class="btn-primary" style="background-color: #f59e0b;" onclick="openModal('modalImport')"><i class="ri-file-upload-line"></i> Import Excel</button>
                        <button class="btn-primary" onclick="openModal('modalCreate')"><i class="ri-add-line"></i> Tambah Kategori</button>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <div style="position: relative; width: 400px; max-width: 100%;">
                        <i class="ri-search-line" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 18px;"></i>
                        <input type="text" id="searchInput" placeholder="Cari kategori..." style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Inter', sans-serif; outline: none; font-size: 14px; color: #334155; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
                
                <div class="transactions-list" style="background: white;">
                    <table style="width:100%; text-align:left; border-collapse: separate; border-spacing: 0; table-layout: fixed; word-wrap: break-word;">
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

<!-- Modal Import -->
    <div id="modalImport" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalImport')">&times;</span>
            <h2>Import Kategori dari Excel</h2>
            <div style="margin-top: 15px; margin-bottom: 15px;">
                <p style="font-size: 14px; color: #64748b; margin-bottom: 10px;">Silakan unduh template Excel di bawah ini, isi datanya, lalu unggah kembali.</p>
                <a href="{{ route('kategori.template') }}" class="btn-primary" style="background-color: #10b981; text-decoration: none; display: inline-block; font-size: 14px;"><i class="ri-download-line"></i> Download Template</a>
            </div>
            <form action="{{ route('kategori.import') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Mengimpor...'; btn.style.opacity = '0.7';">
                @csrf
                <div class="form-group">
                    <label>File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" accept=".xlsx, .xls, .csv" required style="padding: 8px;">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn-danger" onclick="closeModal('modalImport')">Batal</button>
                    <button type="submit" class="btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>

<!-- Modal Create -->
    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalCreate')">&times;</span>
            <h2>Tambah Kategori Baru</h2>
            <form action="{{ route('kategori.store') }}" method="POST" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
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
            <form id="formEdit" method="POST" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
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
@endsection

@push('scripts')
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
@endpush
