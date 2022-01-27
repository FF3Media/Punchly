<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $fillable = [
    	'id','user_id','order_group_id','st_charge_id','amount','created_at','updated_at','currency','billing_country','billing_name','invoice','st_status','st_payment_intent_id','st_amount_capturable','st_amount_received','st_payment_method','pay_authorization_id','pay_amount_captured','pay_order_id','paypal_captured_id','paypal_fee'
    ];
}
