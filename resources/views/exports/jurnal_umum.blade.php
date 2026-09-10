<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table border="1" cellpadding="3" cellspacing="0">
        <!-- Row 1: Title -->
        <tr>
            <th colspan="17" style="font-size: 24px; font-weight: bold; color: #0b5394; text-align: left; height: 40px; vertical-align: middle;">JURNAL UMUM</th>
        </tr>
        
        <!-- Row 2: Empty space -->
        <tr>
            <th colspan="17" style="height: 15px; border: none;"></th>
        </tr>

        <!-- Row 3: Header JOBNATION & TODAY -->
        <tr>
            <th colspan="15" style="background-color: #0b5394; color: #ffffff; font-weight: bold; text-align: left; height: 25px; vertical-align: middle;">JOBNATION</th>
            <th style="background-color: #0b5394; color: #ffffff; font-weight: bold; text-align: right; vertical-align: middle;">TODAY</th>
            <th style="background-color: #0b5394; color: #ffffff; font-weight: bold; text-align: right; vertical-align: middle;">{{ \Carbon\Carbon::now()->format('H:i:s') }}</th>
        </tr>
        
        <!-- Row 4: Tujuan Dana / Sumber Dana -->
        <tr>
            <th colspan="13" style="background-color: #ffffff; border: none;"></th>
            <th style="background-color: #ffffff; text-align: right; font-size: 10px; color: #000000; border: none; vertical-align: bottom;">Tujuan Dana</th>
            <th style="background-color: #ffffff; text-align: left; font-size: 10px; color: #000000; border: none; vertical-align: bottom;">Sumber Dana</th>
            <th colspan="2" style="background-color: #ffffff; border: none;"></th>
        </tr>

        <!-- Row 5: Column Headers & Side Table Headers -->
        <tr>
            <!-- Main Table Headers (A-Q) -->
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 40px; vertical-align: middle; text-align: center;">No</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 100px; vertical-align: middle; text-align: center;">Tanggal</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 100px; vertical-align: middle; text-align: center;">Bulan</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 80px; vertical-align: middle; text-align: center;">Tahun</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 150px; vertical-align: middle; text-align: center;">Nama Project</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 120px; vertical-align: middle; text-align: center;">Nomor Urut<br>Piutang</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 120px; vertical-align: middle; text-align: center;">Nomor Urut<br>Hutang</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 150px; vertical-align: middle; text-align: center;">Aktivitas<br>Arus Kas</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 180px; vertical-align: middle; text-align: center;">Kategori<br>Nama Akun</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 120px; vertical-align: middle; text-align: center;">Nomor Akun</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 180px; vertical-align: middle; text-align: center;">Nama Akun</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 150px; vertical-align: middle; text-align: center;">Catatan<br>Aset Tetap</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 300px; vertical-align: middle; text-align: center;">Deskripsi Transaksi</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 120px; vertical-align: middle; text-align: center;">DEBET</th>
            <th rowspan="3" style="background-color: #0b5394; color: white; width: 120px; vertical-align: middle; text-align: center;">KREDIT</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 120px; vertical-align: middle; text-align: center;">Saldo<br>(Balance)</th>
            <th rowspan="3" style="background-color: #1f2937; color: white; width: 250px; vertical-align: middle; text-align: center;">Dokumentasi</th>
            
            <!-- Spacers (R, S, T) -->
            <th rowspan="3" colspan="3" style="border: none;"></th>
            
            <!-- U, V, W, X: Overview Per Akun -->
            <th colspan="4" style="background-color: #1f2937; color: white; text-align: center; vertical-align: middle;">OVERVIEW KAS USAHA PER NAMA AKUN</th>
            
            <!-- Y, Z, AA: Spacers -->
            <th rowspan="3" colspan="3" style="border: none;"></th>
            
            <!-- AB, AC, AD, AE: Overview Per Bulan -->
            <th colspan="4" style="background-color: #1f2937; color: white; text-align: center; vertical-align: middle;">OVERVIEW KAS USAHA PER BULAN</th>
        </tr>

        <!-- Row 6: Side Tables Subheaders -->
        <tr>
            <!-- U, V, W, X -->
            <td colspan="4" style="font-style: italic; font-size: 11px; border: none; text-align: left;">(Nilai dalam satuan rupiah)</td>
            
            <!-- AB, AC, AD, AE -->
            <td colspan="4" style="font-style: italic; font-size: 11px; border: none; text-align: left;">(Nilai dalam satuan rupiah)</td>
        </tr>
        
        <!-- Row 7: Side Tables Column Headers -->
        <tr>
            <!-- U, V, W, X -->
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: left;">Nama Akun</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Debet</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Kredit</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Balance</td>
            
            <!-- AB, AC, AD, AE -->
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Bulan / Tanggal</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Debet</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Kredit</td>
            <td style="background-color: #1f2937; color: white; font-weight: bold; text-align: center;">Balance</td>
        </tr>

        <!-- Data Rows -->
        @php
            $max_rows_top = max(count($jurnal_rows), count($overview_per_akun), count($overview_per_bulan));
            $total_rows_needed = max($max_rows_top, count($overview_harian) > 0 ? (count($overview_per_bulan) + 3 + count($overview_harian)) : $max_rows_top);
        @endphp

        @for($i = 0; $i < $total_rows_needed; $i++)
            <tr>
                <!-- Main Table Data (A-Q) -->
                @if(isset($jurnal_rows[$i]))
                    @php
                        $row = $jurnal_rows[$i];
                        $amount = max($row['debet'], $row['kredit']);
                        $show_minus = ($row['jenis_transaksi'] == 'Pengeluaran' && !$row['is_debit']);
                    @endphp
                    <td style="text-align: center;">{{ $row['no'] }}</td>
                    <td style="text-align: center;">{{ $row['tanggal'] }}</td>
                    <td style="text-align: center;">{{ $row['bulan'] }}</td>
                    <td style="text-align: center;">{{ $row['tahun'] }}</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: left;">{{ $row['aktivitas_arus_kas'] }}</td>
                    <td style="text-align: left;">{{ $row['kategori_nama_akun'] }}</td>
                    <td style="text-align: center;">{{ $row['nomor_akun'] }}</td>
                    <td style="text-align: left;">{{ $row['nama_akun'] }}</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: left;">{{ $row['deskripsi_transaksi'] }}</td>
                    <td style="text-align: right;">{{ $row['debet'] > 0 ? 'Rp ' . number_format($row['debet'], 0, ',', '.') : 'Rp -' }}</td>
                    <td style="text-align: right;">{{ $row['kredit'] > 0 ? 'Rp ' . number_format($row['kredit'], 0, ',', '.') : 'Rp -' }}</td>
                    <td style="text-align: right;">{{ $show_minus ? '-Rp ' . number_format($amount, 0, ',', '.') : 'Rp ' . number_format($amount, 0, ',', '.') }}</td>
                    <td style="text-align: left;">
                        @if($row['dokumentasi'])
                            <a href="{{ $row['dokumentasi'] }}" style="color: #1d4ed8; text-decoration: underline;">Lihat Bukti</a>
                        @endif
                    </td>
                @else
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                @endif

                <!-- Spacer -->
                <td colspan="3" style="border: none;"></td>
                
                <!-- Overview Kas Usaha Per Akun -->
                @if(isset($overview_per_akun[$i]))
                    <td style="text-align: left;">{{ $overview_per_akun[$i]['akun'] }}</td>
                    <td style="text-align: right;">{{ 'Rp ' . ($overview_per_akun[$i]['debet'] !== '0' ? $overview_per_akun[$i]['debet'] : '-') }}</td>
                    <td style="text-align: right;">{{ 'Rp ' . ($overview_per_akun[$i]['kredit'] !== '0' ? $overview_per_akun[$i]['kredit'] : '-') }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $overview_per_akun[$i]['balance'] < 0 ? '-Rp ' . ltrim(abs($overview_per_akun[$i]['balance']), '-') : 'Rp ' . $overview_per_akun[$i]['balance'] }}
                    </td>
                @else
                    <td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td>
                @endif

                <!-- Spacer -->
                <td colspan="3" style="border: none;"></td>

                <!-- Overview Kas Usaha Per Bulan ATAU List Balance Harian -->
                @if($i < count($overview_per_bulan))
                    <!-- Monthly Data -->
                    <td style="text-align: right; width: 100px;">{{ $overview_per_bulan[$i]['bulan'] }}</td>
                    <td style="text-align: right; background-color: #bbf7d0; width: 100px;">{{ $overview_per_bulan[$i]['debet'] }}</td>
                    <td style="text-align: right; background-color: #bbf7d0; width: 100px;">{{ $overview_per_bulan[$i]['kredit'] }}</td>
                    <td style="text-align: center; font-weight: bold; width: 100px;">BALANCE</td>
                @elseif($i == count($overview_per_bulan) || $i == count($overview_per_bulan) + 1)
                    <!-- Empty rows for spacing before Daily List -->
                    <td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td>
                @elseif($i >= count($overview_per_bulan) + 2 && $i < count($overview_per_bulan) + 2 + count($overview_harian))
                    <!-- Daily Data (List Balance Harian) -->
                    @php
                        $harian_idx = $i - (count($overview_per_bulan) + 2);
                    @endphp
                    <td style="text-align: right; width: 100px;">{{ $overview_harian[$harian_idx]['tanggal'] }}</td>
                    <td style="text-align: right; background-color: #bbf7d0; width: 100px;">{{ $overview_harian[$harian_idx]['debet'] }}</td>
                    <td style="text-align: right; background-color: #bbf7d0; width: 100px;">{{ $overview_harian[$harian_idx]['kredit'] }}</td>
                    <td style="text-align: center; font-weight: bold; width: 100px;">BALANCE</td>
                @else
                    <td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td>
                @endif

            </tr>
        @endfor

    </table>
</body>
</html>
