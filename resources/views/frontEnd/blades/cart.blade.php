@extends('frontEnd.layout.checkout')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('headscript')
<script>
gtag('event', 'page_view', {
  send_to: 'AW-825155402',
  ecomm_pagetype: 'cart',
  ecomm_prodid: {!!@json_encode(array_map("strval",array_keys($products)))!!},
  ecomm_totalvalue: {{@$cart->totalPrice}},
});
</script>
@endsection

@section('content')

<div class="container">

    <div class="container_ic">

        <div class="navigasyon">
            <div class="navigasyon_ic">
                <a href="{{url('./')}}">Sanal Market</a>
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span>Sepetim</span>
            </div>
        </div>

        @if(Session::has('cart') && Session::get('cart')->totalQty > 0 )


        <div class="tek_alan">

            <div class="sepet_adimlari">
                <div class="sa_alan saa_aktif">Sepetim</div>
                <div class="sa_alan">Fatura ve Teslimat</div>
                <div class="sa_alan">Ödeme İşlemi</div>
                <div class="sa_alan">Sipariş Onayı</div>
                <div class="clear"></div>
            </div>

            <div class="sepet_icerik_alan">
                <ul class="sia_baslik">
                    <li>Ürün</li>
                    <li>Miktar</li>
                    <li>Birim Fiyatı</li>
                    <li>KDV</li>
                    <li>Toplam</li>
                    <li>Sil</li>
                </ul>

                @foreach($products as $product)
                    <ul class="sia_icerik">
                        <li>
                            @if(!empty($product["item"]->images))
                            <img src="{{$product['item']->baseImg()}}" alt="">
                            @else
                            <img src="{{asset('images/gorsel-hazirlaniyor/detay-slider.jpg')}}" alt="" class="sepet_gorsel">
                            @endif
                        </li>
                        <li><a href="{{url($product["item"]->p->slug)."-p-".$product["item"]->p->id}}" class="sepet_baslik">
                            @if(count($choosenPromotionPros)>0)
                            {{in_array($product["item"]->p->id,$choosenPromotionPros->pluck('id')->toArray()) ? '(Promosyon)' : '' }}
                            @endif
                            {{$product["item"]->p->name}}

                            </a>
                        </li>
                        <li>
                            <input name="qty[{{$product["item"]->p->id}}]" type="text" class="sepet_adet qtyItem" data-available="{{$product['item']->p->stock}}" onkeydown="return controlNumber(event);" value="{{$product["qty"]}}">
                            <a onclick="Cart.update()" class="sepetGuncelle" href="javascript:void(0)"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </li>
                        <li>{{$myPrice->currencyFormat($product["item"]->realPrice)}} ₺</li>
                        <li>% {{$product["item"]->p->tax}}</li>
                        <li>{{$myPrice->currencyFormat($product["item"]->realPrice*$product["qty"])}} ₺</li>
                        <li><a href="{{url('remove/'.$product["item"]->p->id)}}" class="sepet_sil"><i class="fa fa-times" aria-hidden="true"></i></a></li>
                    </ul>
                @endforeach

            </div>
            @if(Session::get('cart')->coupon!=null)
            <div class="coupon">
                @if(Session::get('cart')->freeShipping==1)
                <span>Bu siparişinizde kullanmış olduğunuz hediye çeki nedeniyle kargo ücreti yansıtılmayacaktır.</span><br>
                @endif
                @if(Session::get('cart')->coupon!=null)
                <span>Kullanılan Hediye Çeki Kodu = {{Session::get('cart')->coupon}}</span>
                @endif

            </div>
            @endif

            <div class="sepet_detay">

                <div class="hediye_ceki">
                    <div class="hc_left">
                        <strong>Hediye Çeki Kullanımı</strong>
                        Ödemenizde Hediye Çeki Kodunuzu Kullanın
                    </div>
                    <input name="couponCode" type="text" class="hc_input">
                    <input onclick="couponCode()" type="button" class="hc_buton" value="Kullan">
                </div>

                <ul class="detay_toplam">
                    <li><strong>Ara Toplam</strong> <span>:</span> {{$myPrice->currencyFormat($cart->subTotal)}} ₺</li>
                    @if(Session::get('cart')->coupon!=null)
                    <li><strong>Hediye Çeki İndirimi</strong> <span>:</span> {{$myPrice->currencyFormat(Session::get('cart')->couponDiscount)}} ₺</li>
                    <li><strong>Hediye Çeki İndirimi Dahil Tutar</strong> <span>:</span> {{$myPrice->currencyFormat(Session::get('cart')->couponSubtotal)}} ₺</li>
                    @endif
                    <li><strong>KDV</strong> <span>:</span> {{$myPrice->currencyFormat($cart->taxTotal)}} ₺</li>
                    <li><strong>KDV Dahil</strong> <span>:</span> {{$myPrice->currencyFormat($cart->totalPrice)}} ₺</li>
                    @if(count(Session::get('cart')->chosenPromotion)>0)
                    <li><strong>Promosyon Avantajı</strong> <span>:</span> {{$myPrice->currencyFormat($cart->promotionDiscount)}} ₺</li>
                    <li><strong>Promosyonla Birlikte Kdv Dahil</strong> <span>:</span> {{$myPrice->currencyFormat($cart->totalPrice-$cart->promotionDiscount)}} ₺</li>
                    @endif
                </ul>
                <div class="clear"></div>
            </div>








            @if(count($choosenPromotionPros)>0)
                <div class="sepet_icerik_alan">
                    <div class="promosyon_ic_baslik">Promosyonlu Ürünler</div>

                    <ul class="promosyon_baslik">
                        <li>Ürün</li>
                        <li>Birim Fiyatı</li>
                        <li>KDV</li>
                        <li>KDV Dahil</li>
                        <li></li>
                    </ul>

                    @foreach($choosenPromotionPros as $key => $p)
                        <ul class="promosyon_icerik">
                            <li>
                                @if(!empty($p->images))
                                <img src="{{$myProduct->baseImg($p->images,$p->id)}}" alt="">
                                @else
                                <img src="{{asset('images/gorsel-hazirlaniyor/detay-slider.jpg')}}" alt="" class="sepet_gorsel">
                                @endif
                            </li>
                            <li><a class="sepet_baslik" href="{{url($p->slug.'-p-'.$p->id)}}">{{$p->name}}</a></li>
                            <li>
                                {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withoutTax($p->price,$p->tax_status,$p->tax),$p->discount_type,$p->discount))}} TL
                            </li>
                            <li>{{ $p->tax }}</li>
                            <li>
                                <span style="text-decoration:line-through">{{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($p->price,$p->tax_status,$p->tax),$p->discount_type,$p->discount))}} TL</span>

                                @if(@$cart->chosenPromotion['discountType'] == 'rebateProduct')
                                    {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($p->price,$p->tax_status,$p->tax),$p->discount_type,$p->discount) - @$cart->chosenPromotion['discount'])}} TL
                                @endif

                            </li>
                            <li><a class="promosyon_buton" href="{{url('sepet/promotion/addProduct/'.$p->id)}}"><i class="fa fa-check" aria-hidden="true"></i> Sepete Ekle</a></li>
                        </ul>
                    @endforeach
                </div>
                <a style="display: none;" class="fancybox" id="inline" href="#data"></a>
                <div id="data" style="display:none;max-width: 420px;">
                    <div style="text-align:center;color:#666;">
                        <div>
                            {{$cart->chosenPromotion["label"]}}
                        </div>
                        <img style="width: 150px;" src="{{$myProduct->baseImg($choosenPromotionPros[0]->images,$choosenPromotionPros[0]->id)}}" alt="">
                        <a class="promosyon_buton" href="{{url('sepet/promotion/addProduct/'.$choosenPromotionPros[0]->id)}}">Sepete Ekle</a>
                    </div>
                </div>
            @endif
            @if(count($promotions) > 0)
                <div class="sepet_icerik_alan">
                    <div class="promosyon_ic_baslik">Geçerli Promosyonlar</div>
                    @foreach($promotions as $key => $val)
                    <ul class="gecerli_promosyon_icerik">
                        <li><strong>{{$val['promotion']->name}}</strong></li>
                        <li>{{$val['promotion']->description}}</li>
                        <li>
                            @if(@$cart->chosenPromotion['id']==$val['promotion']->id)
                                <a class="gecerli_promosyon_buton" href="javascript:void(0)"><i class="fa fa-check" aria-hidden="true"></i> Promosyon Seçildi</a>
                            @else
                                <a class="gecerli_promosyon_buton" href="{{url('sepet/usePromotion/'.$val['promotion']->id)}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{@$cart->chosenPromotion['id']==$val['promotion']->id ? 'Promosyon Seçildi' : 'Promosyonu Seç'}}</a>
                            @endif
                        </li>
                    </ul>

                    <div class="clear"></div>
                    @endforeach
                </div>
            @endif

            <div class="sepet_buton_alan">
                <a onclick="Cart.update()" href="javascript:void(0)" class="sepet_guncelle"><i class="fa fa-repeat" aria-hidden="true"></i> Sepeti Güncelle</a>
                <a href="{{url()->previous()}}" class="sepet_devam"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Alışverişe Devam Et</a>
                <a href="{{url('sepet/fatura-teslimat')}}" class="sepet_tamamla"><i class="fa fa-check" aria-hidden="true"></i> Siparişi Tamamla</a>
                <div class="clear"></div>
            </div>
        </div>

        @else
            <div class="sepet_urun_yok">
               	<i class="fa fa-shopping-cart" aria-hidden="true"></i>
               	<br>
                <br>
                <strong>Sepetinizde ürün bulunmuyor!</strong>
            </div>
        @endif

    </div>
    <div class="container_ic">
        @include('frontEnd.include.footerTop')
        <div class="clear"></div>
    </div>

