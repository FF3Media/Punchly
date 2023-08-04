<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    protected $softDelete = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','provider','provider_id','access_token','email','name', 'password','user_role','mobile','postcode','city','state','country','address','status','created_at','updated_at','avatar','email_verified_at','remember_token','deleted_at','company_name', 'last_login_at','last_login_ip','login_access'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //You can also use below statement 

    protected $guarded = ['*'];
    
    public function card_details(){
       return $this->hasMany('App\CardDetail');
    }

    public function get_orders(){
        return $this->hasMany('App\Order', 'user_id');
   }

   public function payment_total()
    {
        return $this->hasMany('App\PaymentDetail', 'user_id');
    }
    
    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function get_country()
    {
        return $this->belongsTo(Country::class, 'country','id');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function get_state()
    {
        return $this->belongsTo(States::class, 'state','id');
    }
    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function get_city()
    {
        return $this->belongsTo(City::class, 'city','id');
    }
}
