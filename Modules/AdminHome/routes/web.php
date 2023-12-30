<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminHome\app\Http\Controllers\AdminHomeController;

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
        'auth'
    ]
], function () {
    Route::get('/', [AdminHomeController::class,'index'])->name('admin.home');
});
