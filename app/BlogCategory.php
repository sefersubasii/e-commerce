<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    public $timestamps=false;
    protected $fillable = ["id","parent_id","title","slug","sort","status","seo","image"];
    protected $appends = array('edit','delete','sub');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/blog-categories/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/blog-categories/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getsubAttribute(){
        return "<a href='".url("/admin/blog-categories?parent=").$this->attributes["id"]."'  class=\"btn btn-xs btn-info btn-rounded\"><i class=\"fa fa-bars\"></i> Alt Kategoriler</a>";
    }
    
    public function childs(){
        return $this->hasMany('App\BlogCategory','parent_id','id') ;
    }
    
    public function articles()
    {
        return $this->hasMany('App\Article', 'category_id', 'id');
    
    }

}
