<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $fillable=["order_id","description","refundAmount","status","code","member_id"];
    public $with=["order","orderItems","products"];
    public $appends=["edit","delete"];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function orderItems()
    {
        return $this->order->items();
    }

    public function products()
    {
        return $this->hasMany('App\RefundReqProduct','refund_request_id');
        //return $this->hasMany('App\Order_item','order_id');
    }

    public function geteditAttribute()
    {
        return "<a href=\"".url("/admin/refundRequests/edit")."/".$this->attributes["id"]."\" data-id=\"".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded shortEditBtn\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }
    public function getdeleteAttribute()
    {
        return "<a href='".url("/admin/refundRequests/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function reqQty($id)
    {
        return \App\RefundReqProduct::where("product_id",$id)->select(["qty","status"])->first();
      
    }
}
