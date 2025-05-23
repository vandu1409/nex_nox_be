<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'file_name', 'disk_name', 'file_path','imageable_id','imageable_type',
        'sort_order', 'is_featured'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
