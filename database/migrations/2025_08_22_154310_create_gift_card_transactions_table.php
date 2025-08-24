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
        Schema::create('gift_card_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_card_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_type'); // purchase, redemption, refund, expiry
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();
            
            $table->index(['gift_card_id', 'transaction_date']);
            $table->index(['transaction_type', 'transaction_date']);
            $table->index(['user_id', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_transactions');
    }
};
