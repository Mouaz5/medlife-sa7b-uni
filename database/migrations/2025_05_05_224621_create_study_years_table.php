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
        Schema::create('study_years', function (Blueprint $table) {
            $table->id();
            $table->enum('year', ['first', 'second', 'third', 'fourth', 'fifth']);
            $table->foreignId('collage_id')->constrained('colleges')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_years');
    }
};
