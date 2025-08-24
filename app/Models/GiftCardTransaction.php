<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCardTransaction extends Model
{
    protected $fillable = [
        'gift_card_id',
        'booking_id',
        'user_id',
        'transaction_type',
        'amount',
        'description',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'datetime',
        ];
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('transaction_date', '>=', now()->subDays($days));
    }

    public function getTypeDisplayAttribute()
    {
        return match($this->transaction_type) {
            'purchase' => 'Purchase',
            'redemption' => 'Redemption',
            'refund' => 'Refund',
            'expiry' => 'Expiry',
            default => ucfirst($this->transaction_type)
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->transaction_type) {
            'purchase' => 'success',
            'redemption' => 'info',
            'refund' => 'warning',
            'expiry' => 'secondary',
            default => 'primary'
        };
    }
}
