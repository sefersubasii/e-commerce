<?php

namespace App\Services\Cart;

use App\Services\Cart;
use App\Services\Price;
use App\Shipping;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartShipping
{
    protected $cart;
    protected $price;
    protected $totalShipPrice       = 0.00;
    protected $totalDesi            = 0;
    protected $productFreeShipCount = 0;
    protected $freeShipping         = false;
    protected $shippingCompany;
    protected $responseData = array();

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->shippingCompany   = $this->getShippingCompany(request()->get('shipping'));
        $this->companyDesiValues = json_decode($this->shippingCompany->roles->desi);
        $this->price             = new Price();
        $this->cart              = new Cart(Session::get('cart'));

        $this->responseData = [
            'ttl'          => 0,
            'cartTtl'      => 0,
            'slot'         => array(),
            'freeShipping' => '',
            'cart'         => $this->cart,
            'company'      => $this->shippingCompany,
        ];
    }

    public function calculate()
    {
        if (!$this->shippingCompany || !Session::has('cart')) {
            return null;
        }

        // Kargo Fiyatını Hesapla
        $this->calcShippingPrice();

        // Ürün Desi Kargo Fiyatını Hesapla
        $this->calcDeciPrice();

        // Ücretsiz Kargo Kurallarını Kontrol Et
        $this->checkFreeShipping();

        // Slot tanımlamaları
        $this->setSlot();

        // Eğer sepette bulunan tüm ürünlerin kargo ücreti 0 olarak girildiyse
        $this->lastCheckForFreeShipping();

        $cartTotal = $this->price->currencyFormat($this->totalShipPrice + $this->cart->totalPrice);
        $this->addResponseItem('cartTtl', $cartTotal);

        $totalShipPrice = $this->price->currencyFormat($this->totalShipPrice);
        $this->addResponseItem('ttl', $totalShipPrice);

        $this->cart->setShippingPrice($this->totalShipPrice);
        $this->cart->setShipping($this->shippingCompany);

        Session::put('cart', $this->cart);

        return $this->responseData;
    }

    /**
     * Kargo Firma Bilgileri
     *
     * @param int $id
     * @return mixed
     */
    protected function getShippingCompany($id)
    {
        return Cache::remember('shippingCompany_' . $id, 22 * 60, function () use ($id) {
            return Shipping::with('roles', 'slots')
                ->whereStatus(1)
                ->find($id);
        });
    }

    /**
     * Kargo Fiyatını Hesapla
     *
     * @return $this
     */
    protected function calcShippingPrice()
    {
        collect($this->cart->items)->map(function ($item) {
            $productShipping = $item['item']->p->shippings;

            // desi değerleri girlmmeiş ürün hataya düşebilir kontrolünü yap
            if (!isset($productShipping->use_system)) {
                return;
            }

            // Ürün desi olarak ayarlamış ise desi fiyatını hesapla
            if ($productShipping->use_system == 1) {
                $desi = $productShipping->desi * $item['qty'];

                return $this->totalDesi += intval(floor($desi));
            }

            // Kargo fiyatına ürün kargo fiyatını ekle
            if ($productShipping->shipping_price == 0) {
                return $this->totalShipPrice += $productShipping->shipping_price;
            }

            // ürün ücretsiz kargo ise adedini say
            return $this->productFreeShipCount++;
        });

        return $this;
    }

    /**
     * Desi Hesaplaması
     *
     * @return mixed
     */
    public function calcDeciPrice()
    {

        // Desi fiyatına rakam girilmiş kargo ücretine ekle
        if (isset($this->companyDesiValues[$this->totalDesi]) && is_numeric($this->companyDesiValues[$this->totalDesi])) {
            return $this->totalShipPrice += $this->companyDesiValues[$this->totalDesi];
        }

        // Toplam Desi miktarı 50 den fazla ise
        // $desiValue + ((toplamDesi - 50) * weight_price) == $desiTotal
        if ($this->totalDesi > 50 && !empty($this->companyDesiValues[50])) {
            $desiSub      = $this->totalDesi - 50;
            $desiSubTotal = $desiSub * floatval($this->shippingCompany->roles->weight_price);

            $this->totalShipPrice += $this->companyDesiValues[50] + $desiSubTotal;
        }

        return $this;
    }

    /**
     * Ücretsiz Kargo Kontrolü
     *
     * @return mixed
     */
    protected function checkFreeShipping()
    {
        $shippingRole = $this->shippingCompany->roles;

        if ($shippingRole->free_shipping == 0) {
            return $this->setShippingPrice($shippingRole->fixed_price);
        }

        // Sepet tutarı ücretsiz kargo minimum tutarından küçük ise sabit kargo fiyatını ekle
        $cartTotalPrice = floatval($this->cart->totalPrice) - floatval($this->cart->promotionDiscount);
        if ($cartTotalPrice < floatval($shippingRole->free_shipping)) {
            return $this->setShippingPrice($shippingRole->fixed_price);
        }

        // Toplam desi ücretsiz kargo desi limitinden küçük ise ücretsiz kargo olarak ayarla
        if ($this->totalDesi > $shippingRole->weight_limit) {
            return $this->setFreeShipping();
        }

        // Desi Limiti 50 den büyük değilse ücretsiz kargo olarak ayarla
        $diffWeightlimit = $this->totalDesi - $shippingRole->weight_limit;

        if ($diffWeightlimit <= 50) {
            return $this->setFreeShipping();
        }

        $desiDiff      = $diffWeightlimit - 50;
        $desiDiffTotal = $desiDiff * $shippingRole->weight_price;

        return $this->setShippingPrice(($this->companyDesiValues[50] + $desiDiffTotal));
    }

    protected function setSlot()
    {
        if (count($this->shippingCompany->slots) <= 0) {
            return $this;
        }

        $slots = array();
        foreach ($this->shippingCompany->slots as $key => $value) {
            $records = DB::table('order_slots')
                ->where('shipping_slot_id', '=', $value->id)
                ->whereRaw('Date(created_at) = CURDATE()')
                ->count();

            if ($records < $value->max) {
                $slots[] = $this->shippingCompany->slots[$key];
            }
        }

        return $this->addResponseItem('slot', $slots);
    }

    /**
     * Tanımlamalardan sonra ücretsiz kargo kontrolleri
     *
     * @return void
     */
    protected function lastCheckForFreeShipping()
    {
        if (!isset($this->cart->shipping->roles)) {
            return null;
        }

        // Eğer ücretsiz kargo atanmışsa kargo ücretini sıfırlayalım
        if ($this->cart->freeShipping == 1 || count($this->cart->items) == $this->productFreeShipCount) {
            $this->setFreeShipping();
        }

        // Eğer özel bir fiyat tanımlanmış ise hesaplanan fiyatı kargo ücreti olarak ayarla
        $cartRoles = $this->cart->shipping->roles;

        if (!$this->freeShipping && isset($cartRoles->custom_prices) && is_array($cartRoles->custom_prices)) {
            $customPrices = $cartRoles->custom_prices;

            // Tanımlanan Tüm Özel Fiyatları Hesapla
            foreach ($customPrices['conditions'] as $customPriceIndex => $customPriceCondition) {
                $shippingPrice = floatval($customPrices['shippingPrice'][$customPriceIndex]);

                // Sepet Tutarına Göre Koşulları Uygula
                if ($customPriceCondition == 'between') {
                    $cartAmountStart = floatval($customPrices['cartAmountStart'][$customPriceIndex]);
                    $cartAmountEnd   = floatval($customPrices['cartAmountEnd'][$customPriceIndex]);

                    if ($this->cart->totalPrice >= $cartAmountStart && $this->cart->totalPrice <= $cartAmountEnd) {
                        $this->totalShipPrice = $shippingPrice;
                    }
                }
            }
        }
    }

    /**
     * Response Data içine eleaman ekler/günceller
     *
     * @param mixed $name
     * @param mixed $value = ''
     * @return void
     */
    protected function addResponseItem($name, $value = '')
    {
        $this->responseData[$name] = $value;
    }

    /**
     * Kargo Ücretini Ücretsiz olarak tanımla
     *
     * @param boolean $value
     * @return void
     */
    protected function setFreeShipping(bool $value = true)
    {
        $this->totalShipPrice = 0;
        $this->freeShipping   = $value;
    }

    /**
     * Kargo Ücretini Tanımla
     *
     * @param float $price
     * @return void
     */
    protected function setShippingPrice($price)
    {
        $shippingRole = $this->shippingCompany->roles;

        $freeShippingText = null;

        if ($shippingRole->free_shipping > 0) {
            $freeShippingText = $this->cart->getFreeShipingText();
        }

        $this->addResponseItem('freeShipping', $freeShippingText);

        $this->totalShipPrice += floatval($price);
    }
}
