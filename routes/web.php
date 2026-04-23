<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NetflixController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/landing', [NetflixController::class, 'landing'])->name('landing');
Route::get('/profiles', [NetflixController::class, 'profiles'])->name('profiles');
Route::get('/browse', [NetflixController::class, 'browse'])->name('browse');
Route::get('/movies', [NetflixController::class, 'movies'])->name('movies');
Route::get('/series', [NetflixController::class, 'series'])->name('series');
Route::get('/new-and-popular', [NetflixController::class, 'newPopular'])->name('new-popular');
Route::get('/my-list', [NetflixController::class, 'myList'])->name('my-list');
Route::get('/watch/{slug?}', [NetflixController::class, 'watch'])->name('watch');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';
