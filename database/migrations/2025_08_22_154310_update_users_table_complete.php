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
            if (!Schema::hasColumn('users', 'total_spent')) {
                $table->decimal('total_spent', 10, 2)->default(0.00)->after('total_bookings');
            }
            if (!Schema::hasColumn('users', 'skill_points')) {
                $table->integer('skill_points')->default(0)->after('skill_level');
            }
            if (!Schema::hasColumn('users', 'whatsapp_notifications')) {
                $table->boolean('whatsapp_notifications')->default(true)->after('skill_points');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_spent', 'skill_level', 'skill_points', 'whatsapp_notifications']);
        });
    }
};
