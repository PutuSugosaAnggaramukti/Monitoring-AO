<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountOfficerController;
use App\Http\Controllers\API\NasabahController;

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

});