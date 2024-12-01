<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('characters', CharacterController::class);
Route::resource('worlds', WorldController::class);
Route::resource('character-segments', CharacterSegmentController::class);
Route::resource('character-memories', CharacterMemoryController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
