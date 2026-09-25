import re

with open('resources/views/transaksi.blade.php', 'r') as f:
    content = f.read()

# 1. Update tabs
content = content.replace(
'''                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab('pemasukan', this)">Pemasukan Umum</button>
                        <button class="tab-btn" onclick="switchTab('pengeluaran', this)">Pengeluaran Umum</button>
                        <button class="tab-btn" onclick="switchTab('project', this)">Bayar Project</button>
                        <button class="tab-btn" onclick="switchTab('piutang', this)">Terima Piutang</button>
                        <button class="tab-btn" onclick="switchTab('hutang', this)">Bayar Hutang</button>
                    </div>''',
'''                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab('pemasukan', this)">Pemasukan Umum</button>
                        <button class="tab-btn" onclick="switchTab('pengeluaran', this)">Pengeluaran Umum</button>
                    </div>'''
)

# 2. Update Pemasukan Form
content = content.replace(
'''                    <!-- FORM PEMASUKAN -->
                    <div id="form-pemasukan" class="tab-content active">
                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pemasukan">
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Pendapatan Jasa">
                                </div>
                            </div>''',
'''                    <!-- FORM PEMASUKAN -->
                    <div id="form-pemasukan" class="tab-content active">
                        <form id="form-pemasukan-submit" action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pemasukan">
                            
                            <!-- Tambahan Dropdown Project dan Piutang -->
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Pilih Project (Pendapatan Usaha - Opsional)</label>
                                    <select class="select2-search" name="project_id" id="pem_project_id" onchange="handlePemasukanType()">
                                        <option value="">-- Bukan Pembayaran Project --</option>
                                        @foreach($projects as $project)
                                            @php
                                                $terbayar = $project->transaksis->where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
                                                $sisa = $project->nominal_project - $terbayar;
                                            @endphp
                                            <option value="{{ $project->id }}">{{ $project->no_penawaran }} - {{ $project->nama_project }} (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Piutang (Opsional)</label>
                                    <select class="select2-search" name="piutang_id" id="pem_piutang_id" onchange="handlePemasukanType()">
                                        <option value="">-- Bukan Penerimaan Piutang --</option>
                                        @foreach($piutangs as $piutang)
                                            @php
                                                $sisa = $piutang->nominal_sisa;
                                                $nama_tampilan = $piutang->project ? $piutang->project->nama_project : $piutang->keterangan;
                                            @endphp
                                            <option value="{{ $piutang->id }}">{{ $piutang->nomor_urut }} - {{ $nama_tampilan }} (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Akhir Dropdown Project dan Piutang -->

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" id="pem_keterangan" class="form-control" required placeholder="Contoh: Pendapatan Jasa">
                                </div>
                            </div>'''
)

content = content.replace(
'''                            <div class="account-box">
                                <h4>Akun Sumber (Uang Berasal Dari Mana)</h4>''',
'''                            <div class="account-box" id="pem_box_sumber">
                                <h4>Akun Sumber (Uang Berasal Dari Mana)</h4>'''
)


# 3. Update Pengeluaran Form
content = content.replace(
'''                    <!-- FORM PENGELUARAN -->
                    <div id="form-pengeluaran" class="tab-content">
                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pengeluaran">
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Pembayaran Listrik">
                                </div>
                            </div>''',
'''                    <!-- FORM PENGELUARAN -->
                    <div id="form-pengeluaran" class="tab-content">
                        <form id="form-pengeluaran-submit" action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data" onsubmit="var btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...'; btn.style.opacity = '0.7';">
                            @csrf
                            <input type="hidden" name="jenis_transaksi" value="Pengeluaran">
                            
                            <!-- Tambahan Dropdown Hutang -->
                            <div class="form-group">
                                <label>Pilih Hutang (Opsional)</label>
                                <select class="select2-search" name="hutang_id" id="peng_hutang_id" onchange="handlePengeluaranType()">
                                    <option value="">-- Bukan Pembayaran Hutang --</option>
                                    @foreach($hutangs as $hutang)
                                        @php
                                            $sisa = $hutang->nominal_sisa;
                                        @endphp
                                        <option value="{{ $hutang->id }}">{{ $hutang->nomor_urut }} - {{ $hutang->kreditur ? $hutang->kreditur . ' - ' : '' }}{{ $hutang->jenis_hutang }} (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Akhir Dropdown Hutang -->

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" id="peng_keterangan" class="form-control" required placeholder="Contoh: Pembayaran Listrik">
                                </div>
                            </div>'''
)

