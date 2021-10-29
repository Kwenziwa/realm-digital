<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishController;

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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Run These for the purpose of testing
 */
Route::get('/donwload-employees', [App\Http\Controllers\WishController::class, 'DonwloadEmployee'])->name('donwload_employees');
Route::get('/send-wish', [App\Http\Controllers\WishController::class, 'SendWish'])->name('send_wish');



