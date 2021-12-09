<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //
    protected $fillable = ['id', 'title', 'slug', 'content', 'seo', 'sort', 'status'];
    protected $appends  = array('edit', 'delete');

    public function geteditAttribute()
    {
        return "<a href=\"" . url("/admin/pages/edit") . "/" . $this->attributes["id"] . "\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='" . url("/admin/pages/delete") . "/" . $this->attributes["id"] . "' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

}
