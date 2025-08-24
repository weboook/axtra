<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $fillable = [
        'code',
        'purchased_by',
        'recipient_name',
        'recipient_email',
        'original_amount',
        'remaining_amount',
        'message',
        'valid_until',
        'is_active',
        'redeemed_at',
    ];

    protected function casts(): array
    {
        return [
            'original_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
            'valid_until' => 'datetime',
            'is_active' => 'boolean',
            'redeemed_at' => 'datetime',
        ];
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function transactions()
    {
        return $this->hasMany(GiftCardTransaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('valid_until', '>=', now())
                    ->where('remaining_amount', '>', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeFullyRedeemed($query)
    {
        return $query->where('remaining_amount', '<=', 0);
    }

    public function isValid()
    {
        return $this->is_active && 
               $this->valid_until >= now() &&
               $this->remaining_amount > 0;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) return 'inactive';
        if ($this->valid_until < now()) return 'expired';
        if ($this->remaining_amount <= 0) return 'fully_redeemed';
        if ($this->remaining_amount < $this->original_amount) return 'partially_used';
        return 'active';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'partially_used' => 'info', 
            'fully_redeemed' => 'warning',
            'expired' => 'secondary',
            'inactive' => 'danger',
            default => 'secondary'
        };
    }

    public function getUsagePercentageAttribute()
    {
        if ($this->original_amount <= 0) return 0;
        return (($this->original_amount - $this->remaining_amount) / $this->original_amount) * 100;
    }

    public function getDaysUntilExpiryAttribute()
    {
        return max(0, $this->valid_until->diffInDays(now()));
    }
}
