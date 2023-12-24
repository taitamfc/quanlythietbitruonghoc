<?php

use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\UserController;

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

Route::group(['prefix'=>'website','middleware'=>['auth']], function () {
    Route::get('/users', [UserController::class,'index'])->name('website.users.index');
    Route::get('/users/edit', [UserController::class,'edit'])->name('website.users.edit');
    Route::post('/users/update', [UserController::class,'update'])->name('website.users.update');
});