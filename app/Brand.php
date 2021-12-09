<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('id', 'name', 'slug', 'image', 'code', 'seo_title', 'seo_keywords', 'seo_description', 'sort', 'filter_status');

    public function getEdit()
    {
        return User::where('id', 1)->first()->email;
    }

    public function products()
    {
        return $this->belongsTo('App\Products', 'id');
    }

    public function productsCount()
    {
        return $this->hasMany('App\Products', 'brand_id')
            ->select('brand_id')
            ->where('status', 1)
            ->where('stock', '>', 0);
    }

    public function allProducts()
    {
        return $this->hasMany('App\Products', 'brand_id');
    }

    public function category()
    {
        return $this->hasMany('App\BrandCategory', 'brand_id');
    }
}
