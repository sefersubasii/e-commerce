<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public $fillable=['product_id','member_id','author','email','text','rating','status'];
    public $with=["product","member"];
    public $appends=["edit","delete"];

    public function product()
    {
        return $this->belongsTo('App\Products');
    }
    public function member()
    {
        return $this->belongsTo('App\Member');
    }

    public function geteditAttribute()
    {
        return "<a href=\"".url("/admin/reviews/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='".url("/admin/reviews/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

}
