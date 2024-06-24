<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('review')->default(0); // Mengganti tipe data dari int ke integer dan menambahkan default value
            $table->integer('count_review')->default(0); // Mengganti tipe data dari int ke integer dan menambahkan default value
            $table->string('penyakit')->nullable(); // Menambahkan nullable jika tidak wajib
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
