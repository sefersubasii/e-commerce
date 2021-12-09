<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('id','name');
    protected $appends = array('edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/attributeGroups/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/attributeGroups/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    
    public function attributes()
    {
        return $this->hasMany('App\Attribute','gid');
    }
}
