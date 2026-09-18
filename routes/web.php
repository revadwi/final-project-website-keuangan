<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pemasukan', function () {
        return view('pemasukan');
    });

    Route::get('/pengeluaran', function () {
        return view('pengeluaran');
    });

    Route::get('/anggaran', function () {
        return view('anggaran');
    });

    Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/riwayat-transaksi', [\App\Http\Controllers\RiwayatTransaksiController::class, 'index'])->name('riwayat.index');
    Route::get('/grafik', [\App\Http\Controllers\GrafikController::class, 'index'])->name('grafik.index');

    Route::get('/pengaturan', function () {
        return view('pengaturan');
    });

    Route::get('/transfer', function () {
        return view('transfer');
    });

    Route::get('/users', function () {
        return view('users');
    });

    Route::get('/kategori', [\App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/export', [\App\Http\Controllers\KategoriController::class, 'export'])->name('kategori.export');
    Route::post('/kategori/import', [\App\Http\Controllers\KategoriController::class, 'import'])->name('kategori.import');
    Route::get('/kategori/template', [\App\Http\Controllers\KategoriController::class, 'template'])->name('kategori.template');
    Route::post('/kategori', [\App\Http\Controllers\KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [\App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [\App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/akun', [\App\Http\Controllers\AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/export', [\App\Http\Controllers\AkunController::class, 'export'])->name('akun.export');
    Route::post('/akun/import', [\App\Http\Controllers\AkunController::class, 'import'])->name('akun.import');
    Route::get('/akun/template', [\App\Http\Controllers\AkunController::class, 'template'])->name('akun.template');
    Route::post('/akun', [\App\Http\Controllers\AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [\App\Http\Controllers\AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [\App\Http\Controllers\AkunController::class, 'destroy'])->name('akun.destroy');

    Route::get('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/edit', [\App\Http\Controllers\TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'update'])->name('transaksi.update');

    Route::post('/perusahaan', [\App\Http\Controllers\PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::post('/perusahaan/switch/{id}', [\App\Http\Controllers\PerusahaanController::class, 'switch'])->name('perusahaan.switch');

    Route::get('/projects/export', [\App\Http\Controllers\ProjectController::class, 'export'])->name('projects.export');
    Route::post('/projects/import', [\App\Http\Controllers\ProjectController::class, 'import'])->name('projects.import');
    Route::get('/projects/template', [\App\Http\Controllers\ProjectController::class, 'template'])->name('projects.template');
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::post('/projects/{project}/payment', [\App\Http\Controllers\ProjectController::class, 'storePayment'])->name('projects.payment');

    Route::get('/hutangs/export', [\App\Http\Controllers\HutangController::class, 'export'])->name('hutangs.export');
    Route::post('/hutangs/import', [\App\Http\Controllers\HutangController::class, 'import'])->name('hutangs.import');
    Route::get('/hutangs/template', [\App\Http\Controllers\HutangController::class, 'template'])->name('hutangs.template');
    Route::resource('hutangs', \App\Http\Controllers\HutangController::class);
    Route::post('/hutangs/{hutang}/payment', [\App\Http\Controllers\HutangController::class, 'storePayment'])->name('hutangs.payment');

    Route::get('/piutangs/export', [\App\Http\Controllers\PiutangController::class, 'export'])->name('piutangs.export');
    Route::post('/piutangs/import', [\App\Http\Controllers\PiutangController::class, 'import'])->name('piutangs.import');
    Route::get('/piutangs/template', [\App\Http\Controllers\PiutangController::class, 'template'])->name('piutangs.template');
    Route::resource('piutangs', \App\Http\Controllers\PiutangController::class);
    Route::post('/piutangs/{piutang}/payment', [\App\Http\Controllers\PiutangController::class, 'storePayment'])->name('piutangs.payment');
});
