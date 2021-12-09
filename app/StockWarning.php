<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockWarning extends Model
{
    //
    protected $fillable = array('id','product_id','member_id');
    protected $appends = array('delete');
    protected $with = ['customer','product'];
    
    public function getdeleteAttribute() 
    {
        return "<a href='".url("/admin/stockWarnings/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    

    public function customer()
    {
        return $this->belongsTo('App\Member','member_id','id');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Products','product_id','id');
    }

}
