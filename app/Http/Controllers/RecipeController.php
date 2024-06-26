<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::query();

        if ($request->has('penyakit') && $request->penyakit != '') {
            $query->where('penyakit', $request->penyakit);
        }

        if ($request->has('bahan') && $request->bahan != '') {
            $query->where('bahan_dasar', $request->bahan);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $recipes = $query->get();
        return response()->json($recipes);
    }

    public function getUniqueValues()
    {
        $uniqueBahan = Recipe::select('bahan_dasar')
            ->distinct()
            ->whereNotNull('bahan_dasar')
            ->where('bahan_dasar', '!=', '')
            ->get();

        $uniquePenyakit = Recipe::select('penyakit')
            ->distinct()
            ->whereNotNull('penyakit')
            ->where('penyakit', '!=', '')
            ->get();

        return response()->json([
            'bahan' => $uniqueBahan,
            'penyakit' => $uniquePenyakit,
        ]);
    }

    public function show($id)
    {
        $recipe = Recipe::with(['ingredients', 'instructions', 'nutritionFact'])->findOrFail($id);
        $userRating = auth()->user()->reviews()->where('recipe_id', $id)->value('rating');
        $recipeImageMap = [
            '1' => 'ayam-betutu.jpg',
            '2' => 'cah-sawi-hijau.jpeg',
            // Tambahkan lebih banyak pemetaan sesuai kebutuhan
        ];
        $image = $recipeImageMap[$id] ?? 'default.jpg'; // Gunakan 'default.jpg' jika ID tidak ditemukan
        return view('userpage.description', compact('recipe', 'image'));
    }

    public function letscook($id)
    {
        $recipe = Recipe::with('instructions')->findOrFail($id);
        return view('userpage.letscook', compact('recipe'));
    }
}
