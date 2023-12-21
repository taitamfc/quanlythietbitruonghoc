<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminTheme\app\Http\Controllers\AdminThemeController;

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
Route::group(['prefix'=>'admin'], function () {
    Route::group(['prefix'=>'admintheme'], function () {
        Route::get('/', [AdminThemeController::class,'index'])->name('admintheme.index');
        Route::get('/create', [AdminThemeController::class,'create'])->name('admintheme.create');
        Route::get('/login', [AdminThemeController::class,'login'])->name('admintheme.login');
    });
});
