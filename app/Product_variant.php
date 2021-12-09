<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_variant extends Model
{
    //
    public $timestamps = false;
    protected $fillable=array("id","pid","name","vals","stock_code","stock","price","desi");

    public function value()
    {
        return $this->belongsToMany('App\Variant_value','product_variant_variant_values','pv_id','vv_id');
    }
}
