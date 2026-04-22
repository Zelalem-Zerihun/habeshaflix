<?php

use App\Http\Controllers\NetflixController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NetflixController::class, 'landing'])->name('landing');
Route::get('/profiles', [NetflixController::class, 'profiles'])->name('profiles');
Route::get('/browse', [NetflixController::class, 'browse'])->name('browse');
Route::get('/movies', [NetflixController::class, 'movies'])->name('movies');
Route::get('/series', [NetflixController::class, 'series'])->name('series');
Route::get('/new-and-popular', [NetflixController::class, 'newPopular'])->name('new-popular');
Route::get('/my-list', [NetflixController::class, 'myList'])->name('my-list');
Route::get('/watch/{slug?}', [NetflixController::class, 'watch'])->name('watch');
Route::get('/signin', [NetflixController::class, 'signIn'])->name('signin');
