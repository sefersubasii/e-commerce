<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    //public $guarded = array('id');
    protected $primaryKey = 'id';
    protected $fillable = array('id','name','groupId','email');
    protected $appends = array('edit','delete');
    protected $with = ["group"];

    public function geteditAttribute()
    {
        return "<a href=\"".url("/admin/mail/mailList/edit")."/".$this->attributes["id"]."\" data-id=\"".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded shortEditBtn\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute()
    {
        return "<a href='".url("/admin/mail/mailList/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }
    
    public function group()
    {
        return $this->hasOne('App\MailGroup', 'id',"groupId");
    }

}
