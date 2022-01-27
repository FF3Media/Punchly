<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_name', 'order_message', 'desired_height','desired_width','desired_size','garment_id','order_date','delivery_date','measurement','user_id','status','created_at','updated_at','amount','feature_image','reason','id','order_unique_id','order_digitizer_id','manual_override','desired_old_height','desired_old_width','coupon_id','comment','desired_output','gst','rst','qst','pst','hst'
    ];

    public function garment(){
        return $this->belongsTo('App\Garment', 'garment_id');
    }

    public function payment_details(){
        return $this->belongsTo('App\PaymentDetail', 'order_group_id' , 'order_group_id');
    }    

    public function user(){
    	return $this->belongsTo('App\User')->select(['id','first_name','last_name','email','status','city','state','country','postcode','address']);
    }

    public function coupon(){
        return $this->belongsTo('App\Coupon','coupon_id','coupon_id');
    }


    public function digitizer(){
    	return $this->belongsTo('App\User','order_digitizer_id')->select(['id','first_name','last_name','email','status']);
    }

    public function rejection_reason(){
        return $this->belongsTo('App\RejectionReason','reason_id')->select(['id','reason']);
    }

    public function order_images(){
        return $this->hasMany('App\OrderImage','order_id');
    }

}
