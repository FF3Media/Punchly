<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{

	//use SoftDeletes;
   // protected $softDelete = false;

    protected $fillable = [
    	'id', 'coupon_id', 'name','amount_off', 'percent_off', 'currency' , 'duration', 'duration_in_months', 'max_redemptions', 'redeem_by', 'valid', 'times_redeemed', 'created_at','description','start_date','end_date'
    ];
}
