<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'requirements',
        'points_reward',
        'icon',
        'color',
        'order',
        'is_hidden',
        'is_active'
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_hidden' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
}
