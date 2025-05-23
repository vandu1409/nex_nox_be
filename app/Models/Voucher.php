<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'discount_percent',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_voucher');
    }
}

