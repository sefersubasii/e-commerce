<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WholesaleForm extends Model
{
    protected $fillable = ['product_id', 'name', 'phone', 'quantity'];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
