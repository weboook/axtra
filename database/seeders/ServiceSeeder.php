<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing services (skip if services exist to avoid conflicts)
        if (Service::count() === 0) {

        // Axe Throwing services
        Service::create([
            'name' => 'Axe Throwing (2 Players)',
            'description' => 'Intimate axe throwing session for two players',
            'category' => 'axe_throwing',
            'price' => 90.00,
            'duration_hours' => 1,
            'min_players' => 2,
            'max_players' => 2,
            'sort_order' => 1,
        ]);

        Service::create([
            'name' => 'Axe Throwing (3-30 Players)',
            'description' => 'Group axe throwing session for 3 to 30 players',
            'category' => 'axe_throwing',
            'price' => 45.00,
            'duration_hours' => 1,
            'min_players' => 3,
            'max_players' => 30,
            'sort_order' => 2,
        ]);

        Service::create([
            'name' => 'Axe Throwing (25-55 Players)',
            'description' => 'Large group axe throwing session for 25 to 55 players',
            'category' => 'axe_throwing',
            'price' => 45.00,
            'duration_hours' => 2,
            'min_players' => 25,
            'max_players' => 55,
            'sort_order' => 3,
        ]);

        // Axe Throwing and Making services
        Service::create([
            'name' => 'Axe Craft with Throwing',
            'description' => 'Craft your own axe and learn to throw it',
            'category' => 'axe_throwing_making',
            'price' => 145.00,
            'duration_hours' => 3,
            'min_players' => 2,
            'max_players' => 20,
            'sort_order' => 4,
        ]);

        Service::create([
            'name' => 'Axe Craft with Throwing and Sheath',
            'description' => 'Craft your own axe with custom sheath and learn to throw it',
            'category' => 'axe_throwing_making',
            'price' => 205.00,
            'duration_hours' => 4,
            'min_players' => 5,
            'max_players' => 20,
            'sort_order' => 5,
        ]);

        // Axe Making services
        Service::create([
            'name' => 'Axe Making',
            'description' => 'Craft and forge your own custom axe',
            'category' => 'axe_making',
            'price' => 100.00,
            'duration_hours' => 2,
            'min_players' => 2,
            'max_players' => 30,
            'sort_order' => 6,
        ]);

        Service::create([
            'name' => 'Axe Making with Sheath',
            'description' => 'Craft your own axe with custom leather sheath',
            'category' => 'axe_making',
            'price' => 150.00,
            'duration_hours' => 3,
            'min_players' => 2,
            'max_players' => 30,
            'sort_order' => 7,
        ]);

        // Private Events and Offsites
        Service::create([
            'name' => 'The Throwdown',
            'description' => 'Premium private axe throwing event experience',
            'category' => 'private_events',
            'price' => 1500.00,
            'duration_hours' => 1,
            'min_players' => 10,
            'max_players' => 30,
            'features' => ['Private venue', 'Professional instructor', 'All equipment included'],
            'sort_order' => 8,
        ]);

        Service::create([
            'name' => 'The Timberwolf',
            'description' => 'Extended premium private event with enhanced activities',
            'category' => 'private_events',
            'price' => 2000.00,
            'duration_hours' => 2,
            'min_players' => 25,
            'max_players' => 55,
            'features' => ['Private venue', 'Multiple activities', 'Refreshments included'],
            'sort_order' => 9,
        ]);

        Service::create([
            'name' => 'The Axeclusive',
            'description' => 'Ultimate exclusive private axe experience',
            'category' => 'private_events',
            'price' => 3200.00,
            'duration_hours' => 3,
            'min_players' => 20,
            'max_players' => 55,
            'features' => ['Exclusive venue access', 'Premium activities', 'Full catering', 'Personal event coordinator'],
            'sort_order' => 10,
        ]);
        
        } // End if check
    }
}
