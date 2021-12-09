<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class Categori extends Model
{
    use NestableTrait;

    public $timestamps  = false;
    protected $table    = "categories";
    protected $fillable = ['id', 'parent_id', 'title', 'slug', 'content', 'image', 'code', 'seo', 'sort', 'status', 'imageCover'];
    protected $parent   = 'parent_id';

    public function childs()
    {
        return $this->hasMany('App\Categori', 'parent_id', 'id')->where('status', 1);
    }

    public function pros()
    {
        return $this->belongsToMany('App\Products', 'product_to_cat', 'cid', 'pid')->select(['products.id', 'name', 'discount_type', 'final_price']);
    }

    public function products()
    {
        return $this->belongsToMany('App\Products', 'product_to_cat', 'cid', 'pid');
    }

    public function parent()
    {
        return $this->hasMany('App\Categori', 'id', 'parent_id');
    }
}
