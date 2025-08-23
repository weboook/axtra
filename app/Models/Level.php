<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Level extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'points_required',
        'sort_order',
        'color',
        'icon',
        'benefits',
        'achievements',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'achievements' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_level_progress')
                    ->withPivot(['current_points', 'achieved_at', 'is_current_level', 'achievements_unlocked'])
                    ->withTimestamps();
    }

    public function userLevelProgress(): HasMany
    {
        return $this->hasMany(UserLevelProgress::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('points_required');
    }

    public function getNextLevel()
    {
        return static::where('points_required', '>', $this->points_required)
                    ->where('is_active', true)
                    ->orderBy('points_required')
                    ->first();
    }

    public function getPreviousLevel()
    {
        return static::where('points_required', '<', $this->points_required)
                    ->where('is_active', true)
                    ->orderBy('points_required', 'desc')
                    ->first();
    }

    public static function getLevelForPoints(int $points)
    {
        return static::where('points_required', '<=', $points)
                    ->where('is_active', true)
                    ->orderBy('points_required', 'desc')
                    ->first();
    }

    public function getProgressPercentage(int $currentPoints): float
    {
        $nextLevel = $this->getNextLevel();
        
        if (!$nextLevel) {
            return 100; // Max level reached
        }
        
        $pointsNeeded = $nextLevel->points_required - $this->points_required;
        $pointsEarned = $currentPoints - $this->points_required;
        
        return max(0, min(100, ($pointsEarned / $pointsNeeded) * 100));
    }
}
