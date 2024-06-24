<?php
namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the recipes.
     */
    public function index(Request $request)
    {
        // Mengambil daftar unik penyakit dari resep
        $penyakitList = Recipe::select('penyakit')->distinct()->get();

        // Filter resep berdasarkan penyakit jika ada parameter penyakit
        $query = Recipe::with('ingredients', 'nutritionFacts', 'reviews');
        if ($request->has('penyakit') && $request->penyakit != '') {
            $query->where('penyakit', $request->penyakit);
        }
        $recipes = $query->get();

        return view('recipes.index', compact('penyakitList', 'recipes'));
    }
}
