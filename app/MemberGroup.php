<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberGroup extends Model
{
    public $timestamps = false;
    protected $appends  = ['edit','delete'];
    protected $fillable = ['name'];

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/customerGroups/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/customerGroups/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
}
