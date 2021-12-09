<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    public $timestamps = false;
    protected $fillable = array('name','cities_id','id');
    protected $appends = array('edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/districts/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/districts/delete")."/".$this->attributes["id"]."?cities_id=".$this->attributes["cities_id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

}
