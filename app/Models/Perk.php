<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    protected $fillable = [
        'name',
        'description', 
        'type',
        'effects',
        'icon',
        'color',
        'is_active'
    ];

    protected $casts = [
        'effects' => 'array',
        'is_active' => 'boolean'
    ];
}
