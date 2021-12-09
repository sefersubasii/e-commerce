<?php
/**
 * Created by PhpStorm.
 * User: emre
 * Date: 15.08.2017
 * Time: 15:13
 */

namespace App\Services;


class ProYedek
{
    public $p               =null;
    public $basePrice       =0;
    public $realPrice       =0;
    public $discountedPrice =0;
    public $withoutTax      =0;
    public $taxPrice        =0;
    public $name="";
    public $discount_type   =null;
    public $discount        =null;
    public $price           =0;
    public $package         =null;
    public $id              =null;
    public $content         =null;
    public $images           =null;
    public $reviews         =null;
    public $stars           =null;
    public $relateds       =null;

    public function __construct($p)
    {
        $this->p         = $p;
        $this->id        = $p->id;
        $this->realPrice = $this->realPrice();
        $this->basePrice = $this->basePrice();
        $this->discountedPrice = $this->discountedPrice();
        $this->withoutTax=$this->withoutTax();
        $this->taxPrice=$this->taxPrice();
        $this->name=$p->name;
        $this->discount_type=$p->discount_type;
        $this->discount=$p->discount;
        $this->price=$p->price;
        $this->package = $p->package;
        $this->content = $p->content;
        $this->images  = empty($p->images->images)?null:json_decode($p->images->images,true);
        $this->reviews = $p->reviews;
        $this->stars   = $p->reviews->avg("rating");
        $this->relateds = $p->relateds;
    }

    public function tl($deger)
    {
        $tl_formati = number_format($deger, 2, ',', '.');
        return $tl_formati;
    }

    public function basePrice()
    {
        return $this->p->price;
    }

    public function realPrice()
    {
        return $this->discountedPrice();
    }

    public function  discountedPrice()
    {
        switch ($this->p->discount_type)
        {
            case 0:
                return $this->withTax();
                break;
            case 1:
                return $this->withTax()-(($this->withTax()*$this->p->discount)/100);
                break;
            case 2:
                return $this->p->discount;
                break;
            case 3:
                return $this->withTax()-$this->p->discount;
                break;
        }

    }

    public function withTax()
    {
        switch ($this->p->tax_status)
        {
            case 0:
                return $this->p->price+(($this->p->price*$this->p->tax)/100);
                break;
            case 1:
                return $this->p->price;
                break;

        }
    }

    public function withoutTax()
    {
        switch ($this->p->tax_status)
        {
            case 0:
                return $this->realPrice();
                break;
            case 1:
                //return $price-(($price*$tax)/100);
                if ($this->p->tax<10){
                    $tax="0".$this->p->tax;
                }else{
                    $tax = $this->p->tax;
                }
                return $this->realPrice()/("1.".$tax);
                break;

        }
    }

    public function taxPrice()
    {
        $withTax = $this->withTax();
        //return $withTax;
        if ($this->p->tax<10){
            return ($withTax)*("0.0".$this->p->tax);
        }else{
            return ($withTax)*("0.".$this->p->tax);
        }

    }

    public function rebatePercent()
    {
        switch ($this->discount_type)
        {
            case 0:
                return 0;
                break;
            case 1:
                return round($this->discount);
                break;
            case 2:
                return round(100-(($this->discount/$this->price)*100));
                break;
        }

    }

    public function baseImg()
    {
        if (empty($this->images)|| $this->images==null){
            //return null;
            return url("resources/assets/images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg");
        }else{
            $decode=$this->images;
            
            //return $decode[1];
            return url("src/uploads/products/" . $decode[1]);
        }
    }

}