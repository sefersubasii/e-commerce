<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $appends = array('edit','delete','itemsLink');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/settings/slider/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/settings/slider/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getitemsLinkAttribute() {
        return "<a href='".url("/admin/settings/sliderItems?id=").$this->attributes["id"]."' class=\"btn btn-xs btn-primary btn-rounded\"><i class=\"glyphicon glyphicon-folder-open\"></i> Resimler</a>";
    }
}
