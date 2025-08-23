<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillLevel extends Model
{
    protected $fillable = [
        'name',
        'min_points',
        'max_points',
        'color',
        'icon',
        'description',
        'perks',
        'order',
        'is_active'
    ];

    protected $casts = [
        'perks' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('min_points');
    }

    public static function getLevelForPoints(int $points): ?SkillLevel
    {
        return static::active()
            ->where('min_points', '<=', $points)
            ->where(function($query) use ($points) {
                $query->whereNull('max_points')
                      ->orWhere('max_points', '>=', $points);
            })
            ->ordered()
            ->first();
    }

    public function getProgressToNextLevel(int $currentPoints): array
    {
        $nextLevel = static::active()
            ->where('min_points', '>', $this->min_points)
            ->ordered()
            ->first();

        if (!$nextLevel) {
            return [
                'next_level' => null,
                'points_needed' => 0,
                'progress_percentage' => 100
            ];
        }

        $pointsInCurrentLevel = $currentPoints - $this->min_points;
        $pointsNeededForNext = $nextLevel->min_points - $this->min_points;
        $progressPercentage = ($pointsInCurrentLevel / $pointsNeededForNext) * 100;

        return [
            'next_level' => $nextLevel,
            'points_needed' => $nextLevel->min_points - $currentPoints,
            'progress_percentage' => min(100, max(0, $progressPercentage))
        ];
    }
}
