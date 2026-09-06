<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/pemasukan', function () {
    return view('pemasukan');
});

Route::get('/pengeluaran', function () {
    return view('pengeluaran');
});

Route::get('/anggaran', function () {
    return view('anggaran');
});

Route::get('/laporan', function () {
    return view('laporan');
});

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
Route::post('/kategori', [\App\Http\Controllers\KategoriController::class, 'store'])->name('kategori.store');
Route::put('/kategori/{id}', [\App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [\App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.destroy');

Route::get('/akun', [\App\Http\Controllers\AkunController::class, 'index'])->name('akun.index');
Route::post('/akun', [\App\Http\Controllers\AkunController::class, 'store'])->name('akun.store');
Route::put('/akun/{id}', [\App\Http\Controllers\AkunController::class, 'update'])->name('akun.update');
Route::delete('/akun/{id}', [\App\Http\Controllers\AkunController::class, 'destroy'])->name('akun.destroy');

Route::get('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'store'])->name('transaksi.store');
