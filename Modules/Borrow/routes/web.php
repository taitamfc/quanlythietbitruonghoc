<?php

use Illuminate\Support\Facades\Route;
use Modules\Borrow\app\Http\Controllers\BorrowController;
use Modules\Borrow\app\Http\Controllers\BorrowLabController;

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
    'middleware'=>['auth']
], function () {
    Route::get('borrows/labs', [BorrowLabController::class,'index'])->name('borrows.labs');
    Route::resource('borrows', BorrowController::class)->names('borrows');
});