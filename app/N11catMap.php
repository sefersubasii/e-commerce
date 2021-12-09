<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class N11catMap extends Model
{
    protected $fillable = ["id","category_id","n11category_id","n11template_id","category","n11category"];
    public $timestamps = false;

    public function n11Template()
    {
    	return $this->hasOne('App\N11template','id','n11template_id')->select(['name','id','start_date','expire_date']); 
    }

}
