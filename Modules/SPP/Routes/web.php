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

Route::prefix('spp')->middleware('role:Bendahara|Admin')->group(function() {
    Route::post('generate-midtrans-token', 'SPPController@generateMidtransToken')->name('spp.generate_midtrans_token');
    Route::get('/', 'SPPController@index');

    Route::get('murid','SPPController@murid')->name('spp.murid.index');
    Route::get('murid/detail/{id}','SPPController@detail')->name('spp.murid.detail');
    Route::get('murid/update-pembayaran','SPPController@updatePembayaran')->name('spp.murid.update.pembayaran');

});

Route::prefix('spp')->middleware('role:Admin')->group(function() {
    Route::post('/update','SPPController@update')->name('spp.update');
});

Route::middleware(['auth', 'role:Murid'])->prefix('pembayaran')->group(function() {
    Route::get('/', 'SPPController@tagihanMurid')->name('pembayaran.index');
});

