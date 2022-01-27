<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
   	protected $fillable = [
        'order_id', 'order_image', 'image_format','status'
    ];
}
