<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'product_id', // Optional - used for product-based bookings
        'service_id', // Primary - used for service-based bookings
        'lane_id',
        'coupon_id',
        'gift_card_id',
        'booking_date',
        'start_time',
        'end_time',
        'participants',
        'total_price',
        'discount_amount',
        'status',
        'notes',
        'participant_details',
        'equipment_needed',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'datetime',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'total_price' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'equipment_needed' => 'boolean',
            'participant_details' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (!$booking->booking_date) {
                $booking->booking_date = now();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function lane()
    {
        return $this->belongsTo(Lane::class);
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class);
    }

    public function participants()
    {
        return $this->hasMany(BookingParticipant::class);
    }

    public function upsells()
    {
        return $this->hasMany(BookingUpsell::class);
    }

    public function gameSession()
    {
        return $this->hasOne(GameSession::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function getTotalWithUpsellsAttribute()
    {
        return $this->total_price + $this->upsells->sum('total_price');
    }

    public function calculateSubtotal()
    {
        $serviceTotal = $this->service ? $this->service->getTotalPriceForPlayers($this->participants) : 0;
        $upsellsTotal = $this->upsells->sum('total_price');
        return $serviceTotal + $upsellsTotal;
    }

    public function applyDiscount($coupon)
    {
        if (!$coupon || !$coupon->isValid()) {
            return;
        }

        $subtotal = $this->calculateSubtotal();
        
        if ($coupon->type === 'percentage') {
            $this->discount_amount = ($subtotal * $coupon->value) / 100;
        } else {
            $this->discount_amount = min($coupon->value, $subtotal);
        }

        $this->total_price = $subtotal - $this->discount_amount;
        $this->coupon_id = $coupon->id;
    }

    public function getBookingReferenceAttribute()
    {
        return 'AXT-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
