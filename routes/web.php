<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FotoController;

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


// Menerapkan middleware auth pada route home
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');; //Mendefinisikan route untuk home
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');; //Mendefinisikan route untuk home

// Menerapkan middleware auth pada semua route yang berkaitan dengan album
Route::middleware(['auth'])->group(function () {
    Route::prefix('album')->name('albums.')->group(function () {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/create', [AlbumController::class, 'create'])->name('create');
        Route::post('/store', [AlbumController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AlbumController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlbumController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlbumController::class, 'destroy'])->name('destroy');
    });
});

// Menerapkan middleware auth pada semua route yang berkaitan dengan foto
Route::middleware(['auth'])->group(function () {
    Route::prefix('foto')->name('foto.')->group(function () {
        Route::get('/', [FotoController::class, 'index'])->name('index');
        Route::get('/create', [FotoController::class, 'create'])->name('create');
        Route::post('/store', [FotoController::class, 'store'])->name('store');

    });
});

// Route untuk autentikasi, menggunakan middleware guest
Route::name('auth.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [AuthController::class, 'loginForm'])->name('loginForm');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('signup', [AuthController::class, 'signupForm'])->name('signupForm'); //Route untuk menampilkan halaman pendaftaran
        Route::post('signup', [AuthController::class, 'signup'])->name('signup'); //Route untuk menangani proses pendaftaran
    });

    // Logout harus tersedia hanya untuk pengguna yang terautentikasi
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

});