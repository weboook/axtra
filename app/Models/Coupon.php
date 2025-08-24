<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'valid_from',
        'valid_until',
        'applicable_services',
        'applicable_products',
        'is_active',
        'is_stackable',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'minimum_amount' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
            'applicable_services' => 'array',
            'applicable_products' => 'array',
            'is_active' => 'boolean',
            'is_stackable' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($coupon) {
            if (!$coupon->code) {
                $coupon->code = $coupon->generateUniqueCode();
            }
            $coupon->code = strtoupper($coupon->code);
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('valid_from', '>', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function isValid($userId = null)
    {
        // Check basic validity
        if (!$this->is_active || 
            $this->valid_from > now() || 
            $this->valid_until < now()) {
            return false;
        }

        // Check global usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check per-user usage limit
        if ($userId && $this->usage_limit_per_user) {
            $userUsages = $this->usages()->where('user_id', $userId)->count();
            if ($userUsages >= $this->usage_limit_per_user) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($amount, $services = [], $products = [])
    {
        if (!$this->isValid()) {
            return 0;
        }

        // Check minimum amount requirement
        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return 0;
        }

        // Check applicable services/products
        if ($this->applicable_services && !empty($services)) {
            $hasApplicableService = !empty(array_intersect($services, $this->applicable_services));
            if (!$hasApplicableService) return 0;
        }

        if ($this->applicable_products && !empty($products)) {
            $hasApplicableProduct = !empty(array_intersect($products, $this->applicable_products));
            if (!$hasApplicableProduct) return 0;
        }

        // Calculate discount based on type
        $discount = 0;
        switch ($this->type) {
            case 'percentage':
                $discount = ($amount * $this->value) / 100;
                break;
            case 'fixed':
                $discount = $this->value;
                break;
            case 'buy_x_get_y':
                // Custom logic for BXGY offers
                $discount = $this->calculateBuyXGetYDiscount($amount, $services, $products);
                break;
        }

        // Apply maximum discount limit
        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        // Ensure discount doesn't exceed amount
        return min($discount, $amount);
    }

    private function calculateBuyXGetYDiscount($amount, $services, $products)
    {
        // Placeholder for Buy X Get Y logic
        // This would need specific implementation based on business rules
        return 0;
    }

    public function use($userId = null, $orderId = null)
    {
        if (!$this->isValid($userId)) {
            return false;
        }

        // Record usage
        $this->usages()->create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'used_at' => now(),
        ]);

        // Increment usage count
        $this->increment('used_count');

        return true;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) return 'inactive';
        if ($this->valid_from > now()) return 'upcoming';
        if ($this->valid_until < now()) return 'expired';
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return 'exhausted';
        return 'active';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'upcoming' => 'info',
            'expired' => 'secondary',
            'exhausted' => 'warning',
            'inactive' => 'danger',
            default => 'secondary'
        };
    }

    public function getTypeDisplayAttribute()
    {
        return match($this->type) {
            'percentage' => 'Percentage',
            'fixed' => 'Fixed Amount',
            'buy_x_get_y' => 'Buy X Get Y',
            default => ucfirst($this->type)
        };
    }

    public function getValueDisplayAttribute()
    {
        return match($this->type) {
            'percentage' => $this->value . '%',
            'fixed' => 'CHF ' . number_format($this->value, 2),
            'buy_x_get_y' => 'Special Offer',
            default => $this->value
        };
    }

    public function getRemainingUsesAttribute()
    {
        if (!$this->usage_limit) return 'Unlimited';
        return max(0, $this->usage_limit - $this->used_count);
    }

    public function getDaysUntilExpiryAttribute()
    {
        return $this->valid_until->diffInDays(now());
    }

    private function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('code', $code)->exists());
        
        return $code;
    }
}
