<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignUsed extends Model
{
    //
    protected $table = 'campaigns_used';
    protected $fillable=array('id','member_id','campaign_id','order_id');

}
