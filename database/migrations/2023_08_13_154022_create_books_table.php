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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->unsignedBigInteger('writer_id');
            $table->index('writer_id', 'books_writer_idx');
            $table->foreign('writer_id', 'books_writer_fk')->on('writers')->references('id');

            $table->unsignedBigInteger('category_id');
            $table->index('category_id', 'books_category_idx');
            $table->foreign('category_id', 'books_category_fk')->on('categories')->references('id');


            $table->string('type_genre_id');
            $table->index('type_genre_id', 'books_type_genre_idx');
            $table->foreign('type_genre_id', 'books_type_genre_fk')->on('type_genres')->references('id');

            $table->string('image');
            $table->text('description');
            $table->text('description_more');
            $table->unsignedBigInteger('year');
            $table->unsignedBigInteger('amount');



            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
