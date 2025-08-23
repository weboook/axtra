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
        Schema::create('skill_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Beginner, Intermediate, Advanced, Expert, Master
            $table->integer('min_points'); // Minimum points required
            $table->integer('max_points')->nullable(); // Maximum points for this level
            $table->string('color')->default('#6c757d'); // Level color
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->text('description')->nullable(); // Level description
            $table->json('perks')->nullable(); // JSON array of perks for this level
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_levels');
    }
};