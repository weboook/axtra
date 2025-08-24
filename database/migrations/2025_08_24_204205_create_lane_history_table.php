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
        Schema::create('lane_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lane_id')->constrained()->onDelete('cascade');
            $table->enum('event_type', ['axe_break', 'block_replacement', 'maintenance', 'damage_report', 'repair']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Store additional data like cost, parts used, etc.
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('performed_by')->nullable();
            $table->timestamp('occurred_at');
            $table->string('severity')->nullable(); // minor, major, critical
            $table->json('before_photos')->nullable();
            $table->json('after_photos')->nullable();
            $table->integer('downtime_minutes')->default(0);
            $table->timestamps();
            
            $table->index(['lane_id', 'event_type']);
            $table->index(['lane_id', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lane_history');
    }
};