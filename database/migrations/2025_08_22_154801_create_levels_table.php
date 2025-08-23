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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond'
            $table->string('slug')->unique(); // e.g., 'bronze', 'silver', 'gold'
            $table->text('description')->nullable();
            $table->integer('points_required'); // Points needed to reach this level
            $table->integer('sort_order')->default(0); // For ordering levels
            $table->string('color')->default('#6B7280'); // Hex color for UI
            $table->string('icon')->nullable(); // Icon name or path
            $table->json('benefits')->nullable(); // JSON array of benefits
            $table->json('achievements')->nullable(); // JSON array of achievements unlocked
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['sort_order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
