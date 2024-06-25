<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store or update a review.
     */
    public function store(Request $request, $recipeId)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Temukan resep yang akan direview
        $recipe = Recipe::findOrFail($recipeId);
        $user = auth()->user();

        // Periksa apakah user sudah memberikan review untuk resep ini
        $review = $user->reviews()->where('recipe_id', $recipeId)->first();

        if ($review) {
            // Jika review sudah ada, perbarui ratingnya
            $review->update([
                'rating' => $request->rating,
            ]);
        } else {
            // Jika review belum ada, buat yang baru
            $review = Review::create([
                'user_id' => $user->id,
                'recipe_id' => $recipeId,
                'rating' => $request->rating,
            ]);
        }

        // Update rata-rata rating dan jumlah review di table recipes
        $recipe->review = $recipe->reviews()->avg('rating');
        $recipe->count_review = $recipe->reviews()->count();
        $recipe->save();

        return response()->json(['success' => 'Review Anda telah disimpan.']);
    }
}