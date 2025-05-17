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
        Schema::create('colleges', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
                $table->timestamps();

                // Add unique constraint for college name within the same university
                $table->unique(['name', 'university_id']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
