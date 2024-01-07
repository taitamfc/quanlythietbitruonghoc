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
        'auth.custom'
    ]
], function () {
    Route::get('adminborrow/devices', [AdminBorrowDeviceController::class,'devices'])->name('adminborrow.devices');
    Route::get('adminborrow/labs', [AdminBorrowLabController::class,'labs'])->name('adminborrow.labs');
    Route::resource('adminborrow', AdminBorrowController::class)->names('adminborrow');
});
