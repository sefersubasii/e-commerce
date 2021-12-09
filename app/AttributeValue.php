<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    //
    public function Attribute()
    {
        return $this->belongsToMany('App\Attribute','aid');
    }
}
