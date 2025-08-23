<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkillLevel;

class SkillLevelsSeeder extends Seeder
{
    public function run(): void
    {
        $skillLevels = [
            [
                'name' => 'Novice',
                'min_points' => 0,
                'max_points' => 99,
                'color' => '#6c757d',
                'icon' => 'fa-user',
                'description' => 'Just getting started with bowling. Everyone begins here!',
                'perks' => ['Welcome bonus'],
                'order' => 1,
            ],
            [
                'name' => 'Beginner',
                'min_points' => 100,
                'max_points' => 299,
                'color' => '#28a745',
                'icon' => 'fa-bowling-ball',
                'description' => 'Learning the basics and building consistency.',
                'perks' => ['5% booking discount', 'Basic stats tracking'],
                'order' => 2,
            ],
            [
                'name' => 'Intermediate',
                'min_points' => 300,
                'max_points' => 599,
                'color' => '#007bff',
                'icon' => 'fa-target',
                'description' => 'Developing technique and strategy.',
                'perks' => ['10% booking discount', 'Advanced stats', 'Priority booking'],
                'order' => 3,
            ],
            [
                'name' => 'Advanced',
                'min_points' => 600,
                'max_points' => 999,
                'color' => '#fd7e14',
                'icon' => 'fa-fire',
                'description' => 'Skilled bowler with consistent performance.',
                'perks' => ['15% booking discount', 'Custom lane preferences', 'Achievement bonuses'],
                'order' => 4,
            ],
            [
                'name' => 'Expert',
                'min_points' => 1000,
                'max_points' => 1999,
                'color' => '#e83e8c',
                'icon' => 'fa-crown',
                'description' => 'Mastery of the sport with exceptional skill.',
                'perks' => ['20% booking discount', 'VIP support', 'Special events access'],
                'order' => 5,
            ],
            [
                'name' => 'Master',
                'min_points' => 2000,
                'max_points' => null,
                'color' => '#6f42c1',
                'icon' => 'fa-trophy',
                'description' => 'The pinnacle of bowling excellence.',
                'perks' => ['25% booking discount', 'Personal coaching', 'Tournament priority', 'Hall of Fame'],
                'order' => 6,
            ],
        ];

        foreach ($skillLevels as $level) {
            SkillLevel::create($level);
        }
    }
}