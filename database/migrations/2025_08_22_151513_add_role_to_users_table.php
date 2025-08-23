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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'employee', 'customer'])->default('customer');
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->json('preferences')->nullable();
            $table->integer('total_bookings')->default(0);
            $table->integer('total_score')->default(0);
            $table->integer('best_score')->nullable();
            $table->string('skill_level')->default('beginner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'date_of_birth', 'preferences', 'total_bookings', 'total_score', 'best_score', 'skill_level']);
        });
    }
};
