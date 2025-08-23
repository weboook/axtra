<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            [
                'name' => 'Bachelor & Bachelorette Party',
                'slug' => 'bachelor-bachelorette-party',
                'description' => 'Celebrate your last days of freedom with an unforgettable axe throwing experience',
                'icon' => 'fas fa-rings-wedding',
                'color' => '#e91e63',
                'sort_order' => 1,
            ],
            [
                'name' => 'Birthday Party',
                'slug' => 'birthday-party',
                'description' => 'Make your birthday memorable with axes and friends',
                'icon' => 'fas fa-birthday-cake',
                'color' => '#ff9800',
                'sort_order' => 2,
            ],
            [
                'name' => 'Corporate Team Building',
                'slug' => 'corporate-team-building',
                'description' => 'Build stronger teams through shared challenges and victories',
                'icon' => 'fas fa-users',
                'color' => '#2196f3',
                'sort_order' => 3,
            ],
            [
                'name' => 'Date Night',
                'slug' => 'date-night',
                'description' => 'Unique date experience that breaks the ice and creates memories',
                'icon' => 'fas fa-heart',
                'color' => '#f44336',
                'sort_order' => 4,
            ],
            [
                'name' => 'Divorce Party',
                'slug' => 'divorce-party',
                'description' => 'Celebrate your newfound freedom with therapeutic axe throwing',
                'icon' => 'fas fa-glass-cheers',
                'color' => '#9c27b0',
                'sort_order' => 5,
            ],
            [
                'name' => 'Friends Night Out',
                'slug' => 'friends-night-out',
                'description' => 'Perfect activity for your crew to bond and have fun',
                'icon' => 'fas fa-user-friends',
                'color' => '#4caf50',
                'sort_order' => 6,
            ],
            [
                'name' => 'Group Activities',
                'slug' => 'group-activities',
                'description' => 'Fun group activity for any occasion',
                'icon' => 'fas fa-users-cog',
                'color' => '#607d8b',
                'sort_order' => 7,
            ],
            [
                'name' => 'Team Event',
                'slug' => 'team-event',
                'description' => 'Perfect for sports teams, work groups, or club activities',
                'icon' => 'fas fa-trophy',
                'color' => '#ff5722',
                'sort_order' => 8,
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'description' => 'Tell us about your special event',
                'icon' => 'fas fa-plus-circle',
                'color' => '#795548',
                'allows_custom_input' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($eventTypes as $eventType) {
            \App\Models\EventType::updateOrCreate(
                ['slug' => $eventType['slug']],
                $eventType
            );
        }
    }
}
