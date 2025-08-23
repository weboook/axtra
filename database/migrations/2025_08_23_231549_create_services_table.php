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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category'); // 'axe_throwing', 'axe_throwing_making', 'axe_making', 'private_events'
            $table->decimal('price', 10, 2);
            $table->integer('duration_hours');
            $table->integer('min_players');
            $table->integer('max_players');
            $table->json('features')->nullable(); // Additional features/requirements
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['category', 'is_active']);
            $table->index(['min_players', 'max_players']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
