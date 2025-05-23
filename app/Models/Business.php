<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name', 'lat', 'long', 'is_published',
        'opening_time_from', 'opening_time_to',
        'price_from', 'price_to', 'dashboard_type', 'description',
        'country_id', 'city_id', 'district_id', 'ward_id'
    ];

    protected $appends = ['address', 'average_star', 'review_count'];
    protected $with = ['featuredImage'];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function featuredImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_featured', true);
    }


    public function getAddressAttribute()
    {
        $parts = [];

        if ($this->ward) {
            $parts[] = $this->ward->name;
        }
        if ($this->district) {
            $parts[] = $this->district->name;
        }
        if ($this->city) {
            $parts[] = $this->city->name;
        }
        if ($this->country) {
            $parts[] = $this->country->name;
        }

        return implode(', ', $parts);
    }


    public function getAverageStarAttribute()
    {
        return round($this->reviews()->avg('star'), 2) ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function scopeFilter($query,$params)
    {
     return $query
     ->when($params['type']??null,fn($query,$type)=>$query->where('dashboard_type',$type))
     ->when($params['city_id']??null,fn($query,$city_id)=>$query->where('city_id',$city_id))
     ->when($params['key_search']??null,fn($query,$key_search)=>$query->where('name','like','%'.$key_search.'%'))
     ->when(isset($params['price_from'],$params['price_to']),function ($q) use($params){
         $q->whereBetween('price','>=',$params['price_from']);
     })
      ->when($params['booking_date'] ?? null,function ($q,$start) use ($params){
          $q->whereHas('products.bookings',function ($q2) use($start,$params){
              $q2->where( function ($q3) use($start,$params){
                  $q3->where('start_time', '>', $params['booking_end_date'] ?? $start)
                      ->orWhere('end_time', '<', $start);
              });
          });
      });
    }

}
