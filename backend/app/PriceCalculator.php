<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceCalculator extends Model
{
   protected $fillable = [
        'measurement','desired_size','desired_price','created_at','updated_at'
    ];
}
