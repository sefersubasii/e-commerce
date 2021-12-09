<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('id','name','filter_status');
    protected $appends = array('edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/variants/edit")."/".$this->attributes["id"]."\"  class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/variants/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    public function avalues()
    {
        //return $this->belongsToMany('App\Categori','product_to_cat','pid','cid')->select(['categories.id','title']);

        //return $this->belongsToMany('App\Variant_value','Variants','id','vid')->select(['value']);
        return $this->belongsToMany('App\Variant','Variant_values','vid','id')->select(['value']);

        //bu çalışıyor
        //return $this->hasMany('App\Variant_value','vid')->select(['value']);

    }

    public function values()
    {
        //return $this->belongsToMany('App\Categori','product_to_cat','pid','cid')->select(['categories.id','title']);

        //return $this->belongsToMany('App\Variant_value','Variants','id','vid')->select(['value']);

        //bu çalışıyor
        return $this->hasMany('App\Variant_value','vid')->select(['value','id']);

    }
    
    

}
