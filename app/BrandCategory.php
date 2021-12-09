<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['id','brand_id','category_id','image','content'];

}
