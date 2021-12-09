@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('extraMeta','<meta name="robots" content="noindex,follow">')

@section('content')

    

    <div class="container">

        <div class="container_ic">

            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="{{url('./')}}">Sanal Market</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    
                    <span></span>
                </div>
            </div>
            <div class="filtre_ac">
                <i class="fa fa-align-left" aria-hidden="true"></i>
                <strong>FİLTRELE</strong>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
            <div class="urun_filtre">
            @if(!empty($catname->childs))
            <div class="uf_blok">
                <div class="ufb_baslik">KATEGORİLER</div>

                <div class="scrollbar" id="style-1">
                    <ul class="ufb_icerik force-overflow">
                        @foreach($childcategories as $c)
                            <li><a href="{{url('/c/'.$c["slug"].'/search?q='.$link)}}">{{$c["title"]}}</a></li>
                        @endforeach
                 

                    </ul>

                </div>

                </div>
            @else
                    @if(!empty($newcategories))
                        <div class="uf_blok">

                            <div class="ufb_baslik">KATEGORİLER</div>

                            <div class="scrollbar" id="style-1">

                                <ul class="ufb_icerik force-overflow">
                                    @foreach($newcategories as $c)
                                        <li><a href="{{url('/c/'.$c["slug"].'/search?q='.$link)}}">{{$c["title"]}} ({{$c["count"]}})</a></li>
                                    @endforeach
                                </ul>

                            </div>

                        </div>
                    @else
                    <div class="uf_blok">

                        <div class="ufb_baslik">KATEGORİLER</div>

                            <div class="scrollbar" id="style-1">

                                <ul class="ufb_icerik force-overflow">
                                    @foreach($categories as $c)
                                        <li><a href="{{url($c["slug"].'-c-'.$c["id"])}}">{{$c["title"]}} @if(!empty($c["count"])) ({{$c["count"]}}) @endif</a></li>
                                    @endforeach
                                </ul>

                            </div>

                    </div>
                    @endif
            @endif
            


            </div>

            <div class="urun_liste_alan">
<?php /*
                <ul class="liste_slider">

                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>
                    <li><img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt=""></li>

                </ul>
*/ ?>
<?php /*
                <div class="liste_slider">
                    <img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt="">
                </div>
*/ ?>

                <div class="urun_orta_filtre">
                    <strong>“{{$q}}” araması için "{{$catname->title}}" kategorisinde {{$count}} sonuç bulundu.</strong>

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
                    @if(count($results->items())>0)
                        
                        @foreach($results->items() as $key => $val)

                        @php $val = $helpersnew->prdctDiscountDateCntrl($val); @endphp
                        <div class="liste_urun">
                            @if($val->discount_type && $val->discount_type!=null)
                                <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent( $val->discount,$val->discount_type,$val->price) }}</strong>indirim</div>
                            @endif
                            <a href="{{url($val->slug.'-p-'.$val->id)}}" class="urun_gorsel"><img src="{{$myProduct->baseImg($val->images,$val->id)}}" alt=""></a>

                            <div class="urun_urun_ad">
                                <a href="{{url($val->slug.'-p-'.$val->id)}}" class="urun_adi_ic">{{$val->name}}</a>
                                @if($val->stock>=1)
                                <a class="urun_sepet" onclick="Cart.add('{{$val->id}}',1,this)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                                @else
                                <a href="javascript:void(0)" class="stokta_yok urun_sepet"> <i class="fa fa-envelope-o" aria-hidden="true"></i> <span>Gelince Haber Ver</span> </a>
                                @endif
                            </div>
                            <div class="urun_fiyat">
                            @if($val->stock>=1)
                                @if($val->discount_type!=0 && $val->discount_type!=null)
                                    <strong>{{$myPrice->currencyFormat($myPrice->withTax($val->price,$val->tax_status,$val->tax))}} TL</strong>
                                @endif
                                {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($val->price,$val->tax_status,$val->tax),$val->discount_type,$val->discount))}} TL
                            @else
                                Stokta Yok
                            @endif
                            </div>
                        </div>

                        @endforeach

                    @else
                    
                        Aradığınız kriterlerde sonuc bulunamadı.
                    
                    @endif
                <?php /*
                    @if($pro)

                    @foreach($pro as $p)
                        <div class="liste_urun">
                            @if($p->discount_type!=0 && $p->discount_type!=null)
                                <div class="urun_indirim"><strong>%{{$myProduct->rebatePercent($p->discount,$p->discount_type,$p->price)}}</strong>indirim</div>
                            @endif
                            <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_gorsel"><img src="{{$myProduct->baseImg($p->images)}}" alt=""></a>

                            <div class="urun_urun_ad">
                                <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_adi_ic">{{$p->name}}</a>
                                <a class="urun_sepet" onclick="Cart.add('{{$p->id}}',1)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                            </div>
                            <div class="urun_fiyat">
                                {{$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($p->price,$p->taxStatus,$p->tax),$p->discount_type,$p->discount))}}  TL
                            </div>
                        </div>
                    @endforeach

                    @endif

                */ ?>

                    <div class="clear"></div>

                </div>
                
                @if($results)
                    @include('pagination.custom',['paginator'=>$results])
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


            </div>

            <div class="clear"></div>



        </div>

        

        <div class="container_ic">

            @include('frontEnd.include.footerTop')

            <div class="clear"></div>
        </div>





    </div>

@endsection