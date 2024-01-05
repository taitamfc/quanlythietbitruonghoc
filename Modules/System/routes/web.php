<?php

use Illuminate\Support\Facades\Route;
use Modules\System\app\Http\Controllers\SystemController;
use Modules\System\app\Http\Controllers\UpdateController;
use Modules\System\app\Http\Controllers\InstallController;
use Modules\System\app\Http\Controllers\OptionController;

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

Route::group([], function () {
    Route::get('system/',[SystemController::class,'index'])->name('system.index');
    // Option
    Route::get('options',[OptionController::class,'index'])->name('system.options.index');
    Route::post('options/update',[OptionController::class,'update'])->name('system.options.update');
    // Update
    Route::get('system/update',[UpdateController::class,'index'])->name('system.update.index');
    Route::post('system/doUpdate',[UpdateController::class,'doUpdate'])->name('system.update.doUpdate');
    // Install
    Route::get('system/install',[InstallController::class,'index'])->name('system.install.index');
    Route::get('system/doInstall',[InstallController::class,'doInstall'])->name('system.install.doInstall');
});
