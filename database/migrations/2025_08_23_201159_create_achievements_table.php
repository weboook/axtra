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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('type'); // score, session, streak, accuracy, special
            $table->json('requirements'); // Flexible JSON requirements
            $table->integer('points_reward'); // Skill points awarded
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->string('color')->default('#6c757d'); // Badge color
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_hidden')->default(false); // Hidden achievements
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};