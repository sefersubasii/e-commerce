<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSlot extends Model
{
    protected $fillable = array('id','shipping_slot_id','order_id','created_at','updated_at');

    public function shippingSlot()
    {
    	return $this->hasOne('App\ShippingSlot','id','shipping_slot_id'); 
    }

}
