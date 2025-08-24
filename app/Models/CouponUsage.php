<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $fillable = [
        'coupon_id',
        'user_id',
        'booking_id',
        'order_id',
        'discount_amount',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'discount_amount' => 'decimal:2',
            'used_at' => 'datetime',
        ];
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('used_at', '>=', now()->subDays($days));
    }

    public function scopeByCoupon($query, $couponId)
    {
        return $query->where('coupon_id', $couponId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