content = content.replace(
'''                            <div class="account-box">
                                <h4>Akun Tujuan (Untuk Keperluan Apa)</h4>''',
'''                            <div class="account-box" id="peng_box_tujuan">
                                <h4>Akun Tujuan (Untuk Keperluan Apa)</h4>'''
)


# 4. Remove standalone forms Project, Piutang, Hutang using regex
content = re.sub(r'                    <!-- FORM PROJECT -->[\s\S]*?<!-- FORM HUTANG -->[\s\S]*?</div>\s*</div>\s*</div>', '                </div>\n            </div>', content)

# 5. Add JS functions at the bottom
js_functions = '''
        // Logic untuk pergantian tipe Pemasukan (Umum / Project / Piutang)
        function handlePemasukanType() {
            const form = document.getElementById('form-pemasukan-submit');
            const projectId = document.getElementById('pem_project_id').value;
            const piutangId = document.getElementById('pem_piutang_id').value;
            const boxSumber = document.getElementById('pem_box_sumber');
            const akunSumber = document.getElementById('pem_akun_sumber');
            const katSumber = document.getElementById('pem_kat_sumber');
            const keterangan = document.getElementById('pem_keterangan');

            // Reset ke default (Pemasukan Umum)
            form.action = "{{ route('transaksi.store') }}";
            boxSumber.style.display = 'block';
            $('#pem_piutang_id').prop('disabled', false);
            $('#pem_project_id').prop('disabled', false);
            akunSumber.required = true;
            keterangan.required = true;
            keterangan.placeholder = "Contoh: Pendapatan Jasa";

            if (projectId) {
                // Pembayaran Project
                form.action = '/projects/' + projectId + '/payment';
                $('#pem_piutang_id').prop('disabled', true);
                keterangan.required = false;
                keterangan.placeholder = "Kosongkan untuk keterangan otomatis";
            } else if (piutangId) {
                // Penerimaan Piutang
                form.action = '/piutangs/' + piutangId + '/payment';
                $('#pem_project_id').prop('disabled', true);
                boxSumber.style.display = 'none'; // Sembunyikan bagian sumber (Kredit)
                akunSumber.required = false;
                $(akunSumber).val('').trigger('change.select2'); // Kosongkan nilainya
                $(katSumber).val('').trigger('change.select2');
                keterangan.required = false;
                keterangan.placeholder = "Kosongkan untuk keterangan otomatis";
            }
        }

        // Logic untuk pergantian tipe Pengeluaran (Umum / Hutang)
        function handlePengeluaranType() {
            const form = document.getElementById('form-pengeluaran-submit');
            const hutangId = document.getElementById('peng_hutang_id').value;
            const boxTujuan = document.getElementById('peng_box_tujuan');
            const akunTujuan = document.getElementById('peng_akun_tujuan');
            const katTujuan = document.getElementById('peng_kat_tujuan');
            const keterangan = document.getElementById('peng_keterangan');

            // Reset ke default (Pengeluaran Umum)
            form.action = "{{ route('transaksi.store') }}";
            boxTujuan.style.display = 'block';
            akunTujuan.required = true;
            keterangan.required = true;
            keterangan.placeholder = "Contoh: Pembayaran Listrik";

            if (hutangId) {
                // Pembayaran Hutang
                form.action = '/hutangs/' + hutangId + '/payment';
                boxTujuan.style.display = 'none'; // Sembunyikan bagian tujuan (Debit) karena bayar hutang hanya butuh sumber (Kredit)
                akunTujuan.required = false;
                $(akunTujuan).val('').trigger('change.select2'); // Kosongkan nilainya
                $(katTujuan).val('').trigger('change.select2');
                keterangan.required = false;
                keterangan.placeholder = "Kosongkan untuk keterangan otomatis";
            }
        }
    </script>
@endpush
'''

content = content.replace('    </script>\n@endpush', js_functions)

with open('resources/views/transaksi.blade.php', 'w') as f:
    f.write(content)
print("Done!")
