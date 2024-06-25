<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavRecipeController;

Route::post('/recipes/{recipe}/favorite', [FavRecipeController::class, 'toggleFavorite'])->name('recipes.favorite');
Route::get('/favorites', [FavRecipeController::class, 'index'])->name('favorites.index');
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

Route::get('/favorite', function () {
    return view('UserPage.favorites');
})->middleware(['auth', 'verified'])->name('favorite');

Route::get('/search', 'RecipeController@search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
