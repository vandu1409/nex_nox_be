<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'business_id',
        'user_profile_id',
        'star',
        'comment',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

}
