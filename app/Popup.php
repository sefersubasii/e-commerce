<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $guarded = ["id"];
    protected $appends = array('edit', 'delete');

    public function getCategoriesAttribute()
    {
        if (isset($this->attributes['categories']) && is_string($this->attributes['categories'])) {
            return json_decode($this->attributes['categories'], true);
        }
    }

    public function geteditAttribute()
    {
        return "<a href=\"" . url("/admin/settings/popup/edit") . "/" . $this->attributes["id"] . "\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='" . url("/admin/settings/popup/delete") . "/" . $this->attributes["id"] . "' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
}
