<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductButon extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    //protected $appends=['img'];
    //protected $with=["imagesAs"];

    public function product()
    {
        return $this->belongsTo('App\Products');
    }

    public static function updateOrCreate(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }
    /*
public function getimgAttribute()
{
$zz = $this->images;
$decode = json_decode($zz,true);
$pathToImage = public_path().'/src/uploads/products/'.$decode[1];
if (File::exists($pathToImage) && !empty($decode)) {
return '<img width="60px" src="' . url(url("/") . "/src/uploads/products/" . $decode[1]) . '">';
}else{
return '<img width="30px" src="'.url(url("/")."/src/uploads/no-image/no-image.png").'">';
}
}
public function images()
{
return \App\productImage::find($this->attributes["product_id"]);
}
 */

}
