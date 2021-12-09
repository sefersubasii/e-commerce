<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public $guarded=[];
    public $timestamps=false;
    protected $appends = array('edit','delete','startDate','stopDate');

    public function geteditAttribute() 
    {
        return "<a href=\"".url("/admin/campaigns/promotion/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() 
    {
        return "<a href='".url("/admin/campaigns/promotion/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getstartDateAttribute() 
    {
        return date("d-m-Y",strtotime($this->attributes["startDate"]));
    }

    public function getstopDateAttribute() 
    {
        return date("d-m-Y",strtotime($this->attributes["stopDate"]));
    }
    
    public function product($id)
    {
        return \App\Products::where(["id"=>$id])->select(["name","id"])->first();
    }
    
    public function group()
    {
        return $this->hasOne('App\MemberGroup','id','memberGroupId');
    }
    
    public function category()
    {
        return $this->hasOne('App\Categori','id','baseCategoryId');
    }

    public function brand()
    {
        return $this->hasOne('App\Brand','id','baseBrandId');
    }

}
