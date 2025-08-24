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
        'maintenance_status',
        'last_maintenance',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'equipment_included' => 'array',
            'hourly_rate' => 'decimal:2',
            'last_maintenance' => 'date',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function history()
    {
        return $this->hasMany(LaneHistory::class)->orderBy('occurred_at', 'desc');
    }

    public function recentHistory($days = 30)
    {
        return $this->history()->where('occurred_at', '>=', now()->subDays($days));
    }

    public function axeBreaks()
    {
        return $this->history()->where('event_type', 'axe_break');
    }

    public function blockReplacements()
    {
        return $this->history()->where('event_type', 'block_replacement');
    }

    public function maintenanceRecords()
    {
        return $this->history()->where('event_type', 'maintenance');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOperational($query)
    {
        return $query->where('maintenance_status', 'operational');
    }

    public function getStatusColorAttribute()
    {
        return match($this->maintenance_status) {
            'operational' => 'success',
            'maintenance' => 'warning',
            'damaged' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->maintenance_status) {
            'operational' => 'fas fa-check-circle',
            'maintenance' => 'fas fa-tools',
            'damaged' => 'fas fa-exclamation-triangle',
            default => 'fas fa-question-circle'
        };
    }

    public function getTotalDowntimeAttribute()
    {
        return $this->history()->sum('downtime_minutes');
    }

    public function getTotalMaintenanceCostAttribute()
    {
        return $this->history()->whereNotNull('cost')->sum('cost');
    }

    public function getAxeBreakCountAttribute()
    {
        return $this->axeBreaks()->count();
    }

    public function getBlockReplacementCountAttribute()
    {
        return $this->blockReplacements()->count();
    }
}
