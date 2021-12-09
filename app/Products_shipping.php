<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_shipping extends Model
{
    //
    protected $fillable = ["id","pid","desi","shipping_price","use_system"];
    public $timestamps = false;

}
