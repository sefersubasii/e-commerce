<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["id","category_id","title","content","slug","image","seo","sort","status"];

    protected $appends = array('edit','delete');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/article/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/article/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    
    public function blogCategory()
    {
        return $this->hasOne('App\BlogCategory','id','category_id');
    }

}
