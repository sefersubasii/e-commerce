<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    //
    public $fillable   = ["order_id", "qty", "price", "name", "stock_code", "product_id"];
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne('App\Products', 'id', 'product_id')
            ->select([
                "id", "tax", "name", "stock_type", 'price', 'final_price',
            ]);
    }
}
