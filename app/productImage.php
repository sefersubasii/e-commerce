<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    //
    public $timestamps = false;
    protected $table = "product_images";
    protected $fillable = array('pid','images');

}
