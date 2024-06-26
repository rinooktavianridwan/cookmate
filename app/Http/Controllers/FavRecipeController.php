<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavRecipeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $favorites = $user->favorites();

        // Jika ada pencarian, filter berdasarkan judul
        if ($request->has('search') && !empty($request->search)) {
            $favorites = $favorites->where('title', 'like', '%' . $request->search . '%');
        }

        $favorites = $favorites->get();

        // Cek jika request adalah AJAX
        if ($request->ajax()) {
            return response()->json(['favorites' => $favorites]);
        }

        return view('favorites');
    }
    public function toggleFavorite($recipeId)
    {
        $user = Auth::user();
        $recipe = Recipe::findOrFail($recipeId);

        if ($user->favorites()->where('recipe_id', $recipeId)->exists()) {
            $user->favorites()->detach($recipeId);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorites()->attach($recipeId);
            return response()->json(['status' => 'added']);
        }
    }
}
