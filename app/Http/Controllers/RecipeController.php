<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function showDashboard()
    {
        // Mengambil semua data recipes
        $recipes = Recipe::all();

        // Ambil data unik dari kolom bahan_dasar
        $bahanDasarUnik = Recipe::select('bahan_dasar')->distinct()->get();

        // Kirim kedua data ke view
        return view('dashboard', compact('recipes', 'bahanDasarUnik'));
    }
}
