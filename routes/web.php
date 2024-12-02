<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\CharacterSegmentController;
use App\Http\Controllers\CharacterMemoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('characters', CharacterController::class);
Route::resource('worlds', WorldController::class);
Route::resource('character-segments', CharacterSegmentController::class);
Route::resource('character-memories', CharacterMemoryController::class);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
