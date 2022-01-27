<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garment extends Model
{
    protected $fillable = [
        'description','name','feature_image','status','created_at','updated_at'
    ];
}
