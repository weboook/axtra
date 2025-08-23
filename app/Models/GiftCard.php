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

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('valid_until', '>=', now())
                    ->where('remaining_amount', '>', 0);
    }

    public function isValid()
    {
        return $this->is_active && 
               $this->valid_until >= now() &&
               $this->remaining_amount > 0;
    }
}
