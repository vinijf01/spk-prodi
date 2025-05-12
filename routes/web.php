<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\PilihanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PreferensiController;
use App\Http\Controllers\ProsesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('index');


Route::get('', [ProsesController::class, 'index'])->name('index');

Route::post('/check', [ProsesController::class, 'pilihanProdi'])->name('pilihan-prodi');
Route::post('/pertanyaan', [ProsesController::class, 'pertanyaan'])->name('pertanyaan-prodi');
Route::post('/hasilpilihan', [ProsesController::class, 'hasilPilihan'])->name('hasil-pilihan');
Route::get('/cetak/hasil', [ProsesController::class, 'createPDF'])->name('createPDF');


Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-request');
Route::get('/logout',  [LogoutController::class, 'perform'])->name('logout.perform')->middleware('auth');


Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard-admin');
Route::resource('admin-prodi', ProdiController::class);
Route::resource('admin-sekolah', SekolahController::class);
Route::resource('admin-pilihan', PilihanController::class);
Route::post('admin-pilihan/{id}', [PilihanController::class, 'store']);
Route::resource('admin-kriteria', KriteriaController::class);
Route::resource('admin-pertanyaan', PertanyaanController::class);
Route::resource('admin-preferensi', PreferensiController::class);
