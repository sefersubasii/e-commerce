<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    //
    protected $fillable=array('code','maxUse','PersonUseLimit','startDate','stopDate','value_type','value','freeShip','discounted','usageLimit','special','specialValues');

    protected $appends = array('edit','delete','startDate','stopDate','created_at');

    public function geteditAttribute() {
        return "<a href=\"".url("/admin/campaigns/coupons/edit")."/".$this->attributes["id"]."\" class=\"btn btn-xs btn-success btn-rounded\"><i class=\"glyphicon glyphicon-edit\"></i> Düzenle</a>";
    }

    public function getdeleteAttribute() {
        return "<a href='".url("/admin/campaigns/coupons/delete")."/".$this->attributes["id"]."' onclick=\"return confirm('Silmek İstediğinize Eminmisiniz?')\" class=\"btn btn-xs btn-danger btn-rounded\"><i class=\"glyphicon glyphicon-remove\"></i> Sil</a>";
    }

    public function getstartDateAttribute() {
        return date("d-m-Y",strtotime($this->attributes["startDate"]));
    }

    public function getstopDateAttribute() {
        return date("d-m-Y",strtotime($this->attributes["stopDate"]));
    }

    public function getCreatedAtAttribute() {
        return date("d-m-Y H:i:s",strtotime($this->attributes["created_at"]));
    }

    public function used()
    {
        return $this->hasMany('App\CampaignUsed','campaign_id');
    }

}
