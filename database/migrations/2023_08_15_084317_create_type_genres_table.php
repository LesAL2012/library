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
        Schema::create('type_genres', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->unsignedBigInteger('genre_id');
            $table->index('genre_id', 'type_genres_genre_idx');
            $table->foreign('genre_id', 'type_genres_genre_fk')->on('genres')->references('id');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_genres');
    }
};
