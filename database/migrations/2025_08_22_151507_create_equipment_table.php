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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // 'axe', 'safety_gear', 'target', etc.
            $table->integer('quantity_available');
            $table->integer('quantity_in_use')->default(0);
            $table->enum('status', ['available', 'in_use', 'maintenance', 'retired'])->default('available');
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
