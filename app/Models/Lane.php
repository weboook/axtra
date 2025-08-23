<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lane extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'equipment_included',
        'capacity',
        'hourly_rate',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'equipment_included' => 'array',
            'hourly_rate' => 'decimal:2',
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
}
