<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('language');
            $table->string('country');
            $table->string('poster');
            $table->string('url')->nullable();
            $table->string('status')->nullable();

            $table->string('imdb_rating')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('imdb_votes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
