<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'review',
        'count_review',
        'penyakit',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function nutritionFacts()
    {
        return $this->hasOne(NutritionFact::class);
    }
}

