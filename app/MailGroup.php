<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailGroup extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ["id","name"];
    protected $appends = array('edit','delete');

    public function geteditAttribute() 
    {
        return "<a href='".url("/admin/mail/mailGroup/edit")."/".$this->attributes["id"]."' data-id=\"".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded shortEditBtn\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() 
    {
        return "<a href='".url("/admin/mail/mailGroup/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    
}
