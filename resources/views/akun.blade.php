@extends('layouts.app')
@section('title', 'Akun - FinanceHub')
@section('header-title', 'Nama Akun')

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
            margin: 5% auto; 
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
            box-sizing: border-box;
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
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
</style>
@endpush

@section('content')
<div class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
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
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Daftar Akun</h2>
                    <button class="btn-primary" onclick="openModal('modalCreate')"><i class="ri-add-line"></i> Tambah Akun</button>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <div style="position: relative; width: 400px; max-width: 100%;">
                        <i class="ri-search-line" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 18px;"></i>
                        <input type="text" id="searchInput" placeholder="Cari akun..." style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Inter', sans-serif; outline: none; font-size: 14px; color: #334155; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
                
                <div class="transactions-list" style="background: white;">
                    <table style="width:100%; text-align:left; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background-color: #f8fafc;">
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">No Akun</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px;">Nama Akun</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px;">Kategori</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px;">Arus Kas</th>
                                <th style="padding: 16px 20px; color:#475569; font-weight: 600; font-size: 14px; text-align: center; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="akunTableBody">
                        @foreach($akuns as $index => $akun)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px 10px; font-weight: 500;">{{ $akun->nomor_akun }}</td>
                            <td style="padding: 12px 10px;">{{ $akun->nama_akun }}</td>
                            <td style="padding: 12px 10px;">
                                @if($akun->kategori)
                                    {{ $akun->kategori->nama_kategori }} 
                                    <span style="font-size: 11px; color: #64748b;">({{ $akun->kategori->jenis_kategori }})</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 12px 10px;">{{ $akun->aktivitas_arus_kas }}</td>
                            <td style="padding: 12px 10px; text-align: center;">
                                <button class="btn-warning" onclick="openEditModal({{ $akun->id }}, '{{ $akun->kategori_id }}', '{{ $akun->nama_akun }}', '{{ $akun->nomor_akun }}', '{{ $akun->aktivitas_arus_kas }}')"><i class="ri-edit-line"></i></button>
                                <form action="{{ route('akun.destroy', $akun->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($akuns->isEmpty())
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada data akun.</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

<!-- Modal Create -->
    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalCreate')">&times;</span>
            <h2>Tambah Akun Baru</h2>
            <form action="{{ route('akun.store') }}" method="POST" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                @csrf
                <div class="form-group">
                    <label>Pilih Kategori</label>
                    <select name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }} ({{ $kategori->jenis_kategori }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nomor Akun</label>
                    <input type="text" name="nomor_akun" required placeholder="Contoh: 101">
                </div>
                <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" name="nama_akun" required placeholder="Contoh: Kas Kecil">
                </div>
                <div class="form-group">
                    <label>Aktivitas Arus Kas</label>
                    <select name="aktivitas_arus_kas" required>
                        <option value="">-- Pilih Aktivitas --</option>
                        <option value="Operasi">Operasi</option>
                        <option value="Investasi">Investasi</option>
                        <option value="Pendanaan">Pendanaan</option>
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
            <h2>Edit Akun</h2>
            <form id="formEdit" method="POST" style="margin-top: 20px;" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Pilih Kategori</label>
                    <select id="edit_kategori_id" name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }} ({{ $kategori->jenis_kategori }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nomor Akun</label>
                    <input type="text" id="edit_nomor_akun" name="nomor_akun" required>
                </div>
                <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" id="edit_nama_akun" name="nama_akun" required>
                </div>
                <div class="form-group">
                    <label>Aktivitas Arus Kas</label>
                    <select id="edit_aktivitas" name="aktivitas_arus_kas" required>
                        <option value="">-- Pilih Aktivitas --</option>
                        <option value="Operasi">Operasi</option>
                        <option value="Investasi">Investasi</option>
                        <option value="Pendanaan">Pendanaan</option>
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

        function openEditModal(id, kategori_id, nama_akun, nomor_akun, aktivitas) {
            document.getElementById('formEdit').action = '/akun/' + id;
            document.getElementById('edit_kategori_id').value = kategori_id;
            document.getElementById('edit_nama_akun').value = nama_akun;
            document.getElementById('edit_nomor_akun').value = nomor_akun;
            document.getElementById('edit_aktivitas').value = aktivitas;
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
            let rows = document.querySelectorAll('#akunTableBody tr');
            
            rows.forEach(row => {
                // Skip the "Belum ada data" row if it exists and has only 1 cell
                if (row.cells.length === 1) return;
                
                let noAkun = row.cells[0] ? row.cells[0].textContent.toLowerCase() : '';
                let namaAkun = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                let kategori = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
                
                if (noAkun.indexOf(filter) > -1 || namaAkun.indexOf(filter) > -1 || kategori.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endpush
