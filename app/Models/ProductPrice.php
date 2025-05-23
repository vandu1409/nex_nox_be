<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'price', 'price_holiday', 'price_in_hour',
        'price_capital', 'price_overnight', 'price_save',
        'price_weekend', 'price_with_card', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
