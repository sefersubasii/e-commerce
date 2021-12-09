<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campaignSort extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','sort'];
}
