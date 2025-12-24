<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;

Route::get('/', function () {
    return view('index');
});

// Login-User
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/aksi', [AuthController::class, 'login'])->name('login.aksi');

// Register-User
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/aksi', [AuthController::class, 'register'])->name('register.aksi');

// Logout-User
Route::post('/logout', function () {
    Auth::guard('masyarakat')->logout();
    return redirect('/login');
})->name('logout.user');

Route::prefix('user')->middleware('auth:masyarakat')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::get('/pengaduan', [UserController::class, 'showPengaduan'])->name('user.pengaduan');
    Route::post('/pengaduan/tambah', [UserController::class, 'pengaduanTambah'])->name('user.pengaduan.tambah');
    Route::put('/pengaduan/edit/{id}', [UserController::class, 'pengaduanEdit'])->name('user.pengaduan.edit');
    Route::get('/pengaduan/hapus/{id}', [UserController::class, 'pengaduanHapus'])->name('user.pengaduan.hapus');
    Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
});

// Login-Petugas
Route::get('/login-admin', [AuthController::class, 'showLoginAdminForm'])->name('login-admin');
Route::post('/login-admin/aksi', [AuthController::class, 'loginAdmin'])->name('login-admin.aksi');

// Register-Petugas
Route::get('/register-admin', [AuthController::class, 'showLoginAdminForm'])->name('register-admin');

Route::prefix('admin')->middleware('auth:petugas')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/user/masyarakat', [AdminController::class, 'showUser'])->name('admin.masyarakat');
    Route::get('/user/petugas', [AdminController::class, 'showPetugas'])->name('admin.petugas');
    Route::post('/user/petugas/tambah', [AdminController::class, 'tambahPetugas'])->name('admin.petugas.tambah');
    Route::delete('/pengaduan/hapus/{id}', [AdminController::class, 'hapusPengaduan'])->name('admin.pengaduan.hapus');
    Route::get('/pengaduan/belum-ditanggapi', [AdminController::class, 'showPengaduanBaru'])->name('admin.pengaduan.belum-ditanggapi');
    Route::put('/pengaduan/verifikasi/{id}', [AdminController::class, 'verifikasiPengaduan'])->name('admin.pengaduan.verifikasi');
    Route::get('/pengaduan/proses', [AdminController::class, 'showPengaduanProses'])->name('admin.pengaduan.proses');
    Route::post('/pengaduan/tanggapan/{id}', [AdminController::class, 'tanggapanPengaduan'])->name('admin.pengaduan.tanggapan');
    Route::get('/pengaduan/selesai', [AdminController::class, 'showPengaduanSelesai'])->name('admin.pengaduan.selesai');
    Route::get('/tanggapan', [AdminController::class, 'showTanggapan'])->name('admin.tanggapan');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan-pdf', [AdminController::class, 'generatePdf'])->name('admin.laporan.pdf');
});

Route::prefix('petugas')->middleware('auth:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'showDashboard'])->name('petugas.dashboard');
    Route::delete('/pengaduan/hapus/{id}', [PetugasController::class, 'hapusPengaduan'])->name('petugas.pengaduan.hapus');
    Route::get('/pengaduan/belum-ditanggapi', [PetugasController::class, 'showPengaduanBaru'])->name('petugas.pengaduan.belum-ditanggapi');
    Route::put('/pengaduan/verifikasi/{id}', [PetugasController::class, 'verifikasiPengaduan'])->name('petugas.pengaduan.verifikasi');
    Route::get('/pengaduan/proses', [PetugasController::class, 'showPengaduanProses'])->name('petugas.pengaduan.proses');
    Route::post('/pengaduan/tanggapan/{id}', [PetugasController::class, 'tanggapanPengaduan'])->name('petugas.pengaduan.tanggapan');
    Route::get('/pengaduan/selesai', [PetugasController::class, 'showPengaduanSelesai'])->name('petugas.pengaduan.selesai');
    Route::get('/tanggapan', [PetugasController::class, 'showTanggapan'])->name('petugas.tanggapan');
});

Route::post('/admin/logout', function () {
    Auth::guard('petugas')->logout();
    return redirect('/login-admin');
})->name('logout.admin');