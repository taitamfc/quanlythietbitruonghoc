<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\app\Http\Controllers\AuthController;

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
    'prefix' => 'auth'
], function () {
    Route::get('login',[AuthController::class,'login'])->name('website.login');
    Route::post('postLogin',[AuthController::class,'postLogin'])->name('website.postLogin');
    Route::get('logout',[AuthController::class,'Logout'])->name('website.logout');

    // Register
    Route::get('register',[AuthController::class,'register'])->name('website.register');
    Route::post('postRegister',[AuthController::class,'postRegister'])->name('website.postRegister');

    // Forgot password
    Route::get('/forgot',[AuthController::class,'forgot'])->name('website.forgot');
    Route::post('/postForgot',[AuthController::class,'postForgot'])->name('website.postForgot');
    Route::get('/resetPassword/{user}/{token}',[AuthController::class,'getReset'])->name('website.getReset');
    Route::post('/resetPassword/{user}/{token}',[AuthController::class,'postReset'])->name('website.postReset');
});


