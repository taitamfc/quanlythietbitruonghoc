<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminBorrow\app\Http\Controllers\AdminBorrowController;
use Modules\AdminBorrow\app\Http\Controllers\AdminBorrowDeviceController;
use Modules\AdminBorrow\app\Http\Controllers\AdminBorrowLabController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => [
        'systeminit',
        'auth'
    ]
], function () {
    Route::group([
        'prefix' => 'adminborrow',
    ], function () {
        Route::get('devices', [AdminBorrowDeviceController::class,'devices'])->name('adminborrow.devices');
        Route::get('exportBorrowDeviceByUser', [AdminBorrowDeviceController::class,'exportBorrowDeviceByUser'])->name('adminborrow.exportBorrowDeviceByUser');
        Route::get('exportBorrowDeviceByNest', [AdminBorrowDeviceController::class,'exportBorrowDeviceByNest'])->name('adminborrow.exportBorrowDeviceByNest');
    });
    Route::group([
        'prefix' => 'adminborrow',
    ], function () {
        Route::get('labs', [AdminBorrowLabController::class,'labs'])->name('adminborrow.labs');
        Route::get('exportBorrowLabByUser', [AdminBorrowLabController::class,'exportBorrowLabByUser'])->name('adminborrow.exportBorrowLabByUser');
        Route::get('exportBorrowLabByNest', [AdminBorrowLabController::class,'exportBorrowLabByNest'])->name('adminborrow.exportBorrowDeviceByNest');
    });
    Route::resource('adminborrow', AdminBorrowController::class)->names('adminborrow');
});
