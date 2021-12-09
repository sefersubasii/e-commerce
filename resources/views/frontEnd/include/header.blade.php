<header>
    <div class="ust_reklam">
        @if(!empty($settings["banners"][0]["image"]) && file_exists(public_path("/src/uploads/banner/".$settings["banners"][0]["image"])) )
            <a href='{{$settings["banners"][0]["link"]}}' {{$settings["banners"][0]["newTab"] == 1 ? "target=blank" : ""}}>
                <img data-src='{{asset("https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/".$settings["banners"][0]["image"])}}' alt='{{$settings["banners"][0]["alt"]}}' class="ust_reklam_buyuk lazy">
            </a>
        @endif
        @if(!empty($settings["banners"][1]["image"]) && file_exists(public_path("/src/uploads/banner/".$settings["banners"][1]["image"])) )
            <a href='{{$settings["banners"][1]["link"]}}' {{$settings["banners"][1]["newTab"] == 1 ? "target=blank" : ""}}>
                <img data-src='{{asset("https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/".$settings["banners"][1]["image"])}}' alt='{{$settings["banners"][1]["alt"]}}' class="ust_reklam_tablet lazy">
            </a>
        @endif
        @if(!empty($settings["banners"][2]["image"]) && file_exists(public_path("/src/uploads/banner/".$settings["banners"][2]["image"])) )
            <a href='{{$settings["banners"][2]["link"]}}' {{$settings["banners"][2]["newTab"] == 1 ? "target=blank" : ""}}>
                <img data-src='{{asset("https://d151fsz95gwfi2.cloudfront.net/src/uploads/banner/".$settings["banners"][2]["image"])}}' alt='{{$settings["banners"][2]["alt"]}}' class="ust_reklam_mobil lazy">
            </a>
        @endif
    </div>
    <div class="header_orta">
        <a href="{{url("/")}}" class="logo">
            <img src="{{asset('images/logo.png')}}" alt="Marketpaketi Logo">
        </a>
        <div class="ust_orta_right">
            <div class="arama_alan">
                <form method="get" action="{{url('search')}}">
                    <input name="q" value="{{ request('q') }}" type="text" class="arama_input" placeholder="Aramak istediğiniz ürünün adını yazınız...">
                    <button class="arama_buton" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="uyelik_alan">
                <div class="ua_baslik">{{Auth::guard('members')->check() == true ? Auth::guard('members')->user()->name." ".Auth::guard('members')->user()->surname : "Üye İşlemleri" }}</div>
                <ul class="ua_icerik">
                    @if(Auth::guard('members')->check())
                        <li><a href="{{url('hesabim/siparisler')}}">Siparişlerim</a></li>
                        <li><a href="{{url('hesabim')}}">Hesabım</a></li>
                        <li><a href="{{url('cikis-yap')}}">Çıkış Yap</a></li>
                    @else
                        <li><a href="{{url('uye-girisi')}}">Giriş Yap</a></li>
                        <li><a href="{{url('uye-ol')}}">Üye Ol</a></li>
                        {{-- <li class="google"><a href="{{url('login/google')}}">Google İle Bağlan</a></li>
                        <li class="facebook"><a href="{{url('login/facebook')}}">Facebook İle Bağlan</a></li> --}}
                    @endif
                </ul>
            </div>
            <div class="golge"></div>
            <a href="{{url('sepet')}}" class="sepet_alan">
                <span id="cartInfo">Sepetim ( {{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }} ) - {{Session::has('cart') ? $myPrice->currencyFormat(Session::get('cart')->totalPrice):"0.00"}} TL</span>
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </a>
           <div class="myi">
                <div class="mobil_uye_islem"><i class="fa fa-user" aria-hidden="true"></i></div>
                <div class="uye_icerik">
                    @if(Auth::guard('members')->check())
                        <a href="{{url('hesabim')}}">Hesabım</a>
                        <a href="{{url('hesabim/siparisler')}}">Siparişlerim</a>
                        <a href="{{url('cikis-yap')}}">Çıkış Yap</a>
                    @else
                        <a href="{{url('uye-girisi')}}">Giriş Yap</a>
                        <a href="{{url('uye-ol')}}">Üye Ol</a>
                        {{-- <a class="mobil_facebook" href="{{url('login/facebook')}}">Facebook <br>İle Bağlan</a>
                        <a class="mobil_google" href="{{url('login/google')}}">Google <br>İle Bağlan</a> --}}
                    @endif
                    <div class="clear"></div>
                </div>
           </div>
        </div>
        <div class="clear"></div>
    </div>
<?php /*
    <div class="menu">
    <div class="genel">
        <a href="#" class="menu-mobile">Kategoriler <i class="fa fa-bars" aria-hidden="true"></i></a>
        <ul id="menu">
            @foreach($categories as $category)
            <li class="{{@$cat_id == $category['id'] ? 'menu_aktif':'' }}">
                <a href="{{url($category['slug'].'-c-'.$category['id'])}}" title="{{$category["title"]}}">{{$category["title"]}}</a>
                @if(!empty($category["children"]))
                <!-- Mega Menü -->
                @foreach($category["children"] as $child)
                <div class="mega-menu">
                    <ul class="mega-menu-2">
                        <li>
                            <a href="{{url($child['slug'].'-c-'.$child['id'])}}" title="{{$child["title"]}}">{{$child["title"]}}</a>
                        </li>
                    </ul>
                </div>
                @endforeach
                <!--#Mega Menü -->
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    </div>
*/ ?>

    <div class="menu_alan">
        <div class="menu">
            <a href="#" class="menu-mobile">Kategoriler <i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul>
                @foreach($categories as $category)
                    <li class="{{@$cat_id == $category['id'] ? 'menu_aktif':'' }}">
                        <a class="dMenu" href="{{url($category['slug'].'-c-'.$category['id'])}}">{{$category["title"]}}</a>
                        <a class="mMenu" href="javascript:void(0)">{{$category["title"]}}</a>
                        @if(!empty($category["children"]))
                            <ul>
                                <li>
                                    <ul>
                                        <li class="mTum"><a href="{{url($category['slug'].'-c-'.$category['id'])}}">TÜM {{$category["title"]}} ÜRÜNLERİ <i class="fa fa-angle-double-right"></i></a></li>
                                        @foreach($category["children"] as $child)
                                            <li>
                                                <a href="{{url($child['slug'].'-c-'.$child['id'])}}">{{$child["title"]}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</header>
<div class="menu_golge"></div>
