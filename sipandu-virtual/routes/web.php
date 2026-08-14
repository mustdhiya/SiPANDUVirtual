<?php
use App\Http\Controllers\Admin\TahunAjaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes (Auth)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin.required'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/

Route::prefix('guru')
    ->middleware(['auth', 'guru.required'])
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    });

// Admin - Tahun Ajaran
Route::prefix('admin/tahun-ajaran')->name('admin.tahun-ajaran.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [TahunAjaranController::class, 'index'])->name('index');
    Route::get('/create', [TahunAjaranController::class, 'create'])->name('create');
    Route::post('/', [TahunAjaranController::class, 'store'])->name('store');
    Route::get('/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('edit');
    Route::put('/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('update');
    Route::delete('/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\Admin\TriwulanController;

// Admin - Triwulan
Route::prefix('admin/triwulan')->name('admin.triwulan.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [TriwulanController::class, 'index'])->name('index');
    Route::get('/create', [TriwulanController::class, 'create'])->name('create');
    Route::post('/', [TriwulanController::class, 'store'])->name('store');
    Route::get('/{triwulan}/edit', [TriwulanController::class, 'edit'])->name('edit');
    Route::put('/{triwulan}', [TriwulanController::class, 'update'])->name('update');
    Route::delete('/{triwulan}', [TriwulanController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\Admin\SekolahController;

// Admin - Sekolah Binaan
Route::prefix('admin/sekolah')->name('admin.sekolah.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [SekolahController::class, 'index'])->name('index');
    Route::get('/create', [SekolahController::class, 'create'])->name('create');
    Route::post('/', [SekolahController::class, 'store'])->name('store');
    Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('edit');
    Route::put('/{sekolah}', [SekolahController::class, 'update'])->name('update');
    Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\Admin\GuruController;

// Admin - Guru Binaan
Route::prefix('admin/guru')->name('admin.guru.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [GuruController::class, 'index'])->name('index');
    Route::get('/create', [GuruController::class, 'create'])->name('create');
    Route::post('/', [GuruController::class, 'store'])->name('store');
    Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('edit');
    Route::put('/{guru}', [GuruController::class, 'update'])->name('update');
    Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\Admin\DokumenController;

// Admin - Dokumen Wajib
Route::prefix('admin/dokumen')->name('admin.dokumen.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [DokumenController::class, 'index'])->name('index');
    Route::get('/create', [DokumenController::class, 'create'])->name('create');
    Route::post('/', [DokumenController::class, 'store'])->name('store');
    Route::get('/{dokumen}/edit', [DokumenController::class, 'edit'])->name('edit');
    Route::put('/{dokumen}', [DokumenController::class, 'update'])->name('update');
    Route::delete('/{dokumen}', [DokumenController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\Admin\ApproveGuruController;

// Admin - Approve Guru
Route::prefix('admin/approve-guru')->name('admin.approve-guru.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [ApproveGuruController::class, 'index'])->name('index');
    Route::post('/{user}/approve', [ApproveGuruController::class, 'approve'])->name('approve');
    Route::post('/{user}/reject', [ApproveGuruController::class, 'reject'])->name('reject');
});


use App\Http\Controllers\Guru\TriwulanController as GuruTriwulanController;

// Guru - Triwulan
Route::prefix('guru/triwulan')->name('guru.triwulan.')->middleware(['auth', 'guru.required'])->group(function () {
    Route::get('/', [GuruTriwulanController::class, 'index'])->name('index');
    Route::get('/{periodeId}', [GuruTriwulanController::class, 'show'])->name('show');
    Route::post('/{periodeId}/upload', [GuruTriwulanController::class, 'upload'])->name('upload');
    Route::post('/{periodeId}/submit', [GuruTriwulanController::class, 'submit'])->name('submit');
});

use App\Http\Controllers\Admin\ReviewTriwulanController;

// Admin - Review Triwulan
Route::prefix('admin/review-triwulan')->name('admin.review-triwulan.')->middleware(['auth', 'admin.required'])->group(function () {
    Route::get('/', [ReviewTriwulanController::class, 'index'])->name('index');
    Route::get('/{submissionId}', [ReviewTriwulanController::class, 'show'])->name('show');
    Route::post('/upload/{uploadId}/review', [ReviewTriwulanController::class, 'reviewDokumen'])->name('review-dokumen');
    Route::post('/submission/{submissionId}/review', [ReviewTriwulanController::class, 'reviewSubmission'])->name('review-submission');
});