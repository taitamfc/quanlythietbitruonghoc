<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\app\Http\Controllers\HomeController;
use App\Models\Notification;
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
    'middleware' => [
        'systeminit',
        'auth.custom'
    ]
], function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/notification', function () {
        $notifications = Notification::all(); 
        dd($notifications);
    });
    Route::get('/is-read', [HomeController::class,'is_read'])->name('is_read');
});

