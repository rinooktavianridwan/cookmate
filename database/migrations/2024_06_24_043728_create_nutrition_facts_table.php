<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nutrition_facts', function (Blueprint $table) {
            $table->id();
            $table->integer('calories');
            $table->integer('protein');
            $table->integer('fat');
            $table->integer('carbohydrates')->default(0); // Menambahkan kolom carbohydrates dengan default value
            $table->integer('sugar')->default(0); // Menambahkan kolom sugar dengan default value
            $table->integer('sodium')->default(0); // Menambahkan kolom sodium dengan default value
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade'); // Menambahkan onDelete cascade untuk memastikan integritas data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_facts');
    }
};
