<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;

Route::get('recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/search', [RecipeController::class, 'search'])->name('recipes.search');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/descripe', function () {
    return view('UserPage.descripe');
})->middleware(['auth', 'verified'])->name('descripe');

Route::get('/letscook', function () {
    return view('UserPage.letscook');
})->middleware(['auth', 'verified'])->name('letscook');

Route::get('/dashboard', [RecipeController::class, 'showDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/search', 'RecipeController@search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
