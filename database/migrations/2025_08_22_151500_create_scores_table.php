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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            $table->integer('throw_1')->nullable();
            $table->integer('throw_2')->nullable();
            $table->integer('throw_3')->nullable();
            $table->integer('round_total')->nullable();
            $table->integer('running_total')->nullable();
            $table->json('throw_details')->nullable();
            $table->timestamps();
            
            $table->index(['booking_id', 'user_id', 'round_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
