<?php

namespace App\Http\Controllers;

use App\Order;
use App\Products;
use App\Promotion;
use App\Services\Cart;
use App\Services\Price;
use App\Services\Pro;
use App\Services\Product;
use Illuminate\Support\Facades\Session;

class RepeatOrderController extends Controller
{
    public function store($orderId)
    {
        $order = Order::with('items')->findOrfail($orderId);

        $order->items->map(function ($item) {
            $this->addToCart($item->product_id, $item->qty);
        });

        return redirect('sepet');
    }

    public function addToCart($paramProductId, $paramQuantity)
    {
        if (!$paramProductId || !$paramQuantity) {
            return false;
        }

        $productId = $paramProductId;
        $p         = new Product();
        $product   = $p->getProduct($productId);
        $pro       = new Pro($product);
        $myPrice   = new Price();
        $cart      = new Cart(Session::get('cart'));

        $qty = 1;
        if (!empty($paramQuantity) && $paramQuantity > 0) {
            $qty = $paramQuantity;
        }

        $requestQty = $qty;
        if (isset($cart->items[$productId])) {
            $requestQty = $cart->items[$productId]["qty"] + $qty;
        }

        if ($pro->p->stock <= 0) {
            return;
        }

        // Stok miktarı sipariş miktarından küçükse
        // sipariş miktarını stok miktarına eşitle
        if ($pro->p->stock < $requestQty) {
            $qty = $requestQty = $pro->p->stock;

            // sepette ürün varsa sil
            if(isset($cart->items[$productId])){
                $cart->removeItem($productId);
            }
        }
        
        // Ürünü sepete ekle
        $cart->add($pro, $productId, $qty);

        // Sepette promosyonlu ürün varsa fiyata yansıtalım
        if (count($cart->chosenPromotion) > 0) {
            $promotion         = Promotion::where('id', $cart->chosenPromotion['id'])->first();
            $promotionProducts = Products::select('id')
                ->whereIn('id', json_decode($promotion->affectedProducts))
                ->pluck('id')
                ->toArray();

            // Sepette promosyona dahil ürün varsa sepete yansıtalım
            if (in_array($productId, $promotionProducts) && $requestQty <= $promotion->affectedCount) {
                $cart->promotionDiscount += $qty * $promotion->promotionValue;
            }
        }

        // Sepeti kaydet
        Session::put('cart', $cart);
    }

    public function stockControl($orderId)
    {
        $order = Order::with('items')->findOrfail($orderId);

        $p = new Product();

        return $order->items->map(function ($item) use ($p) {
            $product  = $p->getProduct($item->product_id);
            $pro      = new Pro($product);
            $maxStock = $pro->p->stock;

            $response = collect([
                "name"     => $item->name,
                "quantity" => $item->qty,
                "maxStock" => $maxStock,
            ]);

            if ($maxStock <= 0) {
                return $response->put('type', 'stokYok')->all();
            } else if ($maxStock <= $item->qty) {
                return $response->put('type', 'stokYetersiz')->all();
            }
        })->filter()->groupBy('type');
    }
}
