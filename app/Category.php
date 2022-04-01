<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    

    public function brands(){
        return $this->hasMany('App\Brand', 'category_id','id');
    }
    public function products(){
        return $this->hasMany('App\Brand', 'category_id','brand_id');
    }
}
