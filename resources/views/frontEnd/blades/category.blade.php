@extends('frontEnd.layout.master')

@if(request('page') && intval(request('page')) > 1)
    @php($titlePageNumber = sprintf(' - Sayfa %s', request('page')))
@endif

@section('pageTitle')
    @if(!empty($brandCat->title))
        {{ $brandCat->title . ' | Marketpaketi' . ($titlePageNumber ?? '') }}
    @elseif(isset($brandCatTitle) && $brandCatTitle)
        {{ $brandCatTitle . ($titlePageNumber ?? '') }}
    @elseif(!empty(json_decode($cat->seo,true)['seo_title']))
        {{ json_decode($cat->seo, true)['seo_title'] . ' | Marketpaketi' . ($titlePageNumber ?? '') }}
    @else
        {{ $cat->title . ' | Marketpaketi' . ($titlePageNumber ?? '') }}
    @endif
@endsection

@section('pageDescription')
    @if(!empty($brandCat->description))
       {{ $brandCat->description  . ($titlePageNumber ?? '')  }}
    @elseif(!empty(json_decode($cat->seo,true)['seo_description']))
       {{ json_decode($cat->seo,true)['seo_description'] . ($titlePageNumber ?? '')  }}
    @elseif(isset($brandCatDescription) && $brandCatDescription)
        {{ $brandCatDescription . ($titlePageNumber ?? '')  }}
    @else
        {{ $cat->title.' ürünlerini yüksek kalite - uygun fiyat seçenekleri ile '.$cat->title.' kategorisinden satın alabilirsiniz. '.$cat->title.' ürünleri www.marketpaketi.com.tr\'de!' . ($titlePageNumber ?? '')  }}
    @endif
@endsection

@if(isset($canonical))
    @section('canonical', '<link rel="canonical" href="$canonical"/>' )
@else
    @section('canonical', '<link rel="canonical" href="'.url()->full().'"/>' )
@endif

@section('extraMeta')
    @if($pro->previousPageUrl())
        <link rel="prev" href="{{$pro->currentPage() == 2 ? url()->current() : $pro->previousPageUrl() }}" />
    @endif
    @if($pro->nextPageUrl())
        <link rel="next" href="{{$pro->nextPageUrl()}}" />
    @endif
@endsection

@section('headscript')
<script>
    gtag('event', 'page_view', {
      send_to: 'AW-825155402',
      ecomm_pagetype: 'category'
    });
</script>

@endsection

