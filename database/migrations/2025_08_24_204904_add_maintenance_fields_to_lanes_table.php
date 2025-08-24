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
        Schema::table('lanes', function (Blueprint $table) {
            if (!Schema::hasColumn('lanes', 'maintenance_status')) {
                $table->enum('maintenance_status', ['operational', 'maintenance', 'damaged'])->default('operational')->after('is_active');
            }
            if (!Schema::hasColumn('lanes', 'last_maintenance')) {
                $table->date('last_maintenance')->nullable()->after('maintenance_status');
            }
            if (!Schema::hasColumn('lanes', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('lanes', 'capacity')) {
                $table->integer('capacity')->default(2)->after('description');
            }
            if (!Schema::hasColumn('lanes', 'hourly_rate')) {
                $table->decimal('hourly_rate', 8, 2)->default(0)->after('capacity');
            }
            if (!Schema::hasColumn('lanes', 'equipment_included')) {
                $table->json('equipment_included')->nullable()->after('hourly_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lanes', function (Blueprint $table) {
            $table->dropColumn([
                'maintenance_status',
                'last_maintenance', 
                'description',
                'capacity',
                'hourly_rate',
                'equipment_included'
            ]);
        });
    }
};
