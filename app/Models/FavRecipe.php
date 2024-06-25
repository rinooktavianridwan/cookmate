<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'fav_recipe';

    protected $fillable = [
        'user_id',
        'recipe_id',
    ];
}
