<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;

Route::post('/reviews/{recipe}', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/unique-values', [RecipeController::class, 'getUniqueValues']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/recipes/{id}/description', [RecipeController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('description');

Route::get('/recipes/{id}/letscook', [RecipeController::class, 'letscook'])
    ->middleware(['auth', 'verified'])
    ->name('letscook');

Route::get('/search', 'RecipeController@search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
