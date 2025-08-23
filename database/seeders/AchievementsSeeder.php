<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementsSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Score-based achievements
            [
                'name' => 'First Strike',
                'description' => 'Achieve your first strike!',
                'type' => 'score',
                'requirements' => ['target' => 1, 'type' => 'strikes'],
                'points_reward' => 25,
                'icon' => 'fa-bowling-ball',
                'color' => '#28a745',
                'order' => 1,
            ],
            [
                'name' => 'Strike Master',
                'description' => 'Bowl 10 strikes in total',
                'type' => 'score',
                'requirements' => ['target' => 10, 'type' => 'strikes'],
                'points_reward' => 100,
                'icon' => 'fa-fire',
                'color' => '#fd7e14',
                'order' => 2,
            ],
            [
                'name' => 'Century Club',
                'description' => 'Score 100 or higher in a single game',
                'type' => 'score',
                'requirements' => ['target' => 100, 'type' => 'single_game_score'],
                'points_reward' => 50,
                'icon' => 'fa-trophy',
                'color' => '#007bff',
                'order' => 3,
            ],
            [
                'name' => 'Perfect Game',
                'description' => 'Bowl a perfect 300 game',
                'type' => 'score',
                'requirements' => ['target' => 300, 'type' => 'single_game_score'],
                'points_reward' => 500,
                'icon' => 'fa-crown',
                'color' => '#6f42c1',
                'order' => 4,
                'is_hidden' => false,
            ],

            // Session-based achievements
            [
                'name' => 'Welcome Bowler',
                'description' => 'Complete your first bowling session',
                'type' => 'session',
                'requirements' => ['target' => 1, 'type' => 'sessions_completed'],
                'points_reward' => 20,
                'icon' => 'fa-handshake',
                'color' => '#17a2b8',
                'order' => 5,
            ],
            [
                'name' => 'Regular Player',
                'description' => 'Complete 10 bowling sessions',
                'type' => 'session',
                'requirements' => ['target' => 10, 'type' => 'sessions_completed'],
                'points_reward' => 75,
                'icon' => 'fa-calendar-check',
                'color' => '#28a745',
                'order' => 6,
            ],
            [
                'name' => 'Dedicated Bowler',
                'description' => 'Complete 50 bowling sessions',
                'type' => 'session',
                'requirements' => ['target' => 50, 'type' => 'sessions_completed'],
                'points_reward' => 200,
                'icon' => 'fa-medal',
                'color' => '#e83e8c',
                'order' => 7,
            ],

            // Streak achievements
            [
                'name' => 'On Fire',
                'description' => 'Bowl 3 strikes in a row',
                'type' => 'streak',
                'requirements' => ['target' => 3, 'type' => 'consecutive_strikes'],
                'points_reward' => 75,
                'icon' => 'fa-fire-flame-curved',
                'color' => '#ff6b35',
                'order' => 8,
            ],
            [
                'name' => 'Consistency King',
                'description' => 'Bowl 5 spares in a row',
                'type' => 'streak',
                'requirements' => ['target' => 5, 'type' => 'consecutive_spares'],
                'points_reward' => 60,
                'icon' => 'fa-bullseye',
                'color' => '#20c997',
                'order' => 9,
            ],

            // Accuracy achievements
            [
                'name' => 'Sharp Shooter',
                'description' => 'Achieve 80% strike rate in a single game',
                'type' => 'accuracy',
                'requirements' => ['target' => 80, 'type' => 'strike_percentage'],
                'points_reward' => 100,
                'icon' => 'fa-crosshairs',
                'color' => '#dc3545',
                'order' => 10,
            ],
            [
                'name' => 'Spare Champion',
                'description' => 'Convert 90% of spare opportunities in a game',
                'type' => 'accuracy',
                'requirements' => ['target' => 90, 'type' => 'spare_conversion'],
                'points_reward' => 80,
                'icon' => 'fa-target',
                'color' => '#6610f2',
                'order' => 11,
            ],

            // Special achievements
            [
                'name' => 'Early Bird',
                'description' => 'Book a session before 10 AM',
                'type' => 'special',
                'requirements' => ['target' => 1, 'type' => 'early_booking'],
                'points_reward' => 30,
                'icon' => 'fa-sun',
                'color' => '#ffc107',
                'order' => 12,
            ],
            [
                'name' => 'Night Owl',
                'description' => 'Book a session after 8 PM',
                'type' => 'special',
                'requirements' => ['target' => 1, 'type' => 'late_booking'],
                'points_reward' => 30,
                'icon' => 'fa-moon',
                'color' => '#495057',
                'order' => 13,
            ],
            [
                'name' => 'Loyal Customer',
                'description' => 'Book sessions for 5 consecutive weeks',
                'type' => 'special',
                'requirements' => ['target' => 5, 'type' => 'consecutive_weeks'],
                'points_reward' => 150,
                'icon' => 'fa-heart',
                'color' => '#e91e63',
                'order' => 14,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}