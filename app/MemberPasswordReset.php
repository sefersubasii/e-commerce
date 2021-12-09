<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPasswordReset extends Model
{

	public $timestamps = false;
	protected $fillable = ['id','email','token','created_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
    
}
