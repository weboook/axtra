<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'max_participants',
        'is_active',
        'difficulty_level',
        'features',
        'product_type', // 'upsell', 'addon'
        'category', // 'food', 'drinks', 'equipment', 'experience'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'features' => 'array',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpsells($query)
    {
        return $query->where('product_type', 'upsell');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
