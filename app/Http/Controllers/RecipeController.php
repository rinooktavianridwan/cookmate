<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all(); // Ambil semua data resep dari database

        return view('dashboard', compact('recipes'));
    }

    public function search(Request $request)
    {
        $query = $request->query('query'); // Ambil kata kunci pencarian dari request
        $recipes = Recipe::where('title', 'like', "%$query%")->get(); // Query pencarian data resep

        return response()->json($recipes); // Kirim response JSON berisi data resep
    }
}


