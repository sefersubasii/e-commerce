<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingSlot extends Model
{
    public $timestamps = false;
    protected $fillable = array('id','shipping_id','time1','time2','max');

}
