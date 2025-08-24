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
            $table->boolean('is_banned')->default(false)->after('whatsapp_notifications');
            $table->text('ban_reason')->nullable()->after('is_banned');
            $table->timestamp('banned_at')->nullable()->after('ban_reason');
            $table->unsignedBigInteger('banned_by')->nullable()->after('banned_at');
            $table->boolean('hidden_from_leaderboard')->default(false)->after('banned_by');
            $table->timestamp('last_activity')->nullable()->after('hidden_from_leaderboard');
            $table->text('admin_notes')->nullable()->after('last_activity');
            
            $table->foreign('banned_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['banned_by']);
            $table->dropColumn([
                'is_banned', 
                'ban_reason', 
                'banned_at', 
                'banned_by', 
                'hidden_from_leaderboard',
                'last_activity',
                'admin_notes'
            ]);
        });
    }
};
