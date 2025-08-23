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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('purchased_by')->constrained('users')->onDelete('cascade');
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email')->nullable();
            $table->decimal('original_amount', 8, 2);
            $table->decimal('remaining_amount', 8, 2);
            $table->text('message')->nullable();
            $table->datetime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->datetime('redeemed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