@section('content')

    <div class="container">

        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
            @foreach($breadCrump as $key => $val){
                "@type": "ListItem",
                "position": "{{$key+1}}",
                "item":
                {
                    "@id": "{{url($val['slug'])}}",
                    "name": "{!!$val['title']!!}"
                }
            },
            @endforeach
            {
                "@type": "ListItem",
                "position": "{{count($breadCrump)+1}}",
                "item":
                {
                    "@id": "{{url($cat->slug.'-c-'.$cat->id)}}",
                    "name": "{!!$cat->title!!}"
                }
            }@if(isset($breadCrumpBrandCat) && $breadCrumpBrandCat),
            {
                "@type": "ListItem",
                "position": "{{count($breadCrump)+2}}",
                "item": 
                {
                    "@id": "{{url($breadCrumpBrandCat['slug'])}}",
                    "name": "{!!$breadCrumpBrandCat['title']!!}"
                }
            }
            @endif]
        }
        </script>

        <div class="container_ic">

            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="{{url('/')}}">Sanal Market</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>

                    @foreach($breadCrump as $link)
                        <a href="{{url($link["slug"])}}">{{$link["title"]}}</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    @endforeach

                    @if(isset($breadCrumpBrandCat) && $breadCrumpBrandCat)
                        <a href="{{url($cat->slug.'-c-'.$cat->id)}}">{{$cat->title}}</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <a href="{{url($breadCrumpBrandCat["slug"])}}">{{$breadCrumpBrandCat["title"]}}</a>
                    @else
                        <span>{{$cat->title}}</span>
                    @endif
                </div>
            </div>

            <div class="filtre_ac">
                <i class="fa fa-align-left" aria-hidden="true"></i>
                <strong>FİLTRELE</strong>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>

            <div class="urun_filtre">

                @if(count($cat->childs)>0)

                <div class="uf_blok">

                    <div class="ufb_baslik">{{$cat->title}}</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            @foreach($cat->childs->sortBy('sort') as $child)
                                <li><a href="{{url($child->slug.'-c-'.$child->id)}}">{{$child->title}}</a></li>
                            @endforeach
                        </ul>

                    </div>

                </div>
                @endif
                <?php /*
                <div class="uf_blok">

                    <div class="ufb_baslik">DİĞER KATEGORİLER</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            @foreach($categories as $c)
                            <li><a href="{{url($c["slug"].'-c-'.$c["id"])}}">{{$c["title"]}}</a></li>
                            @endforeach
                        </ul>

                    </div>

                </div>
                */ ?>
                @if(count($brandsProdCount)>0)

                <div class="uf_blok">

                    <div class="ufb_baslik">TÜM MARKALAR</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            @foreach($brandsProdCount as $br)
                                <li><label><input data-filter="brand" value="{{$br["slug"]}}" {{in_array($br["brand_id"],$filteredBrandIds) ? "checked" : ""}} type="checkbox" class="filtre_chec filterBrand"><span>{{$br["name"]}} ( {{$br["count"]}} )</span></label></li>
                            @endforeach
                        </ul>

                    </div>

                </div>
                @endif


                <div class="uf_blok">

                    <div class="ufb_baslik">FİLTRE SEÇENEKLERİ</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            <li><label><input {{in_array("indirimli",$filtreler) ? 'checked':''}} value="indirimli" type="checkbox" class="filtre_chec filterOpt"><span>Fiyatı Düşen Ürünler ( {{$filterCounts["discounted"]}} )</span></label></li>
                            <li><label><input {{in_array("sponsor",$filtreler) ? 'checked':''}} value="sponsor" type="checkbox" class="filtre_chec filterOpt"><span>Sponsor Ürünler ( {{$filterCounts["sponsor"]}} )</span></label></li>
                            <li><label><input {{in_array("yeni",$filtreler) ? 'checked':''}} value="yeni" type="checkbox" class="filtre_chec filterOpt"><span>Yeni Ürünler ( {{$filterCounts["new"]}} )</span></label></li>
                            <li><label><input {{in_array("kampanyali",$filtreler) ? 'checked':''}} value="kampanyali" type="checkbox" class="filtre_chec filterOpt"><span>Kampanyalı Ürünler ( {{$filterCounts["campaign"]}} )</span></label></li>
                        </ul>

                    </div>

                </div>

                @if(!empty($priceFilterCounts))

                <div class="uf_blok">

                    <div class="ufb_baslik">FİYAT ARALIKLARI</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">

                            @foreach($priceFilterCounts as $k => $v)
                                <li><label><input type="checkbox" value="{{$v['k1']}}" class="filtre_chec filterPrice"><span>{{$v["k3"]}} ({{$v['k2']}})</span></label></li>
                            @endforeach

                        </ul>

                    </div>

                </div>

                @endif


                @if(count($currentFilters))

                <div class="uf_blok">

                    <div class="ufb_baslik <?php /*ufb_renk*/?>">FİYAT ARALIĞI</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            @foreach($currentFilters as $filterkey => $filterval)
                            <li>
                                <span>{{$filterkey}} : {{$filterval}}</span><a onclick="removePrice()" href="javascript:void(0)" class="list_sil"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

                @endif


             
                <div class="uf_blok">

                    <div class="ufb_baslik">STOK DURUMU</div>
                    <div class="scrollbar" id="style-1">
                        <ul class="ufb_icerik force-overflow">
                                <li><label><input value="stokhepsi" type="checkbox" {{in_array("stokhepsi",$filtreler) ? '':'checked'}} type="checkbox" class="filtre_chec filterStock"><span>Stokta Mevcut</span></label></li>
                        </ul>
                    </div>

                    </div>
                    

            </div>

            <div class="urun_liste_alan">
                {{-- <ul class="liste_slider">

                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>

                </ul> --}}

                @if(!empty($brandCat->image) || !empty($cat->image) )
                <div class="liste_slider">
                    @if(!empty($brandCat->image))
                        <img src="{{'https://d151fsz95gwfi2.cloudfront.net/src/uploads/brands-category/'.$brandCat->image}}" alt="{{$cat->title}}">
                    @elseif(!empty($cat->image))
                        <img src="{{'https://d151fsz95gwfi2.cloudfront.net/src/uploads/category/'.$cat->image}}" alt="{{$cat->title}}">
                    @endif
                </div>
                @endif

                <div class="urun_orta_filtre">
                    @if(isset($breadCrumpBrandCat) && $breadCrumpBrandCat)
                        <h1>{{ $breadCrumpBrandCat["title"] }}</h1>
                    @else
                        <h1>{{ $cat->title }}</h1>
                    @endif
                    {{-- <strong>{{$cat->title}}</strong> --}}

                    <div class="uof_alan">

                        <select name="siralama" class="uof_select">
                            <option value="">Fiyata Göre Sırala</option>
                            <option {{app('request')->input('siralama')=='artanfiyat' ? 'selected' : ''}} value="artanfiyat">Artan Fiyat</option>
                            <option {{app('request')->input('siralama')=='azalanfiyat' ? 'selected' : ''}} value="azalanfiyat">Azalan Fiyat</option>
                        </select>
                        <?php /*
                        <select class="uof_select">
                            <option>30 Ürün Sırala</option>
                        </select>
                        */ ?>
                    </div>
                </div>


                <div class="urun_liste">
                @inject('helpersnew', 'App\Helpers\HelpersNew')
                    @if($pro)
                
                    @foreach($pro as $p)
                    @php $p = $helpersnew->prdctDiscountDateCntrl($p); @endphp
                        <div class="liste_urun">
                            @if($p->discount_type!=0 && $p->discount_type!=null)
                                <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($p->discount,$p->discount_type,$p->price)}}</strong>indirim</div>
                            @endif
                            <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_gorsel"><img class="lazy" data-src="{{$myProduct->baseImg($p->images,$p->id)}}" alt="{{$p->name}}"></a>

                            <div class="urun_urun_ad">
                                <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_adi_ic">{{$p->name}}</a>
                                @if($p->stock>=1)
                                <a class="urun_sepet" onclick="Cart.add('{{$p->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                                @else
                                <a href="javascript:void(0)" class="stokta_yok urun_sepet"> <i class="fa fa-envelope-o" aria-hidden="true"></i> <span>Gelince Haber Ver</span> </a>
                                @endif
                            </div>

                            <div class="urun_fiyat">
                            @if($p->stock>=1)

                                @if($p->discount_type!=0 && $p->discount_type!=null)
                                    <strong>{{$myPrice->currencyFormat($myPrice->withTax($p->price,$p->tax_status,$p->tax))}} TL</strong>
                                @endif
                                {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($p->price,$p->tax_status,$p->tax),$p->discount_type,$p->discount))}} TL

                            @else
                                Stokta Yok
                            @endif
                            </div>
                        </div>
                    @endforeach

                    @endif

                    <div class="clear"></div>

                </div>

                @if($pro)
                    @include('pagination.custom',['paginator'=>$pro])
                @endif

                @if(!empty($cat->content) && request('page', 1) == 1)
                    <div class="liste_text">

                        <div class="devami_icin">
                            {!! $cat->content !!}
                        </div>

                    </div>
                @endif
            </div>

            <div class="clear"></div>




        </div>

        <?php /*

        <div class="ana_orta_banner">
            <div class="aob_ic">

                <a href="{{$settings["banners"][1]["link"]}}" {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img src="{{asset('src/uploads/banner/'.$settings["banners"][1]["image"])}}" alt="{{$settings["banners"][1]["alt"]}}"></a>

                <a href="{{$settings["banners"][1]["link"]}}" {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img src="{{asset('src/uploads/banner/'.$settings["banners"][2]["image"])}}" alt="{{$settings["banners"][2]["alt"]}}"></a>

                <a href="{{$settings["banners"][1]["link"]}}" {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img src="{{asset('src/uploads/banner/'.$settings["banners"][3]["image"])}}" alt="{{$settings["banners"][3]["alt"]}}"></a>

                <a href="{{$settings["banners"][1]["link"]}}" {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link2"><img src="{{asset('src/uploads/banner/'.$settings["banners"][4]["image"])}}" alt="{{$settings["banners"][4]["alt"]}}"></a>

                <a href="{{$settings["banners"][1]["link"]}}" {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link2"><img src="{{asset('src/uploads/banner/'.$settings["banners"][5]["image"])}}" alt="{{$settings["banners"][5]["alt"]}}"></a>

                <div class="clear"></div>
            </div>
        </div>



        <div class="alan">

            <strong class="alan_baslik">KATEGORİLER</strong>

            <div class="alan_ic">

                <ul class="ana_kategori">

                    @foreach($categories as $category)

                    <li>
                        <a href="{{url($category['slug'].'-c-'.$category['id'])}}" class="ak_alan">
                            <img src="{{secure_asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">{{$category['title']}}</span>
                        </a>
                    </li>

                    @endforeach

                </ul>

            </div>

        </div>


        */ ?>

        <div class="alan ap_bg">

            <strong class="alan_baslik">AVANTAJ PAKETİ</strong>

            <div class="alan_ic">
            @inject('helpersnew', 'App\Helpers\HelpersNew')
                @foreach($popularProducts as $pp)
                @php $pp = $helpersnew->prdctDiscountDateCntrl($pp); @endphp
                    <div class="urun">

                        @if($pp->discount_type!=0 && $pp->discount_type!=null)
                            <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($pp->discount,$pp->discount_type,$pp->price)}}</strong>indirim</div>
                        @endif

                        <a href="{{url($pp->slug.'-p-'.$pp->id)}}" class="urun_gorsel"><img src="{{$myProduct->baseImg($pp->images,$pp->id)}}" alt="{{$pp->name}}"></a>

                        <div class="urun_urun_ad">
                            <a class="urun_adi_ic">{{$pp->name}}</a>
                            <a class="urun_sepet" onclick="Cart.add('{{$pp->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            @if($pp->discount_type!=0 && $pp->discount_type!=null)
                                <strong>{{$myPrice->currencyFormat($myPrice->withTax($pp->price,$pp->tax_status,$pp->tax))}} TL</strong>
                            @endif
                            {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($pp->price,$pp->tax_status,$pp->tax),$pp->discount_type,$pp->discount))}} TL
                        </div>

                    </div>

                @endforeach

                <div class="clear"></div>

            </div>

        </div>



        <div class="container_ic">

            @include('frontEnd.include.footerTop')

            <div class="clear"></div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Criteo Category / Listing Tag -->
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
 { event: "setAccount", account: 26770}, // You should never update this line
 { event: "setEmail", email: "" }, // Can be an empty string
 { event: "setSiteType", type: deviceType},
 { event: "viewList", item: {{$pro->pluck('id')}} });


    $(".filterStock").on("click", function(e) {
        e.preventDefault(), $this = $(this);
        var t = window.location.href, n = url("?filtreler", t);
        void 0 != n ? $filtrerArr = n.split(",") : $filtrerArr = [], this.checked ? jQuery.inArray($this.val(), $filtrerArr) == -1 && $filtrerArr.push($this.val()) : $filtrerArr = jQuery.grep($filtrerArr, function(e) {
            return e != $this.val()
        });

        if($(this).attr('checked')){
        var i = $filtrerArr.join(",") ? "" : $filtrerArr.join(",");
   
        "" == i ? (newUrl = removeURLParameter(t, "filtreler"), newUrl = removeURLParameter(newUrl, "page")) : (newUrl = updateQueryStringParameter(t, "filtreler", i), newUrl = removeURLParameter(newUrl, "page")), window.location.replace(newUrl);
        }else{
            var i = 'stokhepsi';
   
            "" == i ? (newUrl = removeURLParameter(t, "filtreler"), newUrl = removeURLParameter(newUrl, "page")) : (newUrl = updateQueryStringParameter(t, "filtreler", i), newUrl = removeURLParameter(newUrl, "page")), window.location.replace(newUrl);

        }
    });
</script>
<!-- END Criteo Category / Listing Tag -->
@endsection
