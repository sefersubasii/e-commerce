<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutputCatMap extends Model
{
    protected $fillable = ["id","local_cat_id","remote_cat_id","output_id"];
    public $timestamps = false;

    public function cat()
    {
    	return $this->hasOne('App\Categori','id','local_cat_id')->select(['title','id']); 
    }

}
