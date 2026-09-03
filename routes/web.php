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
