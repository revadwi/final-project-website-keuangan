<?php
$p = App\Models\Perusahaan::where('nama_perusahaan', 'pt jaya abadi')->orderBy('id', 'desc')->first();
if ($p) { $p->delete(); }
echo 'Deleted!';
