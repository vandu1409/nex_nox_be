<?php
namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\BookingType;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_type',
        'start_time',
        'end_time',
        'guest_adults',
        'guest_children',
        'status',
        'total_price',
        'deposit',
        'special_requests',
        'user_profile_id',
        'product_id',
    ];

    protected $casts = [
        'booking_type' => BookingType::class,
        'status' => BookingStatus::class,
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_price' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'booking_voucher');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

}
