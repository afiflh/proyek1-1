<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\KuotaController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [LoginController::class, 'logout']);
Route::middleware(['auth', 'ceklevel:admin'])->group(function(){
    Route::get('/admin', [BookingController::class, 'tampil']);
});
Route::middleware(['auth', 'ceklevel:user'])->group(function(){
    Route::get('/booking', [BookingController::class, 'index']);
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking_id}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking_id}/payment/process', [BookingController::class, 'processPayment'])->name('booking.processPayment');
    Route::get('/history', [BookingController::class,'getHistory'])->name('booking.history');
});
Route::middleware(['auth', 'ceklevel:admin,user'])->group(function(){
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/information', [InformationController::class, 'index']);
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/flow', [FlowController::class, 'index']);
    Route::get('/cek-kuota', [KuotaController::class, 'cekKuota'])->name('cek-kuota');
    Route::get('/about-us', [AboutController::class, 'index']);
});