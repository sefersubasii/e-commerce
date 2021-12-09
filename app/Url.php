<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    public $timestamps = false;
    protected $table = 'url';
    protected $fillable = ["id","old","new","count"];
}
