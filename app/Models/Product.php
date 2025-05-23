<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'acreage',
        'child_out_of_quantity_fee',
        'child_quantity',
        'usage_quantity',
        'place_quantity',
        'product_type',
        'last_check_out_fee',
        'business_id',

    ];

    protected $with = ['images','featuredImage'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function productPrice()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function featuredImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_featured', true);
    }

}
