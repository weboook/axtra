<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'position',
        'hire_date',
        'hourly_rate',
        'permissions',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'hourly_rate' => 'decimal:2',
            'permissions' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
