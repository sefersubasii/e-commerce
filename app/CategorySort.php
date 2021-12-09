<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categorySort extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','category_id','sort'];

    public function product()
    {
        return $this->hasOne('App\Products','id','product_id')->select(['name','stock_code','price','stock']);
    }
    
    public function categori()
    {
        return$this->hasOne('App\Categori','id','category_id');
    }

}
