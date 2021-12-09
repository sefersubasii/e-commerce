<?php

namespace App\Services;

use App\Products;
use App\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Cart
{
    public $items             = null;
    public $totalQty          = 0;
    public $totalPrice        = 0;
    public $subTotal          = 0;
    public $taxTotal          = 0;
    public $others            = [];
    public $shipping          = [];
    public $shippingPrice     = 0;
    public $freeShipping      = 0;
    public $coupon            = null;
    public $couponDiscount    = 0;
    public $couponSubtotal    = 0;
    public $chosenPromotion   = [];
    public $promotionDiscount = 0;
    public $promotionProducts = [];
    public $orderNo           = null;
    public $orderId           = null;
    public $status            = false;
    public $guest             = null;

    public function __construct($oldCart)
    {
        $this->price = app(Price::class);

        if ($oldCart) {
            $this->items             = $oldCart->items;
            $this->totalQty          = $oldCart->totalQty;
            $this->totalPrice        = $oldCart->totalPrice;
            $this->others            = $oldCart->others;
            $this->shipping          = $oldCart->shipping;
            $this->subTotal          = $oldCart->subTotal;
            $this->taxTotal          = $oldCart->taxTotal;
            $this->shippingPrice     = $oldCart->shippingPrice;
            $this->freeShipping      = $oldCart->freeShipping;
            $this->coupon            = $oldCart->coupon;
            $this->couponDiscount    = $oldCart->couponDiscount;
            $this->couponSubtotal    = $oldCart->couponSubtotal;
            $this->chosenPromotion   = $oldCart->chosenPromotion;
            $this->promotionDiscount = $oldCart->promotionDiscount;
            $this->promotionProducts = $oldCart->promotionProducts;
            $this->orderNo           = $oldCart->orderNo;
            $this->orderId           = $oldCart->orderId;
            $this->status            = $oldCart->status;
            $this->guest             = $oldCart->guest;
        }
    }

    public function add($item, $id, $qty)
    {
        //dd($item);
        $storedItem = ["qty" => 0, "price" => $item->realPrice, "item" => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem["qty"] += $qty;
        $storedItem["price"] = $item->realPrice * $storedItem["qty"];
        $this->items[$id]    = $storedItem;
        $this->totalQty += $qty;
        $this->subTotal += $item->withoutTax * $qty;
        $this->taxTotal += $item->taxPrice * $qty;
        $this->totalPrice += $item->realPrice * $qty;
    }

    public function updateItem($id, $qty)
    {
        $old                     = $this->items[$id]['qty'];
        $this->items[$id]['qty'] = $qty;
        if ($qty > $old) {
            $this->totalQty += $qty - $old;
            $this->subTotal += $this->items[$id]["item"]->withoutTax * ($qty - $old);
            $this->taxTotal += $this->items[$id]["item"]->taxPrice * ($qty - $old);
            $this->totalPrice += $this->items[$id]["item"]->realPrice * ($qty - $old);
        } elseif ($qty < $old) {
            $this->totalQty -= $old - $qty;
            $this->subTotal -= $this->items[$id]["item"]->withoutTax * ($old - $qty);
            $this->taxTotal -= $this->items[$id]["item"]->taxPrice * ($old - $qty);
            $this->totalPrice -= $this->items[$id]["item"]->realPrice * ($old - $qty);
            if ($this->items[$id]["qty"] < 1) {
                $this->removeItem($id);
            }
        }
    }

    public function removeItem($id)
    {
        //dd($this->items[$id]);
        if(!isset($this->items[$id])){
            return false;
        }

        $this->totalQty -= $this->items[$id]['qty'];
        $this->subTotal -= $this->items[$id]['item']->withoutTax * $this->items[$id]['qty'];
        $this->taxTotal -= $this->items[$id]['item']->taxPrice * $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['item']->realPrice * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

    public function setOthers($others)
    {
        $this->others = $others;
    }

    public function setShippingPrice($price)
    {
        $this->shippingPrice = $price;
    }

    public function getShippingPrice($formatted = false)
    {
        if ($formatted) {
            return $this->price->currencyFormat($this->shippingPrice);
        }

        return $this->shippingPrice;
    }

    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    public function save()
    {
        session()->put('cart', $this);

        return $this;
    }

    /**
     * Ücretisiz kargo fiyat bilgilendirmesi
     *
     * @return string
     */
    public function getFreeShipingText()
    {
        $shippingPrice = ($this->shipping->roles->free_shipping ?? '0,00');

        return sprintf('%s TL üzeri siparişlerinizde kargo ücretsizdir!', $shippingPrice);
    }
}
