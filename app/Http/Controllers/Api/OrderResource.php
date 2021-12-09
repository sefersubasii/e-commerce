<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;

/**
 * E-Fatura Entegrasyonu için API
 */
class OrderResource extends Controller
{
    public function index()
    {
        $validator = validator()->make(request()->all(), [
            'tarih_basi' => 'date|date_format:Y-m-d',
            'tarih_sonu' => 'date|date_format:Y-m-d',
        ], [
            '*.date'        => 'Geçerli bir tarih girilmedi. :attribute alanı geçerli bir tarih değerine sahip olmalıdır!',
            '*.date_format' => 'Tarih formatı geçersiz. :attribute alanının formatı Yıl-Ay-Gün (Y-m-d) (eg: 2020-01-01) şeklinde olmalıdır!',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        return $this->jsonResponse($this->getOrdersByFilter());
    }

    public function show($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->errorResponse([
                'errors' => 'Sipariş IDsi gönderilmemiş yada geçersiz!',
            ]);
        }

        return $this->getOrderById($id);
    }

    protected function getOrdersByFilter()
    {
        return Order::whereStatus(1)
            ->where(function ($query) {
                if ($tarihBasi = request('tarih_basi')) {
                    $query->where('created_at', '>=', Carbon::parse($tarihBasi)->startOfDay());
                }

                if ($tarihSonu = request('tarih_sonu')) {
                    $query->where('created_at', '<=', Carbon::parse($tarihSonu)->endOfDay());
                }
            })
            ->orderBy('created_at')
            ->with(
                'customer',
                'shippingAddress',
                'billingAddress.getCity',
                'items.product'
            )
            ->get()
            ->map(function ($order) {
                return $this->prepareOrder($order);
            });
    }

    protected function getOrderById($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->errorResponse([
                'Belirtilen ID ye ait bir sipariş bulunamadı!',
            ], 404);
        }

        return $this->jsonResponse($this->prepareOrder($order));
    }

    protected function prepareOrder($order)
    {
        return [
            'kayitNo'        => $order->id,
            'tarih'          => $order->created_at->format('Y-m-d'),
            'odeme'          => $this->getPaymentType($order->payment_type),
            'vkNo'           => $order->billingAddress->tax_no,
            'email'          => $order->customer->email,
            'teslimatAyrimi' => $this->isBillingSameAddress($order->billingAddress, $order->shippingAddress),
            'fatura'         => [
                'unvan'  => $order->billingAddress->fullName,
                'adres'  => $this->sanitizeAddress($order->billingAddress->address),
                'il'     => $order->billingAddress->getCity->id,
                'ilce'   => $order->billingAddress->state,
                'vdaire' => $order->billingAddress->tax_place,
                'tel'    => $this->checkAndSanitizePhone($order->billingAddress->phone),
                'telGsm' => $this->checkAndSanitizePhone($order->billingAddress->phoneGsm),
            ],
            'teslimat'       => [
                'unvan'  => $order->shippingAddress->fullName,
                'adres'  => $this->sanitizeAddress($order->shippingAddress->address),
                'il'     => $order->shippingAddress->getCity->id,
                'ilce'   => $order->shippingAddress->state,
                'tel'    => $this->checkAndSanitizePhone($order->shippingAddress->phone),
                'telGsm' => $this->checkAndSanitizePhone($order->shippingAddress->phoneGsm),
            ],
            'detaylar'       => $this->prepareOrderItems($order),
            'dipBilgi'       => [
                'promosyonIskonto' => $this->priceFormat($order->discount_amount),
                'dipIskontoYuzde'  => $this->priceFormat($this->calcDiscountPercent($order->grand_total, $order->discount_amount)),
                'brut'             => $this->priceFormat($order->subtotal),
                'kdv'              => $this->priceFormat($order->tax_amount),
                'sonuc'            => $this->priceFormat($this->calcDiscount($order->grand_total, $order->discount_amount)),
            ],
        ];
    }

    protected function prepareOrderItems($order)
    {
        $promotionProducts = json_decode($order->promotionProducts, true);

        $productDetail = $order->items->map(function ($item) use ($promotionProducts) {
            $discount = 0;

            // Promosyonlu Ürün indirim fiyatı
            if (isset($promotionProducts[$item->product_id])) {
                $discount = bcadd($discount, $promotionProducts[$item->product_id], 2);
            }

            return $this->addProductDetail(
                $item->product_id,
                $item->name,
                $item->product->tax,
                $item->qty,
                $item->price,
                $discount
            );
        });

        // Kapıda Ödeme tutarını ekle
        if ($order->pdAmount > 0) {
            $productDetail->push(
                $this->addProductDetail('KAPIDAODEME', $order->payment, 18, 1, $order->pdAmount)
            );
        }

        // Kargo tutarını ekle
        if ($order->shipping_amount > 0) {
            $productDetail->push(
                $this->addProductDetail('KARGO', 'Kargo Ücreti', 18, 1, $order->shipping_amount)
            );
        }

        return $productDetail;
    }

    protected function addProductDetail($id, $name, $tax, $qty, $price, $iskonto = 0)
    {
        $bedel = bcmul($price, $qty, 2);

        if ($iskonto) {
            $bedel = bcsub($bedel, $iskonto, 2);
        }

        return [
            'urunKod' => $id,
            'urunAdi' => $name,
            'kdvOran' => $tax,
            'miktar'  => $qty,
            'fiyat'   => $this->priceFormat($price),
            'iskonto' => $this->priceFormat($iskonto),
            'bedel'   => $this->priceFormat($bedel),
        ];
    }

    protected function getPaymentType($paymentType = null)
    {
        switch ($paymentType) {
            case '1':
                return 'HAV';
                break;
            case '2':
                return 'KAP';
                break;
            case '3':
                return 'SAN';
                break;
            default:
                return '';
                break;
        }
    }

    protected function isBillingSameAddress($billingAddress, $shippingAddress)
    {
        return (
            $billingAddress->address != $shippingAddress->address
            || $billingAddress->city != $shippingAddress->city
            || $billingAddress->state != $shippingAddress->state
            || $billingAddress->fullName != $shippingAddress->fullName
        );
    }

    protected function sanitizeAddress($text)
    {
        $text = str_replace(array("\n", "\r"), ' ', $text);
        $text = str_replace('   ', ' ', $text);
        return str_replace('  ', ' ', $text);
    }

    protected function checkAndSanitizePhone($phone)
    {
        $phone = str_replace(['+', ' ', '(', ')'], ['', '', '', ''], $phone);

        return preg_match("/^[9]{1}[0]{1}[0-9]{10}$/", $phone) ? $phone : '';
    }

    protected function errorResponse($errors, $errorStatus = 400)
    {
        return $this->jsonResponse([
            'errors' => $errors,
        ], $errorStatus);
    }

    protected function jsonResponse($data, $status = 200)
    {
        ini_set('serialize_precision', -1);
        return response()->json($data, $status, [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset'      => 'utf-8',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function priceFormat($price)
    {
        return round($price, 2);
    }

    protected function calcDiscount($price, $discountAmount)
    {
        return bcsub($price, $discountAmount, 2);
    }

    protected function calcDiscountPercent($price, $discountAmount)
    {
        return (($price - $this->calcDiscount($price, $discountAmount)) / $price) * 100;
    }
}
