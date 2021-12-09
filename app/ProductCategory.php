<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_to_cat';

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'pid');
    }

    public function category()
    {
        return $this->hasOne(Categori::class, 'id', 'cid');
    }
}
