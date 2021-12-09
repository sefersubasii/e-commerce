<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    protected $fillable = ["slider_id","name","status","sort","content","image","imageCover","link"];
    public $timestamps=false;
    protected $appends = array('edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/settings/sliderItem/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/settings/sliderItem/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    
    
}
