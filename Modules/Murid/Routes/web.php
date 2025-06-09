<?php

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

use Illuminate\Support\Facades\Route;
Route::prefix('murid')->middleware(['auth', 'role:Murid'])->group(function() {
    Route::get('/', 'MuridController@index');

    Route::resources([
      'pembayaran'    => PembayaranController::class
    ]);
});
