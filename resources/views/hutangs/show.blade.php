@extends('layouts.app')
@section('title', 'Detail Hutang - FinanceHub')
@section('header-title', 'Detail Hutang & Pembayaran')

@section('content')
<div class="view-section active" style="display: block; padding: 20px; margin-top: 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('hutangs.index') }}" class="btn-outline" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; color: #475569; text-decoration: none; font-weight: 500;">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        @if(Auth::user()->role !== 'viewer')
        <a href="{{ route('hutangs.edit', $hutang->id) }}" class="btn-outline" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fef3c7; color: #92400e; text-decoration: none; font-weight: 500;">
            <i class="ri-edit-line"></i> Edit Data Hutang
        </a>
        @endif
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <!-- Kiri: Info Hutang & History -->
        <div>
            <!-- Card Info -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <h3 style="margin-top: 0; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">{{ $hutang->jenis_hutang }}</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                    <div>
                        <span style="color: #64748b; font-size: 12px; display: block;">Nomor Urut</span>
                        <div style="font-weight: 500;">{{ $hutang->nomor_urut }}</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px; display: block;">Kreditur</span>
                        <div style="font-weight: 500;">{{ $hutang->kreditur }}</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px; display: block;">Tanggal Dibuat</span>
                        <div style="font-weight: 500;">{{ \Carbon\Carbon::parse($hutang->tanggal_dibuat)->format('d M Y') }}</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px; display: block;">Jatuh Tempo</span>
                        <div style="font-weight: 500; color: #dc2626;">{{ $hutang->jatuh_tempo ? \Carbon\Carbon::parse($hutang->jatuh_tempo)->format('d M Y') : '-' }}</div>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <span style="color: #64748b; font-size: 12px; display: block;">Keterangan</span>
                        <div>{{ $hutang->keterangan ?: '-' }}</div>
                    </div>
                </div>

                <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #cbd5e1; display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                    <div>
                        <span style="color: #64748b; font-size: 12px;">Nominal Awal & Bunga</span>
                        <div style="font-weight: 700; font-size: 15px;">Rp {{ number_format($hutang->nominal_awal, 0, ',', '.') }}</div>
                        <div style="font-size: 11px; color: #64748b;">+ Bunga {{ $hutang->bunga_persen }}%</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px;">Total Hutang (Akhir)</span>
                        <div style="font-weight: 700; font-size: 15px; color: #0f172a;">Rp {{ number_format($hutang->nominal_akhir, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px;">Dibayarkan</span>
                        <div style="font-weight: 700; font-size: 15px; color: #059669;">Rp {{ number_format($hutang->nominal_dibayarkan, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <span style="color: #64748b; font-size: 12px;">Sisa Hutang</span>
                        <div style="font-weight: 700; font-size: 15px; color: #dc2626;">{{ $hutang->nominal_sisa == 0 ? 'Rp -' : 'Rp ' . number_format($hutang->nominal_sisa, 0, ',', '.') }}</div>
                        <div style="margin-top: 4px;">
                            @if($hutang->status === 'Lunas')
                                <span style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600;">LUNAS</span>
                            @else
                                <span style="background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600;">BELUM LUNAS</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Pembayaran -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; margin-bottom: 15px; color: #1e293b; font-size: 16px;">Histori Pembayaran</h3>
                
                @if($hutang->transaksis->where('jenis_transaksi', 'Pengeluaran')->count() > 0)
                <table style="width:100%; text-align:left; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 10px 5px; color:#475569; font-size: 13px;">Tanggal</th>
                        <th style="padding: 10px 5px; color:#475569; font-size: 13px;">Keluar Dari Akun</th>
                        <th style="padding: 10px 5px; color:#475569; font-size: 13px;">Keterangan</th>
                        <th style="padding: 10px 5px; color:#475569; font-size: 13px; text-align: right;">Nominal</th>
                    </tr>
                    @foreach($hutang->transaksis->where('jenis_transaksi', 'Pengeluaran')->sortByDesc('tanggal') as $trx)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 10px 5px; font-size: 14px;">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                        <td style="padding: 10px 5px; font-size: 14px;">{{ $trx->akunKredit->nama_akun ?? '-' }}</td>
                        <td style="padding: 10px 5px; font-size: 14px;">{{ $trx->keterangan }}</td>
                        <td style="padding: 10px 5px; font-size: 14px; text-align: right; color: #dc2626; font-weight: 600;">- Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <p style="color: #64748b; font-size: 14px; text-align: center; margin: 20px 0;">Belum ada histori pembayaran untuk hutang ini.</p>
                @endif
            </div>
        </div>

        <!-- Kanan: Form Tambah Pembayaran -->
        @if(Auth::user()->role !== 'viewer' && $hutang->nominal_sisa > 0)
        <div>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                <h3 style="margin-top: 0; color: #1e293b; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="ri-money-dollar-circle-line" style="color: #0b5394; font-size: 20px;"></i> Catat Pembayaran
                </h3>
                <p style="color: #64748b; font-size: 12px; margin-bottom: 15px;">Catat cicilan atau pelunasan hutang.</p>

                <form action="{{ route('hutangs.payment', $hutang->id) }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 5px; color: #475569; font-weight: 500; font-size: 13px;">Tanggal Bayar <span style="color:red">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px;">
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 5px; color: #475569; font-weight: 500; font-size: 13px;">Uang Keluar Dari (Kredit) <span style="color:red">*</span></label>
                        <select name="akun_kredit_id" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px;">
                            <option value="">Pilih Akun Kas/Bank...</option>
                            @foreach($akuns->filter(function($a) { return $a->kategori && $a->kategori->nama_kategori == 'Kas & Bank'; }) as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 5px; color: #475569; font-weight: 500; font-size: 13px;">Nominal (Rp) <span style="color:red">*</span></label>
                        <input type="number" name="jumlah" value="{{ $hutang->nominal_sisa }}" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; color: #059669; font-weight: bold;">
                        <small style="color: #64748b; font-size: 11px;">Default berisi sisa hutang</small>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; color: #475569; font-weight: 500; font-size: 13px;">Keterangan</label>
                        <textarea name="keterangan" rows="2" placeholder="Contoh: Cicilan 1" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; resize: vertical;"></textarea>
                    </div>

                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: #0b5394; color: white; font-weight: 500; cursor: pointer; transition: 0.2s;">
                        Simpan Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @elseif($hutang->nominal_sisa <= 0)
        <div>
            <div style="background: #d1fae5; border: 1px solid #34d399; border-radius: 12px; padding: 20px; text-align: center;">
                <i class="ri-checkbox-circle-fill" style="font-size: 48px; color: #059669;"></i>
                <h3 style="color: #065f46; margin: 10px 0 5px;">Hutang Lunas!</h3>
                <p style="color: #047857; font-size: 14px; margin: 0;">Seluruh kewajiban untuk hutang ini telah terbayar.</p>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
