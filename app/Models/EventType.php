<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'allows_custom_input',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'allows_custom_input' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($eventType) {
            if (!$eventType->slug) {
                $eventType->slug = Str::slug($eventType->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
