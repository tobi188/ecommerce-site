<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "brands";
    public $timestamps = false;
    
    public function category(){
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    public function products(){
        return $this->hasMany('App\Product', 'brand_id','id');
    }
}
