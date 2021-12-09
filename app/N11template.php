<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class N11template extends Model
{
    protected $fillable = ["id","name","shipping","delivery","priceOpt","price","discount","start_date","expire_date","subtitle"];
    public $timestamps = false;
    protected $appends = array('start_date','expire_date');

    public function getstartDateAttribute() {
        return date("d-m-Y",strtotime($this->attributes["start_date"]));
    }

    public function getexpireDateAttribute() {
        return date("d-m-Y",strtotime($this->attributes["expire_date"]));
    }

}
