<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps  = false;
    protected $fillable = array('id', 'name', 'pay_type', 'image', 'status', 'sort', 'integration', 'price', 'pd_status', 'pdCash_status', 'pdCash_price', 'pdCard_status', 'pdCard_price');

    public function roles()
    {
        return $this->hasOne('App\ShippingRole', 'shipping_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany('App\ShippingSlot', 'shipping_id', 'id');
    }

}
