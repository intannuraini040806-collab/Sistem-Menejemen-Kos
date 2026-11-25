<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// ==========================================
// CONTROLLER ADMIN
// ==========================================

use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\LaporanController;

// ==========================================
// CONTROLLER PETUGAS / PENGHUNI
// ==========================================

use App\Http\Controllers\Penghuni\DashboardController;
use App\Http\Controllers\Penghuni\KamarController as PenghuniKamarController;
use App\Http\Controllers\Penghuni\TagihanController as PenghuniTagihanController;


// ==========================================
// HALAMAN UTAMA
// ==========================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


// ==========================================
// DETAIL KAMAR
// ==========================================

Route::get('/kamar/{id}', function ($id) {
    return view('detail-kamar', compact('id'));
})->name('kamar.detail');


// ==========================================
// AUTENTIKASI KOSHAVEN
// ==========================================

// Menampilkan halaman login.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Memproses login.
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.authenticate');

// Menampilkan halaman registrasi.
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

// Memproses registrasi penghuni.
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:3,1')
    ->name('register.store');

// Memproses logout.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==========================================
// ROUTE ADMIN KOSHAVEN
// ==========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD ADMIN
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        // ======================================
        // DATA KAMAR ADMIN
        // ======================================

        Route::get('/kamar', [KamarController::class, 'index'])
            ->name('kamar.index');

        Route::get('/kamar/data', [KamarController::class, 'data'])
            ->name('kamar.data');

        Route::post('/kamar', [KamarController::class, 'store'])
            ->name('kamar.store');

        Route::put('/kamar/{kamar}', [KamarController::class, 'update'])
            ->name('kamar.update');

        Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])
            ->name('kamar.destroy');


        // ======================================
        // BOOKING KOS ADMIN
        // ======================================

        Route::get('/booking', [BookingController::class, 'index'])
            ->name('booking.index');

        Route::post('/booking', [BookingController::class, 'store'])
            ->name('booking.store');

        Route::get('/booking/{booking}', [BookingController::class, 'show'])
            ->name('booking.show');

        Route::patch('/booking/{booking}/setujui', [BookingController::class, 'approve'])
            ->name('booking.approve');

        Route::patch('/booking/{booking}/tolak', [BookingController::class, 'reject'])
            ->name('booking.reject');

        Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])
            ->name('booking.destroy');


        // ======================================
        // DATA PENGHUNI ADMIN
        // ======================================

        Route::get('/penghuni', [PenghuniController::class, 'index'])
            ->name('penghuni.index');

        Route::post('/penghuni', [PenghuniController::class, 'store'])
            ->name('penghuni.store');

        Route::put('/penghuni/{id}', [PenghuniController::class, 'update'])
            ->name('penghuni.update');

        Route::delete('/penghuni/{id}', [PenghuniController::class, 'destroy'])
            ->name('penghuni.destroy');


        // ======================================
        // DATA PETUGAS ADMIN
        // ======================================

        Route::get('/petugas', [PetugasController::class, 'index'])
            ->name('petugas.index');

        Route::post('/petugas', [PetugasController::class, 'store'])
            ->name('petugas.store');

        Route::put('/petugas/{petugas}', [PetugasController::class, 'update'])
            ->name('petugas.update');

        Route::delete('/petugas/{petugas}', [PetugasController::class, 'destroy'])
            ->name('petugas.destroy');


        // ======================================
        // MANAJEMEN PENGGUNA ADMIN
        // ======================================

        Route::get('/pengguna', [PenggunaController::class, 'index'])
            ->name('pengguna.index');

        Route::post('/pengguna', [PenggunaController::class, 'store'])
            ->name('pengguna.store');

        Route::put('/pengguna/{pengguna}', [PenggunaController::class, 'update'])
            ->name('pengguna.update');

        Route::delete('/pengguna/{pengguna}', [PenggunaController::class, 'destroy'])
            ->name('pengguna.destroy');


        // ======================================
        // DATA TAGIHAN ADMIN
        // ======================================

        Route::get('/tagihan', [AdminTagihanController::class, 'index'])
            ->name('tagihan.index');

        Route::post('/tagihan', [AdminTagihanController::class, 'store'])
            ->name('tagihan.store');

        Route::put('/tagihan/{tagihan}', [AdminTagihanController::class, 'update'])
            ->name('tagihan.update');

        Route::delete('/tagihan/{tagihan}', [AdminTagihanController::class, 'destroy'])
            ->name('tagihan.destroy');


        // ======================================
        // DATA PEMBAYARAN ADMIN
        // ======================================

        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran.index');

        Route::patch('/pembayaran/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])
            ->name('pembayaran.verifikasi');

        Route::patch('/pembayaran/{pembayaran}/tolak', [PembayaranController::class, 'tolak'])
            ->name('pembayaran.tolak');


        // ======================================
        // LAPORAN ADMIN
        // ======================================

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');


        // ======================================
        // PROFIL ADMIN
        // ======================================

        Route::get('/profil', function () {
            return view('admin.profil.index');
        })->name('profil.index');

    });


// ==========================================
// ROUTE PETUGAS KOSHAVEN
// ==========================================

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        // DASHBOARD PETUGAS
        Route::get('/dashboard', function () {
            return view('petugas.dashboard');
        })->name('dashboard');


        // DATA KAMAR
        Route::get('/kamar', function () {
            return view('petugas.kamar');
        })->name('kamar.index');


        // DATA PENGHUNI
        Route::get('/penghuni', function () {
            return view('petugas.penghuni');
        })->name('penghuni.index');


        // DATA TAGIHAN
        Route::get('/tagihan', function () {
            return view('petugas.tagihan');
        })->name('tagihan.index');


        // DATA PEMBAYARAN
        Route::get('/pembayaran', function () {
            return view('petugas.pembayaran');
        })->name('pembayaran.index');


        // AKTIVITAS PETUGAS
        Route::get('/aktivitas', function () {
            return view('petugas.aktivitas');
        })->name('aktivitas.index');


        // PROFIL PETUGAS
        Route::get('/profil', function () {
            return view('petugas.profil');
        })->name('profil.index');

    });


// ==========================================
// ROUTE PENGHUNI KOSHAVEN
// ==========================================

Route::middleware(['auth', 'role:penghuni'])
    ->prefix('penghuni')
    ->name('penghuni.')
    ->group(function () {

        // DASHBOARD PENGHUNI
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        // ======================================
        // KAMAR SAYA
        // ======================================

        Route::get('/kamar', [PenghuniKamarController::class, 'index'])
            ->name('kamar.index');

        Route::post('/kamar/booking', [PenghuniKamarController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('kamar.booking.store');


        // ======================================
        // TAGIHAN BULANAN PENGHUNI
        // ======================================

        Route::get('/tagihan', [PenghuniTagihanController::class, 'index'])
            ->name('tagihan.index');


        // ======================================
        // RIWAYAT PEMBAYARAN
        // ======================================

        Route::get('/riwayat-pembayaran', function () {
            return view('penghuni.riwayat');
        })->name('riwayat.index');


        // ======================================
        // FASILITAS KOS
        // ======================================

        Route::get('/fasilitas', function () {
            return view('penghuni.fasilitas');
        })->name('fasilitas.index');


        // ======================================
        // PROFIL PENGHUNI
        // ======================================

        Route::get('/profil', function () {
            return view('penghuni.profil');
        })->name('profil.index');

    });


// ==========================================
// JADWAL PENERBITAN TAGIHAN
// ==========================================

Schedule::command('tagihan:terbitkan')
    ->dailyAt('01:00')
    ->withoutOverlapping();
