<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

 

class Blog extends Model
{
	 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    use SoftDeletes;
    protected $softDelete = true;


    protected $fillable = [
        'id', 'blog_title', 'blog_description','blog_slug','blog_category_id','feature_image','created_by','status', 'created_at', 'updated_at' 
    ];



    public function blogCat(){
    	return $this->belongsTo('App\BlogCategory','blog_category_id','id');
    }

    
}