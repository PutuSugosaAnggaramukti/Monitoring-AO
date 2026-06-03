<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountOfficerController;
use App\Http\Controllers\API\NasabahController;
use App\Http\Controllers\API\DashboardMarketingController;  
use App\Http\Controllers\API\LaporanKunjunganController;
use App\Http\Controllers\API\JadwalKunjunganController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT OFFICER
    |--------------------------------------------------------------------------
    */
    Route::prefix('account-officer')->group(function () {

        Route::get('/',        [AccountOfficerController::class, 'index']);
        Route::post('/',       [AccountOfficerController::class, 'store']);
        Route::get('/{id}',    [AccountOfficerController::class, 'show']);
        Route::put('/{id}',    [AccountOfficerController::class, 'update']);
        Route::delete('/{id}', [AccountOfficerController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | NASABAH
    |--------------------------------------------------------------------------
    */
    Route::prefix('nasabah')->group(function () {

        // GET DATA NASABAH
        Route::get('/', [NasabahController::class, 'index']);

        // IMPORT EXCEL
        Route::post('/import', [NasabahController::class, 'import']);
    });

    /*
    |--------------------------------------------------------------------------
    | LAPORAN KUNJUNGAN
    |--------------------------------------------------------------------------
    */
   Route::prefix('laporan-kunjungan')->group(function () {
        Route::get('/',                        [LaporanKunjunganController::class, 'index']);
        Route::get('/lama',                    [LaporanKunjunganController::class, 'indexLama']);
        Route::get('/nasabah/{nasabah_id}',    [LaporanKunjunganController::class, 'showByNasabah']);
        Route::get('/jadwal/{jadwal_id}',      [LaporanKunjunganController::class, 'showByJadwal']); // ← tambah
        Route::post('/',                       [LaporanKunjunganController::class, 'store']);
        Route::post('/lama',                   [LaporanKunjunganController::class, 'storeLama']);
        Route::delete('/{id}',                 [LaporanKunjunganController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | JADWAL KUNJUNGAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('jadwal-kunjungan')->group(function () {
         Route::get(
        '/dropdown-nasabah',
        [JadwalKunjunganController::class, 'dropdownNasabah']
        );
        Route::get('/',       [JadwalKunjunganController::class, 'index']);
        Route::post('/',      [JadwalKunjunganController::class, 'store']);
        Route::put('/{id}',   [JadwalKunjunganController::class, 'update']);
        Route::delete('/{id}',[JadwalKunjunganController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MARKETING
    |--------------------------------------------------------------------------
    */
     Route::get(
        '/dashboard-marketing',
        [DashboardMarketingController::class, 'index']
    );
});