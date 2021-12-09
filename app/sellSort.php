<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sellSort extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','sort'];
}
