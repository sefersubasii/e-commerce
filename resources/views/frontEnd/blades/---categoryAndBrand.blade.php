@extends('frontEnd.layout.master')

@section('content')

    <div class="container">

        <div class="container_ic">

            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="#">Anasayfa</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span>{{$cat->title}}</span>
                </div>
            </div>

            <div class="urun_filtre">

                <div class="uf_blok">

                    <div class="ufb_baslik">{{$cat->title}} KATEGORİLERİ</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            @foreach($cat->childs as $child)
                                <li><a href="{{url($child->slug.'-c-'.$child->id)}}">{{$child->title}}</a></li>
                            @endforeach
                        </ul>

                    </div>

                </div>

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
                @if(count($filterBrands)>0)

                    <div class="uf_blok">

                        <div class="ufb_baslik">TÜM MARKALAR</div>

                        <div class="scrollbar" id="style-1">

                            <ul class="ufb_icerik force-overflow">
                                @foreach($filterBrands as $br)
                                    <li><label><input type="checkbox" class="filtre_chec"><span>{{$br["name"]}} ( {{$br["count"]}} )</span></label></li>
                                @endforeach
                            </ul>

                        </div>

                    </div>
                @endif

                <div class="uf_blok">

                    <div class="ufb_baslik">FİLTRE SEÇENEKLERİ</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            <li><label><input type="checkbox" class="filtre_chec"><span>Fiyatı Düşen Ürünler ( {{$filterCounts["discounted"]}} )</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>Sponsor Ürünler ( {{$filterCounts["sponsor"]}} )</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>Yeni Ürünler ( {{$filterCounts["new"]}} )</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>Kampanyalı Ürünler ( {{$filterCounts["campaign"]}} )</span></label></li>
                        </ul>

                    </div>

                </div>

                <div class="uf_blok">

                    <div class="ufb_baslik">FİYAT ARALIKLARI</div>

                    <div class="scrollbar" id="style-1">

                        <ul class="ufb_icerik force-overflow">
                            <li><label><input type="checkbox" class="filtre_chec"><span>10 TL ve altı (0)</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>10 TL ve 20 TL (0)</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>20 TL ve 30 TL (0)</span></label></li>
                            <li><label><input type="checkbox" class="filtre_chec"><span>30 TL ve 40 TL (0)</span></label></li>
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
                <div class="liste_slider">
                    <img src="{{asset('images/gorsel-hazirlaniyor/slider-urun-liste-956x250.jpg')}}" alt="">
                </div>


                <div class="urun_orta_filtre">
                    <strong>{{$cat->title}}</strong>

                    <div class="uof_alan">

                        <select class="uof_select">
                            <option>Fiyata Göre Sırala</option>
                        </select>

                        <select class="uof_select">
                            <option>30 Ürün Sırala</option>
                        </select>

                    </div>
                </div>


                <div class="urun_liste">

                    @foreach($pro as $p)
                        <div class="liste_urun">
                            @if($p->discount_type!=0 && $p->discount_type!=null)
                                <div class="urun_indirim"><strong>%{{$p->discount}}</strong>indirim</div>
                            @endif
                            <a href="{{url($p->slug.'-p-'.$p->id)}}" class="urun_gorsel"><img src="{{$myProduct->baseImg($p->images)}}" alt=""></a>

                            <div class="urun_urun_ad">
                                <div class="urun_adi_ic">{{$p->name}}</div>
                                <a onclick="Cart.add('{{$p->id}}',1)" href="javascript:void(0)"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                            </div>
                            <div class="urun_fiyat">
                                {{$myPrice->currencyFormat($p->price)}} TL
                            </div>
                        </div>
                    @endforeach


                    <?php /*
                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>


                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>


                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>


                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>

                    <div class="liste_urun">

                        <div class="urun_indirim"><strong>%0</strong>indirim</div>

                        <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                        <div class="urun_urun_ad">
                            <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                            <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                        </div>

                        <div class="urun_fiyat">
                            00,00 TL
                        </div>

                    </div>
                    */ ?>

                    <div class="clear"></div>

                </div>

                @include('pagination.custom',['paginator'=>$pro])

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



                <div class="liste_text">

                    <div class="devami_icin">
                        <h1 class="ic_blog_baslik">BLOG BAŞLIK</h1>

                        {!! $cat->content !!}
                    </div>

                    <a href="#" class="dit_alan">
                        <span class="dit">Devamı için tıklayınız</span>
                        <span class="ga">Geri al</span>
                    </a>



                </div>



            </div>

            <div class="clear"></div>




        </div>

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
                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="ak_alan">
                            <img src="{{asset('images/gorsel-hazirlaniyor/kategori-kapak-285x180.jpg')}}" alt=""  class="ak_gorsel">
                            <span  class="ak_ad">KATEGORİ ADI</span>
                        </a>
                    </li>

                </ul>

            </div>

        </div>




        <div class="alan ap_bg">

            <strong class="alan_baslik">AVANTAJ PAKETİ</strong>

            <div class="alan_ic">

                <div class="urun">

                    <div class="urun_indirim"><strong>%0</strong>indirim</div>

                    <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                    <div class="urun_urun_ad">
                        <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                        <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        <strong>00.00 TL</strong>
                        00,00 TL
                    </div>

                </div>

                <div class="urun">

                    <div class="urun_indirim"><strong>%0</strong>indirim</div>

                    <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                    <div class="urun_urun_ad">
                        <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                        <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        <strong>00.00 TL</strong>
                        00,00 TL
                    </div>

                </div>

                <div class="urun">

                    <div class="urun_indirim"><strong>%0</strong>indirim</div>

                    <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                    <div class="urun_urun_ad">
                        <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                        <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        <strong>00.00 TL</strong>
                        00,00 TL
                    </div>

                </div>

                <div class="urun">

                    <div class="urun_indirim"><strong>%0</strong>indirim</div>

                    <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                    <div class="urun_urun_ad">
                        <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                        <a href="javascript;;"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        <strong>00.00 TL</strong>
                        00,00 TL
                    </div>

                </div>

                <div class="urun">

                    <div class="urun_indirim"><strong>%0</strong>indirim</div>

                    <a href="#" class="urun_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/gorsel-hazirlaniyor.jpg')}}" alt=""></a>

                    <div class="urun_urun_ad">
                        <div class="urun_adi_ic">Ürün Adı ve Ürün Bilgileri Alanı</div>
                        <a href="#"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Sepete Ekle</span> </a>
                    </div>

                    <div class="urun_fiyat">
                        <strong>00.00 TL</strong>
                        00,00 TL
                    </div>

                </div>

                <div class="clear"></div>

            </div>

        </div>

        <div class="alan">

            <strong class="alan_baslik">ALIŞVERİŞ REHBERİ</strong>

            <div class="alan_ic">

                <div class="blog">

                    <a href="#" class="blog_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/blog-gorsel.jpg')}}" alt=""></a>

                    <strong class="blog_baslik"><a href="#">BLOG BAŞLIK</a></strong>

                    <span class="blog_tarih"><i class="fa fa-calendar" aria-hidden="true"></i> 01.01.2017</span>

                    <div class="blog_icerik">Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir.
                        Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini
                        alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır.</div>

                    <div class="blog_etiket"><i class="fa fa-tags" aria-hidden="true"></i> Etiket, Etiket, Etiket, Etiket, Etiket, Etiket,</div>

                </div>

                <div class="blog">

                    <a href="#" class="blog_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/blog-gorsel.jpg')}}" alt=""></a>

                    <strong class="blog_baslik"><a href="#">BLOG BAŞLIK</a></strong>

                    <span class="blog_tarih"><i class="fa fa-calendar" aria-hidden="true"></i> 01.01.2017</span>

                    <div class="blog_icerik">Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir.
                        Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini
                        alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır.</div>

                    <div class="blog_etiket"><i class="fa fa-tags" aria-hidden="true"></i> Etiket, Etiket, Etiket, Etiket, Etiket, Etiket,</div>

                </div>

                <div class="blog">

                    <a href="#" class="blog_gorsel"><img src="{{asset('images/gorsel-hazirlaniyor/blog-gorsel.jpg')}}" alt=""></a>

                    <strong class="blog_baslik"><a href="#">BLOG BAŞLIK</a></strong>

                    <span class="blog_tarih"><i class="fa fa-calendar" aria-hidden="true"></i> 01.01.2017</span>

                    <div class="blog_icerik">Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir.
                        Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini
                        alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır.</div>

                    <div class="blog_etiket"><i class="fa fa-tags" aria-hidden="true"></i> Etiket, Etiket, Etiket, Etiket, Etiket, Etiket,</div>

                </div>


                <div class="clear"></div>


            </div>

        </div>

        <div class="container_ic">

            <div class="ana_yorum_alan">

                <strong class="yorum_baslik">MÜŞTERİ YORUMLARI</strong>

                <ul class="ana_yorum">

                    <div class="ana_yorum_icerik">

                        <div class="ay_left">
                            <strong>Mehmet YILMAZ</strong>
                            <span>Market Paketi Müşterisi</span>
                        </div>

                        <div class="ay_right">
                            Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir
                            hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı
                            sahte metinler olarak kullanılmıştır.
                        </div>

                    </div>

                    <div class="ana_yorum_icerik">

                        <div class="ay_left">
                            <strong>Mehmet YILMAZ</strong>
                            <span>Market Paketi Müşterisi</span>
                        </div>

                        <div class="ay_right">
                            Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir
                            hurufat numune kitabı oluşturmak üzere bir yazı.
                        </div>

                    </div>

                    <div class="ana_yorum_icerik">

                        <div class="ay_left">
                            <strong>Mehmet YILMAZ</strong>
                            <span>Market Paketi Müşterisi</span>
                        </div>

                        <div class="ay_right">
                            Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir
                            hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı.
                        </div>

                    </div>




                </ul>

            </div>

            <div class="bulten">

                <div class="bulten_ic">

                    <strong>BÜLTEN</strong>

					<span>Ücretsiz olarak e-bülten aboneliğinizi başlatarak yeni<br>
					kampanya ve ürünlerimizden anında haberdar olun!</span>

                    <div class="bulten_alan">
                        <input type="text" placeholder="E-Mail adresinizi yazınız" class="ba_input">
                        <a href="#" class="ba_buton"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>

                    </div>

                </div>

            </div>


            <div class="clear"></div>
        </div>





    </div>

@endsection