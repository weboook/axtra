<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'quantity_available',
        'quantity_in_use',
        'status',
        'last_maintenance',
        'next_maintenance',
        'specifications',
    ];

    protected function casts(): array
    {
        return [
            'last_maintenance' => 'date',
            'next_maintenance' => 'date',
            'specifications' => 'array',
        ];
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                    ->where('quantity_available', '>', 0);
    }

    public function scopeNeedsMaintenance($query)
    {
        return $query->where('next_maintenance', '<=', now());
    }

    public function isAvailable()
    {
        return $this->status === 'available' && 
               $this->quantity_available > 0;
    }
}
