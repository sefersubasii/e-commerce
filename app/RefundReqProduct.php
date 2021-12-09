<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundReqProduct extends Model
{
    //
    protected $fillable=["id","refund_request_id","product_id","qty","status","description"];
    public $timestamps=false;

    public function product()
    {
    	return $this->hasOne('App\Products','id','product_id');
    }

}
