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

Route::group(['prefix'=>'users','middleware'=>['auth']], function () {
    Route::get('/', [UserController::class,'index'])->name('users.index');
    Route::get('/edit', [UserController::class,'edit'])->name('users.edit');
    Route::post('/update', [UserController::class,'update'])->name('users.update');
});