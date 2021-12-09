@extends('frontEnd.layout.master')
@section('pageTitle', @$settings['seo']->seo_title)
@section('pageDescription', @$settings['seo']->seo_description)
@if(isset($canonical))
    @section('canonical', '<link rel="canonical" href="'.$canonical.'"/>' )
@else
    @section('canonical', '<link rel="canonical" href="'.url()->current().'"/>' )
@endif
@section('content')
@inject('helpersnew', 'App\Helpers\HelpersNew')
    <div class="slider_alan">
        <div class="slider">
            <div id="sync1" class="owl-carousel">
                @foreach($settings["slider"] as $slide)
                    <div class="item">
                        <a href="{{$slide->link}}" class="slider_gorsel" style="display:block;">
                            <img class="lazyOwl slider_gorsel" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/slider/'.$slide->image)}}" alt="{{ $slide->name }}">
                        </a>
                    </div>
                @endforeach
                {{-- @foreach($settings["slider"] as $slide)
                    <div class="item">
                        <a href="{{$slide->link}}" class="slider_gorsel" style="background:url('{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/slider/'.$slide->image)}}') top center no-repeat; display:block;"></a>
                    </div>
                @endforeach --}}
            </div>
            <div id="sync2" class="owl-carousel">
                @foreach($settings["slider"] as $slide)
                    <div class="item">
                        <img data-src="{{'https://d151fsz95gwfi2.cloudfront.net/src/uploads/slider/'.$slide->imageCover}}" class="sg_kucuk lazyOwl" alt="">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mobil_slider">
            @foreach($settings["mobilSlider"] as $mslide)
                <a class="ms_gorsel" href="{{$mslide->link}}">
                    <img style="height:calc(100vw / 2)!important;" class="lazyOwl" data-src="https://d151fsz95gwfi2.cloudfront.net/src/uploads/slider/{{ $mslide->image }}" alt="">
                </a>
            @endforeach
        </div>
        <?php /*
        @if(count($sponsorProducts)>0)
            <div class="gunun_firsati">
                <strong class="gf_baslik">GÜNÜN FIRSATI</strong>
                @if(@$sponsorProducts[0]->discount_type!=0 && @$sponsorProducts[0]->discount_type!=null)
                    <div class="gf_indirim"><strong>%{{$myProduct->rebatePercent($sponsorProducts[0]->discount,$sponsorProducts[0]->discount_type,$sponsorProducts[0]->price)}}</strong>indirim</div>
                @endif
                <a href="{{url($sponsorProducts[0]->slug.'-p-'.$sponsorProducts[0]->id)}}" class="gf_gorsel"><img src="{{$myProduct->baseImg($sponsorProducts[0]->images,$sponsorProducts[0]->id)}}" alt=""></a>
                <div class="gf_urun_ad">
                    <a href="{{url($sponsorProducts[0]->slug.'-p-'.$sponsorProducts[0]->id)}}" class="gf_urun_adi_ic">{{$sponsorProducts[0]->name}}</a>
                    <a href="{{url($sponsorProducts[0]->slug.'-p-'.$sponsorProducts[0]->id)}}" class="gf_sepet"> <i class="fa fa-search" aria-hidden="true"></i> <span>incele</span> </a>
                </div>
                <div class="gf_fiyat">
                    @if(@$sponsorProducts[0]->discount_type!=0 && @$sponsorProducts[0]->discount_type!=null)
                    <strong>{{$myPrice->currencyFormat($myPrice->withTax($sponsorProducts[0]->price,$sponsorProducts[0]->tax_status,$sponsorProducts[0]->tax))}} TL</strong>
                    @endif
                    {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($sponsorProducts[0]->price,$sponsorProducts[0]->tax_status,$sponsorProducts[0]->tax),$sponsorProducts[0]->discount_type,$sponsorProducts[0]->discount))}} TL
                </div>
            </div>
        @endif
        */ ?>
    </div>
    <div class="container">
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "{{url('/')}}",
            "potentialAction": {
              "@type": "SearchAction",
              "target": "{{url('/search')}}?&q={query}",
              "query-input": {
                "@type": "PropertyValueSpecification",
                "valueRequired": true,
                "valueMaxlength": 150,
                "valueName": "query"
               }
            }
        }
        </script>
        <div class="container_ic">
            <div class="ana_vitrin">
                <div class="ana_vitrin_tab">
                    <strong class="avt_link"><a href="#avt1" >Çok Satanlar</a></strong>
                    <strong class="avt_link"><a href="#avt2" >Yeni Ürünler</a></strong>
                    <strong class="avt_link"><a href="#avt3" >İndirimli Ürünler</a></strong>
                    <?php /*<strong class="avt_link"><a href="#avt4" >Çok Satanlar</a></strong>*/?>
                </div>
                <div class="ana_vitrin_tab_icerik_alan">
                    <div id="avt1" class="ana_vitrin_tab_icerik">
                        @foreach($homeProducts as $hp)
                        @php $hp = $helpersnew->prdctDiscountDateCntrl($hp); @endphp
                            <div class="urun">
                                @if($hp->discount_type!=0 && $hp->discount_type!=null)
                                    <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($hp->discount,$hp->discount_type,$hp->price)}}</strong>indirim</div>
                                @endif
                                <a href="{{url($hp->slug.'-p-'.$hp->id)}}" class="urun_gorsel"><img class="lazy" data-src="{{$myProduct->baseImg($hp->images,$hp->id)}}" alt="{{$hp->name}}"></a>
                                <div class="urun_urun_ad">
                                    <a href="{{url($hp->slug.'-p-'.$hp->id)}}" class="urun_adi_ic">{{$hp->name}}</a>
                                    <a class="urun_sepet" onclick="Cart.add('{{$hp->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Sepete Ekle</span></a>
                                </div>
                                <div class="urun_fiyat">
                                    @if($hp->discount_type!=0 && $hp->discount_type!=null)
                                        <strong>{{$myPrice->currencyFormat($myPrice->withTax($hp->price,$hp->tax_status,$hp->tax))}} TL</strong>
                                    @endif
                                    {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($hp->price,$hp->tax_status,$hp->tax),$hp->discount_type,$hp->discount))}} TL
                                </div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    <div id="avt2" class="ana_vitrin_tab_icerik">
                        @foreach($newProducts as $np)
                        @php $np = $helpersnew->prdctDiscountDateCntrl($np); @endphp
                            <div class="urun">
                                @if($np->discount_type!=0 && $np->discount_type!=null)
                                    <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($np->discount,$np->discount_type,$np->price)}}</strong>indirim</div>
                                @endif

                                <a href="{{url($np->slug.'-p-'.$np->id)}}" class="urun_gorsel"><img class="lazy" data-src="{{$myProduct->baseImg($np->images,$np->id)}}" alt="{{$np->name}}"></a>
                                <div class="urun_urun_ad">
                                    <a href="{{url($np->slug.'-p-'.$np->id)}}" class="urun_adi_ic">{{$np->name}}</a>
                                    <a class="urun_sepet" onclick="Cart.add('{{$np->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Sepete Ekle</span></a>
                                </div>
                                <div class="urun_fiyat">
                                    @if($np->discount_type!=0 && $np->discount_type!=null)
                                        <strong>{{$myPrice->currencyFormat($myPrice->withTax($np->price,$np->tax_status,$np->tax))}} TL</strong>
                                    @endif
                                        {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($np->price,$np->tax_status,$np->tax),$np->discount_type,$np->discount))}} TL
                                </div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    <div id="avt3" class="ana_vitrin_tab_icerik">
                        @foreach($discountProducts as $dp)
                        @php $dp = $helpersnew->prdctDiscountDateCntrl($dp); @endphp
                            <div class="urun">
                                @if($dp->discount_type!=0 && $dp->discount_type!=null)
                                    <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($dp->discount,$dp->discount_type,$dp->price)}}</strong>indirim</div>
                                @endif
                                <a href="{{url($dp->slug.'-p-'.$dp->id)}}" class="urun_gorsel"><img class="lazy" data-src="{{$myProduct->baseImg($dp->images,$dp->id)}}" alt="{{$dp->name}}"></a>
                                <div class="urun_urun_ad">
                                    <a href="{{url($dp->slug.'-p-'.$dp->id)}}" class="urun_adi_ic">{{$dp->name}}</a>
                                    <a class="urun_sepet" onclick="Cart.add('{{$dp->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Sepete Ekle</span></a>
                                </div>
                                <div class="urun_fiyat">
                                    @if($dp->discount_type!=0 && $dp->discount_type!=null)
                                        <strong>{{$myPrice->currencyFormat($myPrice->withTax($dp->price,$dp->tax_status,$dp->tax))}} TL</strong>
                                    @endif
                                    {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($dp->price,$dp->tax_status,$dp->tax),$dp->discount_type,$dp->discount))}} TL
                                </div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="ana_orta_banner">
            <div class="aob_ic">
                <a href="{{$settings["banners"][3]["link"]}}" {{$settings["banners"][3]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img class="lazy" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/'.$settings["banners"][3]["image"])}}" alt="{{$settings["banners"][3]["alt"]}}"></a>
                <a href="{{$settings["banners"][4]["link"]}}" {{$settings["banners"][4]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img class="lazy" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/'.$settings["banners"][4]["image"])}}" alt="{{$settings["banners"][4]["alt"]}}"></a>
                <a href="{{$settings["banners"][5]["link"]}}" {{$settings["banners"][5]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link"><img class="lazy" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/'.$settings["banners"][5]["image"])}}" alt="{{$settings["banners"][5]["alt"]}}"></a>
                <a href="{{$settings["banners"][6]["link"]}}" {{$settings["banners"][6]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link2"><img class="lazy" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/'.$settings["banners"][6]["image"])}}" alt="{{$settings["banners"][6]["alt"]}}"></a>
                <a href="{{$settings["banners"][7]["link"]}}" {{$settings["banners"][7]["newTab"] == 1 ? "target=blank" : ""}} class="aob_link2"><img class="lazy" data-src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/'.$settings["banners"][7]["image"])}}" alt="{{$settings["banners"][7]["alt"]}}"></a>
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
                            @if(!empty($category['imageCover']) && file_exists(public_path().'/src/uploads/category/cover/'.$category['imageCover']))
                                <img data-src="{{url('src/uploads/category/cover/'.$category['imageCover'])}}" alt="{{$category['title']}}"  class="ak_gorsel lazy">
                            @else
                                <img data-src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel lazy">
                            @endif
                            <span  class="ak_ad">{{$category['title']}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="alan ap_bg">
            <strong class="alan_baslik">AVANTAJ PAKETİ</strong>
            <div class="alan_ic">
                @foreach($popularProducts as $pp)
                    @php $pp = $helpersnew->prdctDiscountDateCntrl($pp); @endphp
                    <div class="urun">
                        @if($pp->discount_type!=0 && $pp->discount_type!=null)
                            <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($pp->discount,$pp->discount_type,$pp->price)}}</strong>indirim</div>
                        @endif
                        <a href="{{url($pp->slug.'-p-'.$pp->id)}}" class="urun_gorsel"><img class="lazy" data-src="{{$myProduct->baseImg($pp->images,$pp->id)}}" alt="{{$pp->name}}"></a>
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
        <div class="alan ana_blog">
            <a href="{{url('alisveris-rehberi')}}" class="alan_baslik">ALIŞVERİŞ REHBERİ</a>
            <div class="alan_ic">
                @foreach($homeArticles as $article)
                    <div class="blog">
                        <a href="{{url('alisveris-rehberi/'.$article->slug)}}" class="blog_gorsel"><img class="lazy" data-src="{{asset('src/uploads/articles/'.$article->image)}}" alt="{{$article->title}}"></a>
                        <h4 class="blog_baslik"><a href="{{url('alisveris-rehberi/'.$article->slug)}}">{{$article->title}}</a></h4>
                        <span class="blog_tarih"><i class="fa fa-calendar" aria-hidden="true"></i> {{Carbon\Carbon::parse($article->created_at)->format('d.m.Y')}}</span>
                        <div class="blog_icerik">
                            {!! str_limit($article->content, 300,'...') !!}
                        </div>
                        @if(!empty(json_decode($article->seo)->seo_keywords))
                            <div class="blog_etiket">
                                <i class="fa fa-tags" aria-hidden="true"></i>
                                @foreach(explode(",",json_decode($article->seo)->seo_keywords) as $keyword)
                                    {{$keyword}}
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                <div class="clear"></div>
            </div>
            <a href="{{url('alisveris-rehberi')}}" class="tum_blog">Tüm Blog Yazıları İçin Tıklayınız</a>
            <div class="blog_ana_yazi">
            	<div class="scrollbar" id="style-2">
					<div class="force-overflow">
                        {!! @$settings["basic"]->article !!}
					</div>
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
{{-- <!-- Criteo Homepage Tag -->
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
 { event: "setAccount", account: 26770}, // You should never update this line
 { event: "setEmail", email: "" }, // Can be an empty string
 { event: "setSiteType", type: deviceType},
 { event: "viewHome"});
</script>
<!-- END Criteo Home Page Tag --> --}}
@endsection
