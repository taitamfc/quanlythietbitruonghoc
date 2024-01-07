<?php

use Illuminate\Support\Facades\Route;
use Modules\Device\app\Http\Controllers\DeviceController;

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
    'prefix'=>'devices',
    'middleware'=>['auth']
], function () {
    Route::get('/',[DeviceController::class,'index'])->name('devices.index');
});