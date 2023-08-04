<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cms_services extends Model
{
   use SoftDeletes;
    protected $softDelete = true;


    protected $fillable = [
        'id', 'service_title', 'service_description','service_slug','feature_image','created_by','status', 'created_at', 'updated_at','meta_description', 'meta_tag'
    ];

 
}
