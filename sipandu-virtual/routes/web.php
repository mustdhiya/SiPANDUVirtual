<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers - Auth
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Controllers - Admin
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\TriwulanController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\ApproveGuruController;
use App\Http\Controllers\Admin\ReviewTriwulanController;
use App\Http\Controllers\Admin\DiskusiController as AdminDiskusiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\GudangController;

/*
|--------------------------------------------------------------------------
| Controllers - Guru
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\TriwulanController as GuruTriwulanController;
use App\Http\Controllers\Guru\DiskusiController as GuruDiskusiController;
use App\Http\Controllers\Guru\GudangController as GuruGudangController;


/*
|--------------------------------------------------------------------------
| PUBLIC / AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');


    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.post');
});


// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');



/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| Semua route khusus ADMIN dikumpulkan di sini.
|
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin.required'])
    ->name('admin.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran
        |--------------------------------------------------------------------------
        */

        Route::prefix('tahun-ajaran')
            ->name('tahun-ajaran.')
            ->group(function () {

                Route::get('/', [TahunAjaranController::class, 'index'])
                    ->name('index');

                Route::get('/create', [TahunAjaranController::class, 'create'])
                    ->name('create');

                Route::post('/', [TahunAjaranController::class, 'store'])
                    ->name('store');

                Route::get('/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])
                    ->name('edit');

                Route::put('/{tahunAjaran}', [TahunAjaranController::class, 'update'])
                    ->name('update');

                Route::delete('/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])
                    ->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | Triwulan
        |--------------------------------------------------------------------------
        */

        Route::prefix('triwulan')
            ->name('triwulan.')
            ->group(function () {

                Route::get('/', [TriwulanController::class, 'index'])
                    ->name('index');

                Route::get('/create', [TriwulanController::class, 'create'])
                    ->name('create');

                Route::post('/', [TriwulanController::class, 'store'])
                    ->name('store');

                Route::get('/{triwulan}/edit', [TriwulanController::class, 'edit'])
                    ->name('edit');

                Route::put('/{triwulan}', [TriwulanController::class, 'update'])
                    ->name('update');

                Route::delete('/{triwulan}', [TriwulanController::class, 'destroy'])
                    ->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | Sekolah Binaan
        |--------------------------------------------------------------------------
        */

        Route::prefix('sekolah')
            ->name('sekolah.')
            ->group(function () {

                Route::get('/', [SekolahController::class, 'index'])
                    ->name('index');

                Route::get('/create', [SekolahController::class, 'create'])
                    ->name('create');

                Route::post('/', [SekolahController::class, 'store'])
                    ->name('store');

                Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])
                    ->name('edit');

                Route::put('/{sekolah}', [SekolahController::class, 'update'])
                    ->name('update');

                Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])
                    ->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | Guru Binaan
        |--------------------------------------------------------------------------
        */

        Route::prefix('guru')
            ->name('guru.')
            ->group(function () {

                Route::get('/', [GuruController::class, 'index'])
                    ->name('index');

                Route::get('/create', [GuruController::class, 'create'])
                    ->name('create');

                Route::post('/', [GuruController::class, 'store'])
                    ->name('store');
                
                Route::get('/hubungkan-akun', [GuruController::class, 'linkAccount'])
                    ->name('link-account');

                Route::post('/hubungkan-akun', [GuruController::class, 'storeLinkedAccount'])
                    ->name('store-linked-account');

                Route::get('/{guru}/edit', [GuruController::class, 'edit'])
                    ->name('edit');

                Route::put('/{guru}', [GuruController::class, 'update'])
                    ->name('update');

                Route::delete('/{guru}', [GuruController::class, 'destroy'])
                    ->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | Dokumen Wajib
        |--------------------------------------------------------------------------
        */

        Route::prefix('dokumen')
            ->name('dokumen.')
            ->group(function () {

                Route::get('/', [DokumenController::class, 'index'])
                    ->name('index');

                Route::get('/create', [DokumenController::class, 'create'])
                    ->name('create');

                Route::post('/', [DokumenController::class, 'store'])
                    ->name('store');

                Route::get('/{dokumen}/edit', [DokumenController::class, 'edit'])
                    ->name('edit');

                Route::put('/{dokumen}', [DokumenController::class, 'update'])
                    ->name('update');

                Route::delete('/{dokumen}', [DokumenController::class, 'destroy'])
                    ->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | Approve Guru
        |--------------------------------------------------------------------------
        */

        Route::prefix('approve-guru')
            ->name('approve-guru.')
            ->group(function () {

                Route::get('/', [ApproveGuruController::class, 'index'])
                    ->name('index');

                Route::post('/{user}/approve', [ApproveGuruController::class, 'approve'])
                    ->name('approve');

                Route::post('/{user}/reject', [ApproveGuruController::class, 'reject'])
                    ->name('reject');
            });


        /*
        |--------------------------------------------------------------------------
        | Review Triwulan
        |--------------------------------------------------------------------------
        */

        Route::prefix('review-triwulan')
            ->name('review-triwulan.')
            ->group(function () {

                Route::get('/', [ReviewTriwulanController::class, 'index'])
                    ->name('index');

                Route::get('/{submissionId}', [ReviewTriwulanController::class, 'show'])
                    ->name('show');

                Route::post('/upload/{uploadId}/review', [ReviewTriwulanController::class, 'reviewDokumen'])
                    ->name('review-dokumen');

                Route::post('/submission/{submissionId}/review', [ReviewTriwulanController::class, 'reviewSubmission'])
                    ->name('review-submission');
            });


        /*
        |--------------------------------------------------------------------------
        | Diskusi Admin
        |--------------------------------------------------------------------------
        */

        Route::prefix('diskusi')
            ->name('diskusi.')
            ->group(function () {

                Route::get('/', [AdminDiskusiController::class, 'index'])
                    ->name('index');

                Route::get('/{periodeId}', [AdminDiskusiController::class, 'show'])
                    ->name('show');

                Route::post('/thread/{threadId}/reply', [AdminDiskusiController::class, 'reply'])
                    ->name('reply');

                Route::post('/thread/{threadId}/lock', [AdminDiskusiController::class, 'lock'])
                    ->name('lock');

                Route::post('/thread/{threadId}/unlock', [AdminDiskusiController::class, 'unlock'])
                    ->name('unlock');
            });


        /*
        |--------------------------------------------------------------------------
        | Laporan
        |--------------------------------------------------------------------------
        */

        Route::prefix('laporan')
            ->name('laporan.')
            ->group(function () {

                Route::get('/', [LaporanController::class, 'index'])
                    ->name('index');

                Route::get('/{periodeId}', [LaporanController::class, 'show'])
                    ->name('show');

                Route::get('/{periodeId}/export-excel', [LaporanController::class, 'exportExcel'])
                    ->name('export-excel');

                Route::get('/{periodeId}/export-pdf', [LaporanController::class, 'exportPdf'])
                    ->name('export-pdf');
            });


        /*
        |--------------------------------------------------------------------------
        | Monitoring
        |--------------------------------------------------------------------------
        */

        Route::prefix('monitoring')
            ->name('monitoring.')
            ->group(function () {

                Route::get('/', [MonitoringController::class, 'index'])
                    ->name('index');

                Route::get('/{periodeId}', [MonitoringController::class, 'show'])
                    ->name('show');

                Route::post('/{guruId}/{periodeId}/catatan', [MonitoringController::class, 'updateCatatan'])
                    ->name('update-catatan');
            });


        /*
        |--------------------------------------------------------------------------
        | Gudang PAI-BMTS Admin
        |--------------------------------------------------------------------------
        */

        Route::prefix('gudang')
            ->name('gudang.')
            ->group(function () {

                Route::get('/', [GudangController::class, 'index'])
                    ->name('index');

                Route::get('/create', [GudangController::class, 'create'])
                    ->name('create');

                Route::post('/', [GudangController::class, 'store'])
                    ->name('store');

                Route::get('/{materi}/edit', [GudangController::class, 'edit'])
                    ->name('edit');

                Route::put('/{materi}', [GudangController::class, 'update'])
                    ->name('update');

                Route::delete('/{materi}', [GudangController::class, 'destroy'])
                    ->name('destroy');
            });

    });



/*
|--------------------------------------------------------------------------
| GURU ROUTES
|--------------------------------------------------------------------------
|
| Semua route khusus GURU dikumpulkan di sini.
|
*/

Route::prefix('guru')
    ->middleware(['auth', 'guru.required'])
    ->name('guru.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard Guru
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [GuruDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Triwulan Guru
        |--------------------------------------------------------------------------
        */

        Route::prefix('triwulan')
            ->name('triwulan.')
            ->group(function () {

                Route::get('/', [GuruTriwulanController::class, 'index'])
                    ->name('index');

                Route::get('/{periodeId}', [GuruTriwulanController::class, 'show'])
                    ->name('show');

                Route::post('/{periodeId}/upload', [GuruTriwulanController::class, 'upload'])
                    ->name('upload');

                Route::post('/{periodeId}/submit', [GuruTriwulanController::class, 'submit'])
                    ->name('submit');
            });


        /*
        |--------------------------------------------------------------------------
        | Diskusi Guru
        |--------------------------------------------------------------------------
        */

        Route::prefix('diskusi')
            ->name('diskusi.')
            ->group(function () {

                Route::get('/', [GuruDiskusiController::class, 'index'])
                    ->name('index');

                Route::get('/{periodeId}', [GuruDiskusiController::class, 'show'])
                    ->name('show');

                Route::get('/{periodeId}/create', [GuruDiskusiController::class, 'create'])
                    ->name('create');

                Route::post('/{periodeId}', [GuruDiskusiController::class, 'store'])
                    ->name('store');

                Route::post('/thread/{threadId}/reply', [GuruDiskusiController::class, 'reply'])
                    ->name('reply');
            });


        /*
        |--------------------------------------------------------------------------
        | Gudang PAI-BMTS Guru
        |--------------------------------------------------------------------------
        */

        Route::prefix('gudang')
            ->name('gudang.')
            ->group(function () {

                Route::get('/', [GuruGudangController::class, 'index'])
                    ->name('index');

                Route::get('/{materiId}/download', [GuruGudangController::class, 'download'])
                    ->name('download');
            });

    });
