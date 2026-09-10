<?php
$perusahaan = App\Models\Perusahaan::firstOrCreate(['nama_perusahaan' => 'Jobnation Default']);
App\Models\Kategori::withoutGlobalScope('perusahaan')->update(['perusahaan_id' => $perusahaan->id]);
App\Models\Akun::withoutGlobalScope('perusahaan')->update(['perusahaan_id' => $perusahaan->id]);
App\Models\Transaksi::withoutGlobalScope('perusahaan')->update(['perusahaan_id' => $perusahaan->id]);
echo 'Updated!';
