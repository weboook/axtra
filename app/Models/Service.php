<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'duration_hours',
        'min_players',
        'max_players',
        'features',
        'is_active',
        'sort_order',
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

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForPlayerCount($query, $playerCount)
    {
        return $query->where('min_players', '<=', $playerCount)
                    ->where('max_players', '>=', $playerCount);
    }

    public function canAccommodate($playerCount)
    {
        return $playerCount >= $this->min_players && $playerCount <= $this->max_players;
    }

    public function getCategoryDisplayAttribute()
    {
        return match($this->category) {
            'axe_throwing' => 'Axe Throwing',
            'axe_throwing_making' => 'Axe Throwing and Making',
            'axe_making' => 'Axe Making',
            'private_events' => 'Private Events and Offsites',
            default => $this->category,
        };
    }

    public function getTotalPriceForPlayers($playerCount)
    {
        return $this->price * $playerCount;
    }
}
