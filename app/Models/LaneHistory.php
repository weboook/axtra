<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaneHistory extends Model
{
    protected $table = 'lane_history';

    protected $fillable = [
        'lane_id',
        'event_type',
        'title',
        'description',
        'metadata',
        'cost',
        'performed_by',
        'occurred_at',
        'severity',
        'before_photos',
        'after_photos',
        'downtime_minutes',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'before_photos' => 'array',
            'after_photos' => 'array',
            'occurred_at' => 'datetime',
            'cost' => 'decimal:2',
        ];
    }

    public function lane()
    {
        return $this->belongsTo(Lane::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function scopeAxeBreaks($query)
    {
        return $query->where('event_type', 'axe_break');
    }

    public function scopeBlockReplacements($query)
    {
        return $query->where('event_type', 'block_replacement');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('event_type', 'maintenance');
    }

    public function scopeRecentEvents($query, $days = 30)
    {
        return $query->where('occurred_at', '>=', now()->subDays($days));
    }

    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    public function getEventTypeDisplayAttribute()
    {
        return match($this->event_type) {
            'axe_break' => 'Axe Break',
            'block_replacement' => 'Block Replacement',
            'maintenance' => 'Maintenance',
            'damage_report' => 'Damage Report',
            'repair' => 'Repair',
            default => ucfirst(str_replace('_', ' ', $this->event_type))
        };
    }

    public function getEventTypeIconAttribute()
    {
        return match($this->event_type) {
            'axe_break' => 'fas fa-hammer',
            'block_replacement' => 'fas fa-cube',
            'maintenance' => 'fas fa-tools',
            'damage_report' => 'fas fa-exclamation-triangle',
            'repair' => 'fas fa-wrench',
            default => 'fas fa-info-circle'
        };
    }

    public function getEventTypeColorAttribute()
    {
        return match($this->event_type) {
            'axe_break' => 'danger',
            'block_replacement' => 'warning',
            'maintenance' => 'info',
            'damage_report' => 'danger',
            'repair' => 'success',
            default => 'secondary'
        };
    }

    public function getSeverityColorAttribute()
    {
        return match($this->severity) {
            'minor' => 'success',
            'major' => 'warning',
            'critical' => 'danger',
            default => 'secondary'
        };
    }

    public function getDowntimeFormattedAttribute()
    {
        if ($this->downtime_minutes < 60) {
            return $this->downtime_minutes . ' min';
        }
        
        $hours = floor($this->downtime_minutes / 60);
        $minutes = $this->downtime_minutes % 60;
        
        return $hours . 'h' . ($minutes > 0 ? ' ' . $minutes . 'min' : '');
    }
}
