<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{

	protected $fillable = [
        'id','meta_tag','meta_title','meta_description','title','content','created_at','updated_at'
    ];
    public function cmsmeta(){
        return $this->hasMany('App\CmsMeta','cms_id');
    }
      
     public function cmsmetaapi(){
        return $this->hasOne('App\CmsMeta','cms_id');
    }

}
