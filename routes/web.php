<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\CharacterSegmentController;
use App\Http\Controllers\CharacterMemoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/characters/list', [CharacterController::class, 'list']);
Route::resource('characters', CharacterController::class);
Route::resource('worlds', WorldController::class);
Route::resource('character-segments', CharacterSegmentController::class);
Route::resource('character-memories', CharacterMemoryController::class);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/worlds', [WorldController::class, 'index'])->middleware('auth');
Route::post('/worlds', [WorldController::class, 'store'])->middleware('auth');
Route::get('/characters/{character}/segments', [CharacterSegmentController::class, 'index'])->name('characters.segments');
Route::get('/characters/{character}/misc', [CharacterSegmentController::class, 'misc'])->name('characters.misc');
Route::get('/characters/{character}/memories', [CharacterMemoryController::class, 'index'])->name('characters.memories');
Route::get('/characters/{character}/prompts', [CharacterController::class, 'prompts'])->name('characters.prompts');
Route::get('/characters/{character}/gallery', [CharacterController::class, 'gallery'])->name('characters.gallery');
Route::get('/characters/{character}/worlds', [CharacterController::class, 'getWorlds']);
Route::post('/characters/{character}/worlds/{world}', [CharacterController::class, 'addWorld']);
Route::delete('/characters/{character}/worlds/{world}', [CharacterController::class, 'removeWorld']);
Route::get('/worlds/{world}/characters', [WorldController::class, 'getCharacters']);
Route::get('/worlds/{world}', [WorldController::class, 'show']);
Route::post('/characters/{character}/images', [ImageController::class, 'store']);
Route::delete('/characters/{character}/images/{image}', [ImageController::class, 'destroy']);
Route::match(['post', 'delete'], '/characters/{character}/images/{image}/set-profile', [ImageController::class, 'setProfile']);
Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/admin', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
});
Route::post('/characters/{character}/segments', [CharacterSegmentController::class, 'store']);
Route::patch('/characters/{character}/segments/{segment}', [CharacterSegmentController::class, 'update']);
Route::delete('/characters/{character}/segments/{segment}', [CharacterSegmentController::class, 'destroy']);
Route::get('/characters/{character}/segments/backstory', [CharacterSegmentController::class, 'backstory']);
Route::post('/characters/{character}/segments/backstory', [CharacterSegmentController::class, 'storeBackstory']);
Route::patch('/characters/{character}/prompts', [CharacterController::class, 'updatePrompts']);
Route::get('/characters/{character}/memories', [CharacterMemoryController::class, 'index'])->name('characters.memories');
Route::post('/characters/{character}/memories', [CharacterMemoryController::class, 'store']);
Route::patch('/characters/{character}/memories/{memory}', [CharacterMemoryController::class, 'update']);
Route::delete('/characters/{character}/memories/{memory}', [CharacterMemoryController::class, 'destroy']);

Auth::routes();
