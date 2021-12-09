<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class popularSort extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','sort'];

    public function product()
    {
        return $this->hasOne('App\Products','id','product_id')->select(['name','stock_code','price','stock']);
    }
}
