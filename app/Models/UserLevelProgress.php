<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLevelProgress extends Model
{
    protected $table = 'user_level_progress';
    
    protected $fillable = [
        'user_id',
        'level_id',
        'current_points',
        'achieved_at',
        'is_current_level',
        'achievements_unlocked',
    ];

    protected function casts(): array
    {
        return [
            'achieved_at' => 'datetime',
            'is_current_level' => 'boolean',
            'achievements_unlocked' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current_level', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
