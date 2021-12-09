<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ButonDescriptions extends Model
{
    //
    protected $fillable = array('id','buton','image','title');
    
    public $timestamps  = false;

}
