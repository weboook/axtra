<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Beginner',
                'slug' => 'beginner',
                'description' => 'Welcome to axe throwing! Start your journey here.',
                'points_required' => 0,
                'sort_order' => 0,
                'color' => '#9CA3AF',
                'icon' => 'star',
                'benefits' => [
                    'Access to beginner tutorials',
                    'Basic axe throwing tips',
                    'Safety guidelines'
                ],
                'achievements' => [
                    'First Throw',
                    'Safety Certified'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Bronze',
                'slug' => 'bronze',
                'description' => 'You\'re getting the hang of it! Keep practicing.',
                'points_required' => 100,
                'sort_order' => 1,
                'color' => '#CD7F32',
                'icon' => 'medal',
                'benefits' => [
                    '5% discount on bookings',
                    'Access to bronze member events',
                    'Progress tracking tools'
                ],
                'achievements' => [
                    'First Bullseye',
                    'Bronze Member',
                    '10 Throws Completed'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'description' => 'Impressive accuracy! You\'re becoming skilled.',
                'points_required' => 500,
                'sort_order' => 2,
                'color' => '#C0C0C0',
                'icon' => 'trophy',
                'benefits' => [
                    '10% discount on bookings',
                    'Priority booking slots',
                    'Access to intermediate techniques',
                    'Free equipment upgrades'
                ],
                'achievements' => [
                    'Silver Member',
                    'Accuracy Expert',
                    '50 Throws Completed',
                    'Team Event Participant'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'description' => 'Outstanding! You\'re among the elite throwers.',
                'points_required' => 1500,
                'sort_order' => 3,
                'color' => '#FFD700',
                'icon' => 'crown',
                'benefits' => [
                    '15% discount on bookings',
                    'VIP lane access',
                    'Advanced coaching sessions',
                    'Exclusive gold member events',
                    'Free guest passes (2 per month)'
                ],
                'achievements' => [
                    'Gold Member',
                    'Consistency Master',
                    '100 Throws Completed',
                    'Tournament Participant',
                    'Community Leader'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'description' => 'Legendary! You\'ve mastered the art of axe throwing.',
                'points_required' => 5000,
                'sort_order' => 4,
                'color' => '#E5E4E2',
                'icon' => 'diamond',
                'benefits' => [
                    '20% discount on bookings',
                    'Unlimited lane access',
                    'Personal coaching sessions',
                    'Platinum exclusive events',
                    'Free guest passes (5 per month)',
                    'Equipment customization',
                    'Competition team eligibility'
                ],
                'achievements' => [
                    'Platinum Member',
                    'Axe Throwing Legend',
                    '500 Throws Completed',
                    'Tournament Winner',
                    'Master Instructor',
                    'Hall of Fame'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Diamond',
                'slug' => 'diamond',
                'description' => 'Ultimate mastery achieved! You are a true champion.',
                'points_required' => 15000,
                'sort_order' => 5,
                'color' => '#B9F2FF',
                'icon' => 'gem',
                'benefits' => [
                    '25% discount on bookings',
                    'Lifetime VIP access',
                    'Mentorship opportunities',
                    'Diamond exclusive events',
                    'Unlimited guest passes',
                    'Custom equipment included',
                    'Competition team leadership',
                    'Brand ambassador opportunities'
                ],
                'achievements' => [
                    'Diamond Member',
                    'Ultimate Champion',
                    '1000 Throws Completed',
                    'Multiple Tournament Winner',
                    'Master Coach',
                    'Axe Throwing Ambassador',
                    'Legend Status'
                ],
                'is_active' => true,
            ]
        ];

        foreach ($levels as $levelData) {
            Level::updateOrCreate(
                ['slug' => $levelData['slug']],
                $levelData
            );
        }
    }
}
