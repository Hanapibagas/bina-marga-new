<?php

use App\Http\Controllers\Admin\DaftarPenggunaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\SettingProfileController;
use App\Http\Controllers\Admin\UploadFileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdmin\TambahPenggunaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'getLogin'])->name('get.LoginHome');
Route::get('/auth/google', [GoogleController::class, 'getRedirectToGoogle'])->name('get.Auth.Google');
Route::get('/auth/google/callback', [GoogleController::class, 'getHandleGoogleCallback'])->name('google');

Auth::routes(['register' => false]);
Route::get('register', function () {
    return view('auth.404');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dataset', [HomeController::class, 'dataset'])->name('dataset');

// Route untuk super admin
Route::post('/tambah-pengguna', [TambahPenggunaController::class, 'getStorePengguna'])->name('get.Tambah.Pengguna');
Route::put('/tambah-pengguna/edit/{id}', [TambahPenggunaController::class, 'putUpdatepengguna'])->name('putUpdatepengguna');
Route::get('/daftar-pengguna', [DaftarPenggunaController::class, 'getIndex'])->name('get.Index.Pengguna');
Route::get('/setting', [SettingProfileController::class, 'getIndex'])->name('get.Index.Setting');
Route::put('/setting/update-password', [SettingProfileController::class, 'postUpdatePassword'])->name('put.Password.User');

// list struktur
Route::get('/daftar-struktur-organisasi', [DaftarPenggunaController::class, 'getStrukturOrganisasi'])->name('getStrukturOrganisasi');
Route::post('/daftar-struktur-organisasi/create', [DaftarPenggunaController::class, 'postStrukturOrganisasi'])->name('postStrukturOrganisasi');

Route::get('/pengumuman', [PengumumanController::class, 'getIndex'])->name('get.Index.Pengumuman');
Route::post('/pengumuman/create', [PengumumanController::class, 'storePengumuman'])->name('post.Pengumuman');
Route::put('/pengumuman/update/{id}', [PengumumanController::class, 'putPengumuman'])->name('put.Pengmumuman');
Route::delete('/pengumuman/delete/{id}', [PengumumanController::class, 'deletePengumuman'])->name('delete.Pengumuman');

// routeu untuk semua akun
Route::get('/record-download/file/{id}', [UploadFileController::class, 'recordActivity1'])->name('recordActivity');
Route::post('/tambah-folder', [UploadFileController::class, 'storeFolder'])->name('post.Folder');
Route::post('/tambah-dalam-folder', [UploadFileController::class, 'postNameFolder'])->name('post.Dalam.Folder');
Route::post('/tambah-dalam-folder-file', [UploadFileController::class, 'postNameFile'])->name('post.Dalam.Folder.File');
Route::post('/tambah-file', [UploadFileController::class, 'storeFile'])->name('post.File');
Route::get('/folder/{id}', [HomeController::class, 'getDetails'])->name('get.Details');
Route::get('/edit/{id}', [HomeController::class, 'getEdit'])->name('get.Edit');
Route::put('/update-nama-folder/{id}', [HomeController::class, 'putEditFolder'])->name('put.Nama.Folder');
Route::put('/update-status/{id} ', [HomeController::class, 'putNameFolder'])->name('put.Update.Status');
Route::put('/pulihkan-status/{id} ', [HomeController::class, 'putPulihkanNamaFolder'])->name('put.Pulihkan.Status');

Route::get('/sampah', [HomeController::class, 'getSampah'])->name('get.Sampah');
