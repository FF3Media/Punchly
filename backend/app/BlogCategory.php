<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class BlogCategory extends Model
{

	 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $softDelete = true;
    
    protected $fillable = [
        'id', 'name', 'slug', 'status', 'created_at', 'updated_at' 
    ];
 

}
