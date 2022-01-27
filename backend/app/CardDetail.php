<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    protected $fillable = [
        'user_id','card_id','brand','type','funding','exp_month','exp_year', 'last4','status','created_at','updated_at'
    ];
}
