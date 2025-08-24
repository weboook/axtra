<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lane;

class LanesSeeder extends Seeder
{
    public function run(): void
    {
        $lanes = [
            [
                'name' => 'Lane 1',
                'description' => 'Standard competition lane with electronic scoring',
                'capacity' => 6,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(15),
            ],
            [
                'name' => 'Lane 2', 
                'description' => 'Premium lane with upgraded lighting system',
                'capacity' => 6,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(8),
            ],
            [
                'name' => 'Lane 3',
                'description' => 'Standard lane with manual scoring backup',
                'capacity' => 6,
                'maintenance_status' => 'maintenance',
                'last_maintenance' => now()->subDays(2),
            ],
            [
                'name' => 'Lane 4',
                'description' => 'Competition-grade lane with professional targets',
                'capacity' => 8,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(12),
            ],
            [
                'name' => 'Lane 5',
                'description' => 'Training lane for beginners and instruction',
                'capacity' => 4,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(20),
            ],
            [
                'name' => 'Lane 6',
                'description' => 'Standard lane with recently upgraded block system',
                'capacity' => 6,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(5),
            ],
            [
                'name' => 'Lane 7',
                'description' => 'Premium lane with advanced safety features',
                'capacity' => 6,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(18),
            ],
            [
                'name' => 'Lane 8',
                'description' => 'Competition lane requiring axe maintenance',
                'capacity' => 6,
                'maintenance_status' => 'damaged',
                'last_maintenance' => now()->subDays(30),
            ],
            [
                'name' => 'Lane 9',
                'description' => 'Training lane with reinforced backstop',
                'capacity' => 5,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(10),
            ],
            [
                'name' => 'Lane 10',
                'description' => 'Championship lane with premium wood blocks',
                'capacity' => 8,
                'maintenance_status' => 'operational',
                'last_maintenance' => now()->subDays(7),
            ],
        ];

        foreach ($lanes as $lane) {
            Lane::create($lane);
        }
    }
}