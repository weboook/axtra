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
        Schema::create('user_level_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->integer('current_points')->default(0);
            $table->datetime('achieved_at');
            $table->boolean('is_current_level')->default(false);
            $table->json('achievements_unlocked')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'level_id']);
            $table->index(['user_id', 'is_current_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_level_progress');
    }
};
