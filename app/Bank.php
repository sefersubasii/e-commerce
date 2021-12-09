<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $timestamps = false;
    protected $appends = ["edit","delete"];
    protected $fillable = array('id','name','owner','iban','image','sort','currency');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/settings/bank/detail")."/".$this->attributes["id"]."\" data-id=\"".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded detailBtn\"><i class=\"glyphicon glyphicon-edit\"></i> Detay</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/settings/bank/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }


}
