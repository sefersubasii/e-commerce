<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class output extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'description', 'status', 'categories', 'brands', 'otherFilters', 'selectedColums', 'additionalPrice', 'names', 'rootElementName', 'loopElementName', 'permCode', 'ipWhiteList', 'type'];
    protected $appends = array('edit', 'delete');

    public function geteditAttribute()
    {
        return "<a href=\"" . url("/admin/output/edit") . "/" . $this->attributes["id"] . "\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='" . url("/admin/output/delete") . "/" . $this->attributes["id"] . "' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getselectedColumsAttribute()
    {
        return json_decode($this->attributes["selectedColums"], true);
    }

    public function getAdditionalPriceAttribute()
    {
        return json_decode($this->attributes["additionalPrice"], true);
    }

    public function getnamesAttribute()
    {
        return json_decode($this->attributes["names"], true);
    }

    public function catMap()
    {
        return $this->hasMany('App\OutputCatMap', 'output_id')->select(['local_cat_id', 'remote_cat_id']);
    }
}
