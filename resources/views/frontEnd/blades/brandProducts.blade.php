@extends('frontEnd.layout.master')

@if(request('page') && intval(request('page')) > 1)
    @php($titlePageNumber = sprintf(' - Sayfa %s', request('page')))
@endif

@if(!empty(json_decode($brand->seo,true)['seo_title']))
    @section('pageTitle', json_decode($brand->seo,true)['seo_title'].' | www.marketpaketi.com.tr' . ($titlePageNumber ?? ''))
@else
    @section('pageTitle', $brand->name.' Ürünleri En Uygun Fiyatlarla marketpaketi\'nde' . ($titlePageNumber ?? ''))
@endif

@if(!empty(json_decode($brand->seo,true)['seo_description']))
    @section('pageDescription', json_decode($brand->seo,true)['seo_description'] . ($titlePageNumber ?? ''))
@else
    @section('pageDescription', 'Kaliteli ve orjinal '.$brand->name.' ürünlerinde hızlı kargo ve uygun fiyatlarla  marketpaketi.com.tr üzerinden güvenli bir şekilde sahip olabilirsiniz.' . ($titlePageNumber ?? ''))
@endif

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

@section('content')

    <div class="container">

        <script type="application/ld+json">
        {
         "@context": "http://schema.org",
         "@type": "BreadcrumbList",
         "itemListElement":
         [
            {
               "@type": "ListItem",
               "position": "1",
               "item":
               {
                "@id": "{{url($brand->slug)}}",
                "name": "{!!$brand->name!!}"
                }
            }
         ]
        }
        </script>

        <div class="container_ic">

            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="{{url('./')}}">Sanal Market</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span>{{$brand->name}}</span>
                </div>
            </div>

            <div class="filtre_ac">
                <i class="fa fa-align-left" aria-hidden="true"></i>
                <strong>FİLTRELE</strong>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>


            <div class="urun_filtre">

          

                    <div class="uf_blok">

                        <div class="ufb_baslik">TÜM MARKALAR</div>

                        <div class="scrollbar" id="style-1">
                            <ul class="ufb_icerik force-overflow">
                                    <li><label><input data-filter="brand" value="{{$brand["slug"]}}" checked type="checkbox" class="filtre_chec filterBrand"><span>{{$brand["name"]}}</span></label></li>
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
<?php /*
                <ul class="liste_slider">

                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>

                </ul>
*/ ?>

                @if(!empty($brand->image) )
                <div class="liste_slider">
                    <img src="{{asset('src/uploads/brands/'.$brand->image)}}" alt="{{$brand->title}}">
                </div>
                @endif

                <div class="urun_orta_filtre">
                    <h1>{{$brand->name}}</h1>

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
                            <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_gorsel"><img src="{{$myProduct->baseImg($p->images,$p->id)}}" alt="{{$p->name}}"></a>

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
                <?php /*
                <div class="sayfalama">

                    <a href="#" class="say"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                    <a href="#" class="say">1</a>
                    <a href="#" class="say say_aktif">2</a>
                    <a href="#" class="say">3</a>
                    <a href="#" class="say">4</a>
                    <a href="#" class="say">5</a>
                    <a href="#" class="say">6</a>
                    <a href="#" class="say">7</a>
                    <a href="#" class="say">8</a>
                    <a href="#" class="say">9</a>
                    <a href="#" class="say"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

                </div>
                */ ?>


                @if(!empty($brand->extra_content) && request('page', 1) == 1)
                    <div class="liste_text">
                        <div class="devami_icin">
                            {!! $brand->extra_content !!}
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

       

        

        <div class="container_ic">

            @include('frontEnd.include.footerTop')

            <div class="clear"></div>
        </div>





    </div>

@endsection

@section('scripts')
<script type="text/javascript">
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
    })

</script>
<!-- END Criteo Category / Listing Tag -->
@endsection
