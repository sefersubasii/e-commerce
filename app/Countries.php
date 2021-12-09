<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    public $timestamps = false;
    protected $fillable = array('name');
    protected $appends = array('cities','edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/countries/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/countries/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getcitiesAttribute() {
        return "<a href='".url("/admin/cities?country_id=".$this->attributes["id"])."'>Şehirler</a>";
    }
}