</div>

@endsection

@section('scripts')
    <script>
        var prods = [];
        // Sepette ürün var ise
        @if(Session::has('cart') && Session::get('cart')->totalQty > 0 )

            fbq('track', 'AddToCart', {
                value:{{@$cart->totalPrice}},
                currency: 'TRY',
                content_type: 'product',
                content_ids: {!!@json_encode(array_map("strval",array_keys($products)))!!}
            });

            @if(count($products) > 0)
                @foreach($products as $key => $item)
                    prods.push({
                        'id': '{{$key}}',
                        'price': '{{$item['price']}}',
                        'quantity': '{{$item['qty']}}'
                    });
                @endforeach
            @endif

        @endif

        @if(count(@$choosenPromotionPros)>0 && array_key_exists(@$choosenPromotionPros[0]->id,$cart->items) == false )
            $(document).ready(function(){
                $('a#inline').trigger('click');
            });
        @endif
    </script>
    <!-- Criteo Basket/Cart Tag -->
    <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
    <script type="text/javascript">
        window.criteo_q = window.criteo_q || [];
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
        window.criteo_q.push(
        { event: "setAccount", account: 26770}, // You should never update this line
        { event: "setEmail", email: "" }, // Can be an empty string
        { event: "setSiteType", type: deviceType},
        { event: "viewBasket", item: prods}
        );
    </script>
    <!-- END Criteo Basket/Cart Tag -->

    <?php /*
    <script>
    gtag('event', 'page_view', {'send_to': 'AW-825155402',
    'ecomm_prodid': {!!@json_encode(array_map("strval",array_keys($products)))!!},
    'ecomm_pagetype': 'cart',
    'ecomm_totalvalue': '{{@$cart->totalPrice}}'
    });
    </script>
    */ ?>
@endsection
