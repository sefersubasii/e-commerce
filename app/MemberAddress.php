<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    public $timestamps = false;
    protected $fillable = array('member_id','address','countries_id','cities_id','districts_id','postal_code');

    public function country(){
        return $this->hasOne('App\Countries','id','countries_id');
    }

    public function city(){
        return $this->hasOne('App\Cities','id','cities_id');
    }

    public function district(){
        return $this->hasOne('App\Districts','id','districts_id');
    }

}
