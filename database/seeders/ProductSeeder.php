<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Craft Beer Selection',
                'description' => 'Premium local craft beers to enjoy during your session',
                'price' => 8.50,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'drinks',
                'is_active' => true,
                'features' => ['Local brewery', 'Cold served', 'Various styles'],
            ],
            [
                'name' => 'Gourmet Pretzel Platter',
                'description' => 'Warm pretzels with artisan mustard and cheese dips',
                'price' => 12.00,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'food',
                'is_active' => true,
                'features' => ['Freshly baked', 'Multiple dips', 'Shareable'],
            ],
            [
                'name' => 'Photo Package',
                'description' => 'Professional photos of your axe throwing session',
                'price' => 25.00,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'experience',
                'is_active' => true,
                'features' => ['High-res photos', 'Digital delivery', '10+ shots'],
            ],
            [
                'name' => 'Victory Shot',
                'description' => 'Celebrate your best throws with premium spirits',
                'price' => 15.00,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'drinks',
                'is_active' => true,
                'features' => ['Premium spirits', 'Victory celebration', 'Group toast'],
            ],
            [
                'name' => 'Axe Care Kit',
                'description' => 'Take-home axe maintenance kit with oil and sharpening tools',
                'price' => 35.00,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'equipment',
                'is_active' => true,
                'features' => ['Maintenance oil', 'Sharpening stone', 'Care instructions'],
            ],
            [
                'name' => 'Group T-Shirt Package',
                'description' => 'Custom Axtra t-shirts for your group',
                'price' => 18.00,
                'duration_minutes' => 0,
                'max_participants' => 99,
                'product_type' => 'upsell',
                'category' => 'equipment',
                'is_active' => true,
                'features' => ['Custom design', 'Quality cotton', 'Size options'],
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
