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
        $uniqueBahan = Recipe::select('bahan_dasar')->distinct()->get();
        $uniquePenyakit = Recipe::select('penyakit')->distinct()->get();

        return response()->json([
            'bahan' => $uniqueBahan,
            'penyakit' => $uniquePenyakit,
        ]);
    }

    public function show($id)
    {
        $recipe = Recipe::with(['ingredients', 'instructions'])->findOrFail($id);
        return view('userpage.description', compact('recipe'));
    }
}
