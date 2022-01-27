<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    protected $fillable = [ 
    	'reason','id','created_at','updated_at'
    ];
}
