<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_id',
        'progress',
        'completed_at',
        'current_value'
    ];

    protected $casts = [
        'progress' => 'array',
        'completed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }

    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    public function getProgressPercentage(): int
    {
        if ($this->isCompleted()) {
            return 100;
        }

        $requirements = $this->achievement->requirements ?? [];
        $target = $requirements['target'] ?? 1;
        
        return min(100, intval(($this->current_value / $target) * 100));
    }
}
