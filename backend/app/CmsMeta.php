<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsMeta extends Model
{
   	protected $fillable = [
        'id','status','user_id','meta_key','meta_value','cms_id','created_at','updated_at'
    ];

    public function cms(){
    	return $this->belongsTo('App\Cms','cms_id');
    }
}
