<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant_value extends Model
{
    //
    protected $fillable = array('id','vid','value');

    public function ana()
    {
        //dd( $this->hasOne('App\Brand','id')->select(['name']));
        return $this->hasOne('App\Variant','id','vid')->select(['id','name']);
    }
    
}
