<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    public $timestamps = false;
    protected $fillable = array('name','country_id');
    protected $appends = array('districs','edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/cities/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/cities/delete")."/".$this->attributes["id"]."?country_id=".$this->attributes["country_id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getdistricsAttribute() {
        return "<a href='".url("/admin/districts?city_id=".$this->attributes["id"])."'>İlçeler</a>";
    }

    public function country()
    {
        return $this->belongsTo('App\Countries','country_id','id');
    }
}
