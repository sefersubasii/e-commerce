@extends('frontEnd.layout.master')

@if(isset($title))
    @section('pageTitle', $title)
@endif

@if(isset($canonical))
    @section('canonical', '<link rel="canonical" href="$canonical"/>' )
@else
    @section('canonical', '<link rel="canonical" href="'.url()->full().'"/>' )
@endif

@if(isset($description))
    @section('pageDescription', htmlspecialchars($description))
@endif


@section('headscript')
<script>
    gtag('event', 'page_view', {
      send_to: 'AW-825155402',
      ecomm_pagetype: 'product',
      ecomm_prodid: '{{$p->p->id}}',
      ecomm_totalvalue: '{{number_format($p->p->final_price, 2)}}',
      ecomm_category: '{{@$breadCrump[0]["title"]}}'
    });
</script>
@endsection

@section('content')
    <div class="container">
        <script type="application/ld+json">
        {
         "@context": "http://schema.org",
         "@type": "BreadcrumbList",
         "itemListElement":
         [
            @php($breadIndex = 1)
            @foreach($breadCrump as $key => $val)
                {
                    "@type": "ListItem",
                    "position": "{{$key+1}}",
                    "item":
                    {
                        "@id": "{{url($val['slug'])}}",
                        "name": "{!!$val['title']!!}"
                    }
                }
                @if(count($breadCrump) != $breadIndex) , @endif
                @php($breadIndex++)
             @endforeach

             @if(count($breadCrump) > 0) , @endif

             @if($p->p->brand)
                 {
                   "@type": "ListItem",
                   "position": "{{count($breadCrump)+1}}",
                   "item":
                   {
                    "@id": "{{url($p->p->brand->slug.'/'.end($breadCrump)['slug'])}}",
                    "name": "{!!$p->p->brand->name." ".end($breadCrump)['title']!!}"
                    }
                  }
            @endif
         ]
        }
        </script>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org/",
            "@type": "Product",
            "name": "{{ $p->name }}",
            "image": "{{ $myProduct->baseImg($p->p->images, $p->id) }}",
            "description": "{{ strip_tags($description) }}",
            "sku": "{{ $p->p->stock_code }}",

            @if($p->p->brand)
                "brand": {
                    "@type": "Thing",
                    "name": "{{ $p->p->brand->name }}"
                },
            @endif

            @if($p->p->reviews && $p->p->reviews->count())
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "bestRating": "{{ $p->p->reviews->max('rating') }}",
                    "ratingCount": "{{ $p->p->reviews->count() }}",
                    "ratingValue": "5"
                    @if($p->p->reviews->count() > 0)
                        ,"reviewCount": "{{ $p->p->reviews->count() }}"
                    @endif
                },
                "review": [
                    @php($reviewIndex = 1)
                    @foreach ($p->p->reviews as $review)
                        {
                            "@type": "Review",
                            "reviewRating": {
                              "@type": "Rating",
                              "ratingValue": "{{ $review->rating }}",
                              "bestRating": "5",
                              "worstRating": "1"
                            },
                            "author": {
                              "@type": "Person",
                              "name": "{{ $review->author }}"
                            }
                        }
                        @if($p->p->reviews->count() != $reviewIndex),@endif
                        @php($reviewIndex++)
                    @endforeach
                ],
            @endif

            "mpn": "{{ $p->p->stock_code }}",
            "offers": {
                "@type": "Offer",
                "priceCurrency": "TRY",
                "price": "{{ number_format($p->p->final_price, 2) }}",
                "availability": "http://schema.org/{{ ($p->p->stock > 0 ? 'InStock' : 'OutOfStock') }}",
                "url": "{{ request()->url() }}"
            }
        }
        </script>
        <div class="container_ic">
            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="{{url('./')}}">Sanal Market</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    @foreach($breadCrump as $item)
                        <a href="{{url($item["slug"])}}">{{$item["title"]}}</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    @endforeach
                    
                    @if($p->p->brand)
                        <a href="{{ url($p->p->brand->slug.'/'.end($breadCrump)["slug"])}}">{{$p->p->brand->name." ".end($breadCrump)["title"]}}</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    @endif
                    <span>{{$p->name}}</span>
                </div>
            </div>
            <div class="detay_left">
                <div id="detay_slider" class="owl-carousel">
                    @if(!empty($p->images))
                        @foreach($p->images as $key => $value)
                            <div class="item">
                                <a class="detay_buyutec" href="{{ $p->getCdnImage($p->id, $value) }}" data-fancybox="images" title="">
                                	<img data-src="{{ $p->getCdnImage($p->id, $value) }}" class="detay_slider_gorsel lazyOwl" alt="{{ $p->name }}">
                                </a>
                            </div>
                        @endforeach
                    @else
                    <div class="item">
                        <a class="detay_buyutec" href="{{asset('images/gorsel-hazirlaniyor/detay-slider.jpg')}}" data-fancybox="images" title="">
                        	<img data-src="{{asset('images/gorsel-hazirlaniyor/detay-slider.jpg')}}" class="detay_slider_gorsel lazyOwl" alt="{{ $p->name }}">
                        </a>
                    </div>
                    @endif
                </div>

                <div id="detay_slider2" class="owl-carousel">
                    @if(!empty($p->images))
                        @foreach($p->images as $key => $value)
                            <div class="item"><img  data-src="{{ $p->getCdnMinImage($p->id, $value) }}" class="dsg_kucuk lazyOwl" alt="{{ $p->name }}"></div>
                        @endforeach
                    @else
                    <div class="item"><img data-src="{{asset('images/gorsel-hazirlaniyor/detay-slider.jpg')}}" class="dsg_kucuk lazyOwl" alt="{{ $p->name }}"></div>
                    @endif
                </div>
            </div>
            <div class="detay_right">
                <h1 class="detay_baslik">{{$p->name}}</h1>
                @if($p->p->brand)
                <div itemscope="itemscope" itemtype="http://schema.org/Brand">
                    <span itemprop="name" content="{{$p->p->brand->name}}"></span>
                </div>
                <a href="{{url($p->p->brand->slug)}}" class="detay_kategori">{{$p->p->brand->name}}</a>
                @endif
				<div class="stok_kod">Stok Kodu : {{$p->p->stock_code}}</div>
                <div class="fiyat_alani">
                    @if($p->discount_type!=0 && $p->discount_type!=null)
                        <div class="indirim"> %{{$p->rebatePercent()}} <span>indirim</span></div>
                    @endif
                    <div class="fiyat_ic">
                        @if($p->discount_type!=0 && $p->discount_type!=null)
                        <div class="eski_fiyat">{{$p->tl($p->withTax())}} TL</div>
                        @endif
                        <div class="yeni_fiyat">{{$p->tl($p->realPrice())}} TL <span> ( KDV Dahil ) @if($p->package>0)&nbsp; /@endif</span>
                            @if($p->package>0)
                            <strong class="adet_fiyat">{{$p->tl($p->realPrice()/$p->package)}} TL / Adet</strong>
                            @endif
                        </div>
                    </div>

                    @if(count($p->stars))
                        <div class="yildiz">
                            @for($i=1; $i<=$p->stars; $i++)
                                <i class="fa fa-star" aria-hidden="true"></i>
                            @endfor

                            @if(is_float($p->stars))
                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                            @endif

                            @for($i=1; $i<=5-ceil($p->stars); $i++)
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            @endfor


                        </div>
                    @endif
                    <div class="clear"></div>
                </div>
                @if($p->p->stock<=0)
                <form id="stockNotification" action="">
                <div class="stokta_yok_form">
                        <span>
                            @if(Auth::guard('members')->check()==true)
                                Email adresiniz ile stok bilgisi güncellendiğinde haberdar olabilirsiniz.
                            @else
                                Üye girişi yaparak email adresiniz ile stok bilgisi güncellendiğinde haberdar olabilirsiniz.
                            @endif
                        </span>
                        <input type="hidden" name="pId" value="{{$p->p->id}}">
                        <a style="width:190px" href="javascript:void(0)" onclick="stockNotification();" class="syf_buton"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gelince Haber Ver</a>
                        <div class="clear"></div>
                </div>
                </form>
                @endif
                <div class="buton_alan">
                    @if($p->p->stock>0)
                        <div class="detay_adet"><input type="text" id="qty" min="1" class="detay_adet_input" onkeydown="return controlNumber(event);" data-available="{{$p->p->stock}}" value="1">{{$p->p->stockTypeString}}</div>
                        <a onclick="Cart.add('{{$p->id}}',$('#qty').val(),this)" href="javascript:void(0)" class="detay_sepete_ekle_buton"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Sepete Ekle</a>
                        <a onclick="Cart.quick('{{$p->id}}',1)" href="javascript:void(0)" class="detay_hemen_al_buton"><i class="fa fa-angle-right" aria-hidden="true"></i> Hemen Al</a>

                        @if($p->p->wholesale)
                            <div onclick="showWholeslaeForm()" class="wholesale-button">
                                <i class="fa fa-cube" aria-hidden="true"></i>
                                Toptan Fiyat İste
                            </div>
                            <div class="clear"></div>
                        @endif
                    @else
                        <div class="stokta_yok_buton"><i class="fa fa-exclamation" aria-hidden="true"></i> Tükendi</div>
                    @endif
                    <div class="clear"></div>
                    @if($p->p->stock>0)
                        <div class="kargo_sure"></div>
                    @endif
                </div>
                @if($p->p->stock>0)
                <div class="detay_kargo_bilgi">
                    {{-- @if(date('H:i') < $shippingCountDown->format('H:i'))
                        <img data-src="{{asset('images/ayni-gun-kargo.png')}}" alt="" class="dkb_etiket lazy">
                    @endif --}}

                    @if($p->realPrice()>@$freeShippingLimit)
                        <img data-src="{{asset('images/bedava-kargo.png')}}" alt="Bedava Kargo" class="dkb_etiket lazy">
                    @endif

                    @if(count($activeButtons)>0)
                        @foreach($activeButtons as $ab)
                            <img data-src="{{url('src/uploads/productButton/descriptions/'.$ab)}}" alt="detay düğme" class="dkb_etiket lazy">
                        @endforeach
                    @endif
                    <div class="clear"></div>
                </div>
                @endif
                <div class="detay_paylas">
                    <div id="share" class="addthis_inline_share_toolbox"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        @if(count($p->relateds)>0)
        <div class="alan ">
            <strong class="alan_baslik">Bu Ürüne Bakanlar, Bunlara da Baktılar</strong>
            <div class="alan_ic">
                @foreach($relatedProds as $related)
                <div class="urun_alti">
                    @if($related->discount_type!=0 && $related->discount_type!=null)
                    <div class="urun_indirim2"><strong>%{{$related->rebatePercent()}}</strong>indirim</div>
                    @endif
                    <a href="{{url($related->p->slug.'-p-'.$related->p->id)}}" class="urun_gorsel urun_alti_gorsel">
                        @if(!empty($related->images))
                            <img class="lazy" data-src="{{$related->baseImg()}}" alt="{{$related->name}}">
                        @else
                            <img class="lazy" data-src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt="{{$related->name}}">
                        @endif
                    </a>

                    <div class="urun_alti_ad">
                        <div class="urun_alti_ad_ic">{{$related->name}}</div>
                        <a onclick="Cart.add('{{$related->id}}',1,this)" href="javascript:void(0)" class="urun_sepet"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        @if($related->discount_type!=0 && $related->discount_type!=null)
                        <strong>{{$related->tl($related->withTax())}} TL</strong>
                        @endif
                        {{$p->tl($related->realPrice())}} TL
                    </div>

                </div>
                @endforeach
                <div class="clear"></div>
            </div>
        </div>
        @endif

        <div class="tab">
            <div class="tua">
                <span class="tua_link"><a href="#tua1"><i class="fa fa-barcode" aria-hidden="true"></i> Ürün Bilgisi</a></span>
                <span class="tua_link"><a href="#tua2"><i class="fa fa-comments" aria-hidden="true"></i> Ürün Yorumları </a></span>
                <span class="tua_link"><a href="#tua3"><i class="fa fa-clone" aria-hidden="true"></i> Benzer Ürünler</a></span>
                <span class="tua_link"><a href="#tua4"><i class="fa fa-external-link" aria-hidden="true"></i> Önerileriniz</a></span>
            </div>

            <div class="tua_container">
                <div id="tua1" class="tua_content">

                    {!! $p->content !!}

                </div>
                <div id="tua2" class="tua_content">
                    <div class="musteri_yorumlari_left">
                        <form id="reviewForm" action="">
                            <input type="text" name="name" placeholder="Ad Soyad" class="myl_input req">
                            <select name="rating" id="" class="myl_input">
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                            <textarea name="review" placeholder="Mesaj" class="myl_text req"></textarea>
                            <input type="hidden" name="pid" value="{{$p->id}}">
                            <a onclick="reviewSubmit()" href="javascript:void(0)" class="myl_buton"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gönder</a>
                        </form>
                        <!--<div class="yorum_yap">Yorum yapabilmek için <a href="#">Üye Ol</a>un yada <a href="#">Giriş Yap</a>ın.</div>-->
                    </div>
                    <div class="musteri_yorumlari_right" id="style-1">
                        @if(count($p->reviews))
                            @foreach($p->reviews as $review)
                                <div class="myr_alan">
                                    <div class="myr_baslik">
                                        <strong>{{ Str::title($review->author) }}</strong>
                                    </div>
                                    <div class="myr_icerik">
                                        {{$review->text}}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span>Bu ürüne ait yorum bulunmuyor.</span>
                        @endif
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="tua3" class="tua_content">
                @inject('helpersnew', 'App\Helpers\HelpersNew')
                    @if(count($similarProds)>0)
                        @foreach($similarProds as $similar)
                            @php $similar = $helpersnew->prdctDiscountDateCntrl($similar); @endphp
                            <div class="yatay_urun">
                                <a href="{{url($similar->p->slug.'-p-'.$similar->p->id)}}" class="yatay_urun_gorsel">
                                    @if(!empty($similar->images))
                                        <img class="lazy" data-src="{{ $similar->baseImg() }}" alt="{{$similar->name}}">
                                    @else
                                        <img class="lazy" data-src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt="{{$similar->name}}">
                                    @endif
                                </a>
                                <div class="yatay_urun_urun_ad">
                                    <a href="{{url($similar->p->slug.'-p-'.$similar->p->id)}}" class="yatay_urun_adi_ic">{{$similar->name}}</a>
                                    <a onclick="Cart.add('{{$similar->id}}',1,this)" href="javascript:void(0)" class="yatay_ua_icon"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                                </div>
                                <div class="yatay_urun_fiyat">
                                    @if($similar->discount_type!=0 && $similar->discount_type!=null)
                                    <strong>{{$similar->tl($similar->withTax())}} TL</strong>
                                    @endif
                                    {{$p->tl($similar->realPrice())}} TL
                                </div>
                                @if($similar->discount_type!=0 && $similar->discount_type!=null)
                                <div class="yatay_urun_indirim"><strong>%{{$similar->rebatePercent()}}</strong>indirim</div>
                                @endif
                                <div class="clear"></div>
                            </div>
                        @endforeach
                    @endif
                    <div class="clear"></div>
                </div>
                <div id="tua4" class="tua_content">
                    <div class="musteri_yorumlari_left">
                        <form id="suggestionForm" action="">
                            <input type="text" name="name" placeholder="Ad Soyad" class="myl_input req">
                            <input type="text" name="email" placeholder="E Mail" class="myl_input req">
                            <textarea name="body_message" placeholder="Mesaj" class="myl_text req"></textarea>
                            <input type="hidden" name="product" value="{{$p->name}}">
                            <a href="javascript:void(0)" onclick="suggestionSubmit()" class="myl_buton"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gönder</a>
                        </form>
                    </div>
                    <div class="musteri_yorumlari_right_bilgi">
                        "Bu ürünün fiyat bilgisi, resim, ürün açıklamalarında ve diğer konularda yetersiz gördüğünüz noktaları öneri formunu kullanarak tarafımıza iletebilirsiniz.
                        <br>
                        Görüş ve önerileriniz için teşekkür ederiz."
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="container_ic">
            @include('frontEnd.include.footerTop')
            <div class="clear"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" defer>
    // startKargoTimer('{{ $shippingCountDown }}');

    @if($p->p->wholesale)
        async function showWholeslaeForm(){
            const { value: formValues } = await Swal.fire({
                title: '<i class="fa fa-cube" style="position:absolute;top:7px; left: -20px;"></i>&nbsp;&nbsp;Toptan Fiyat İste',
                html:`
                    <form id="wholesaleForm" style="text-align:left;" required>
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $p->p->id }}">
                        <input type="text" name="name" class="swal2-input" placeholder="Adınızı giriniz" data-error-message="Adınızı giriniz..." required>
                        <input type="text" name="phone" class="numeric phoneMask swal2-input" placeholder="Telefonunuzu giriniz..." data-error-message="Telefonunuzu giriniz..." required>
                        <input type="text" name="quantity" class="numeric swal2-input" placeholder="Kaç adet satın almak istiyorsunuz?" data-error-message="Kaç adet satın almak istiyorsunuz?" required>
                    </form>
                `,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-check"></i>&nbsp;Fiyat İste',
                showCancelButton: true,
                cancelButtonText: '<i class="fa fa-times"></i>&nbsp;Kapat',
                preConfirm: () => {
                    let wholesaleForm = $('#wholesaleForm');

                    let formValidated = false;
                    wholesaleForm.find('.swal2-input').each(function(index, element){
                        let $element = $(element);

                        if(!$element.is(':valid')){
                            let message = $element.data('error-message');
                            Swal.showValidationMessage(message);
                            $element.css('border-color', '#F44336');

                            return formValidated = false;
                        }else{
                            $element.css('border-color', '#d9d9d9');
                            formValidated = true;
                        }
                    });

                    if(formValidated){
                        let inputData = wholesaleForm.serialize();

                        $.post('{{ route("wholesale") }}', inputData, function(response){
                            if(response.hasOwnProperty('success') && response.success == true){
                                Swal.fire({
                                    title: 'Tebrikler',
                                    text: 'Toptan Fiyat İstek formunuz iletilmiştir en kısa zamanda sizinle iletişime geçeceğiz.',
                                    type: 'success',
                                    confirmButtonText: 'Tamam'
                                });
                            }else {
                                Swal.fire({
                                    title: 'Hata',
                                    text: 'İşlemler sırasında bir hata oluştu. Lütfen bizimle iletişime geçiniz!',
                                    type: 'error',
                                    confirmButtonText: 'Tamam'
                                });
                            }
                        }).fail(function(){
                            Swal.fire({
                                title: 'Hata',
                                text: 'İşlemler sırasında bir hata oluştu. Lütfen bizimle iletişime geçiniz!',
                                type: 'error',
                                confirmButtonText: 'Tamam'
                            });
                        });
                    }
                }
            });
        }

        $(document).on("input", ".phoneMask", function() {
            $(this).mask("0 (zdd) ddd dd dd");
        });

        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g,'');
        });
    @endif
</script>

<script defer>
    fbq('track', 'ViewContent', {
        value: '{{ number_format($p->p->final_price, 2) }}',
        currency: 'TRY',
        content_ids: '{{ $p->p->id }}',
        content_type: 'product',
    });
</script>

{{-- <!-- Criteo Product Tag -->
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true" defer></script>
<script type="text/javascript" defer>
    window.onload = function(){
        window.criteo_q = window.criteo_q || [];
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
        window.criteo_q.push(
         { event: "setAccount", account: 26770}, // You should never update this line
         { event: "setEmail", email: "" }, // Can be an empty string
         { event: "setSiteType", type: deviceType},
         { event: "viewItem", item: "{{$p->p->id}}" });
    }
</script> --}}
@endsection
