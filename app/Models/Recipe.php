<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'bahan_dasar',
        'image',
        'review',
        'count_review',
        'penyakit',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function countReviews()
    {
        return $this->reviews()->count();
    }
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'fav_recipe');
    }

    public function isFavoritedByUser($user)
    {
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }
}
