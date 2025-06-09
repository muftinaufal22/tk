<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Pengguna\PpdController;

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

// Route untuk pengaturan PPDB
Route::middleware(['auth', 'role:Admin|PPDB'])->group(function () {
    Route::get('/ppdb/buka-tutup-ppd', [PpdController::class, 'index'])->name('ppd.index');
    Route::put('/ppdb/buka-tutup-ppd', [PpdController::class, 'update'])->name('ppd.update');
});
