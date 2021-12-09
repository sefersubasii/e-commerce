<?php
/**
 * Created by PhpStorm.
 * User: emre
 * Date: 26.05.2017
 * Time: 11:52
 */

namespace App\Services;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Product
{
    public $cdnDomain = 'https://d23ic3f0nw4szy.cloudfront.net/marketpaketi';

    public function getProduct($id)
    {
        $product = Cache::remember('product_'.$id, 2, function() use ($id){
            return \App\Products::where("id",$id)->with('images','brand','shippings')->first();
        });
        return $product;
    }
    public function stockStatus($stock,$variant)
    {
        if (count($variant)>0) {
            $stockTtl=0;
            foreach ($variant as $var)
            {
                $stockTtl+=$var["stock"];
            }
            if($stockTtl>0){return "in stock";}else{return "out of stock";}
        }else{
            if ($stock>0){return "in stock";}else{return "out of stock";}
        }
    }

    public function stockAmount($stock,$variant)
    {
        if (count($variant)>0) {
            $stockTtl=0;
            foreach ($variant as $var)
            {
                $stockTtl+=$var["stock"];
            }
            return $stockTtl;

        }else{
            return $stock;
        }
    }

    public function baseImg($images,$id)
    {
        if (empty($images)|| $images==null){
            return url("resources/assets/images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg");
        }else{
            $decode = json_decode($images["images"],true);

            return $this->getCdnMinImage($id, @$decode[1]);
        }
    }

    public function getImg($images,$key)
    {
        if (empty($images)|| $images==null){
            return null;
        }else{
            $decode = json_decode($images["images"],true);

            if (isset($decode[$key])){
                return $this->getCdnImage($decode[$key]);
                // return url("src/uploads/products/" . $decode[$key]);
            }else{
                return null;
            }
        }
    }

    public function rebatePercent($discount,$discountType,$price)
    {
        switch ($discountType)
        {
            case 0:
                return 0;
                break;
            case 1:
                return round($discount);
                break;
            case 2:
                return round(100-(($discount/$price)*100));
                break;
        }

    }

    public function getCdnImage($id, $fileName = null){
        return $this->cdnDomain ."/products/" . $id . "/" . $fileName ;
    }

    public function getCdnMinImage($id, $fileName = null){
        return $this->cdnDomain ."/products/min/" . $id . "/" . $fileName ;
    }
}
