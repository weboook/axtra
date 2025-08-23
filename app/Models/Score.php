<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'round_number',
        'throw_1',
        'throw_2',
        'throw_3',
        'round_total',
        'running_total',
        'throw_details',
    ];

    protected function casts(): array
    {
        return [
            'throw_details' => 'array',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateRoundTotal()
    {
        return ($this->throw_1 ?? 0) + ($this->throw_2 ?? 0) + ($this->throw_3 ?? 0);
    }
}
