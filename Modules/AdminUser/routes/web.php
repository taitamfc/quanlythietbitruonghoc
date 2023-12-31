<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminUser\app\Http\Controllers\AdminAuthController;
use Modules\AdminUser\app\Http\Controllers\AdminUserController;
use Modules\AdminUser\app\Http\Controllers\AdminGroupController;

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
    Route::group(['prefix'=>'adminuser'], function () {
        Route::get('login',[AdminAuthController::class,'login'])->name('login');
        Route::post('postLogin',[AdminAuthController::class,'postLogin'])->name('adminuser.postLogin');

        Route::get('register',[AdminAuthController::class,'register'])->name('adminuser.register');
        Route::post('postRegister',[AdminAuthController::class,'postRegister'])->name('adminuser.postRegister');

        Route::get('forgotPass',[AdminAuthController::class,'forgotPass'])->name('adminuser.forgotPass');
        Route::post('postForgotPass',[AdminAuthController::class,'postForgotPass'])->name('adminuser.postForgotPass');

        Route::get('resetPass',[AdminAuthController::class,'resetPass'])->name('adminuser.resetPass');
        Route::post('postResetPass',[AdminAuthController::class,'postResetPass'])->name('adminuser.postResetPass');
    });
});

Route::put('admingroup-update/{id}',[AdminGroupController::class,'saveRoles'])->name('admingroup.saveRoles');

Route::group([
    'prefix' => 'admin',
    'middleware' => [
        'systeminit',
        'auth.custom'
    ]
], function () {
    Route::resource('adminuser', AdminUserController::class)->names('adminuser');
    Route::resource('admingroup', AdminGroupController::class)->names('admingroup');
});

