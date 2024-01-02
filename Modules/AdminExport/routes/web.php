<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminExport\app\Http\Controllers\AdminExportController;

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
    Route::get('adminexport', [AdminExportController::class,'index'])->name('adminexport.index');
    Route::post('adminexport', [AdminExportController::class,'store'])->name('adminexport.store');
});
