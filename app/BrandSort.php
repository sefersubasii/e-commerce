<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brandSort extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','brand_id','sort'];

    public function product()
    {
        return $this->hasOne('App\Products','id','product_id')->select(['name','stock_code','price','stock','brand_id']);
    }
    public function brand()
    {
        return$this->hasOne('App\Brand','id','brand_id');
    }
}
