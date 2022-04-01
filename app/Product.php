<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;
    
    public function brands(){
        return $this->belongsTo('App\Brand', 'brand_id','id');
    }

    public function bill_detail(){
        return $this->hasMany('App\BillDetail', 'product_id','id');
    }
}
