<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $timestamps = false;
    protected $guarded = ["id"];
    protected $appends = array('edit');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/settings/banner/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }
    
}
