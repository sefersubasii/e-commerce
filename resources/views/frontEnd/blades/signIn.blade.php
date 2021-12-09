@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')

    <div class="container">

        <div class="container_ic">

            <div class="navigasyon">
                <div class="navigasyon_ic">
                    <a href="{{url('/')}}">Sanal Market</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span>Üye Girişi</span>
                </div>
            </div>
            <form method="post" id="signInForm">
                <?php /*
                @if(count($errors))
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <br/>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                */ ?>
                <div class="tek_alan">

                    <div class="uye_girisi">

                        <div class="uye_girisi_baslik">ÜYE GİRİŞİ</div>

                        @if(Session::has('csrf_error'))
                            <span>{{Session::get('csrf_error')}}</span>
                        @endif

                        <div class="uye_girisi_icerik">
                            @if(session()->has('facebook_email_error'))
                                <div class="social-login-error">{{ session('facebook_email_error') }}</div>
                            @endif

                            <a href="{{ url('login/facebook') }}" class="fb_ile_giris">
                                <i class="fa fa-facebook" aria-hidden="true"></i> İle Bağlan
                            </a>
                            
                            <a href="{{ url('login/google') }}" class="g_ile_giris">
                                <i class="fa fa-google" aria-hidden="true"></i> İle Bağlan
                            </a>

                            <div class="clear"></div>

                            

                            <input name="email" type="text" class="uye_giris_input" placeholder="E Mail" required>
                            @if($errors->has('email'))
                                <span class="text-danger error">{{ $errors->first('email') }}</span>
                            @endif

                            <input name="password" type="password" class="uye_giris_input" placeholder="Şifre" required>
                            @if($errors->has('password'))
                                <span class="text-danger error">{{ $errors->first('password') }}</span>
                            @endif

                             @if(session()->has('messageLogin'))
                                <div class="text-danger error">{{session()->get('messageLogin')}}</div>
                             @endif

                            <div class="beni_hatirla">
                                <label>
                                    <input type="checkbox" class="uye_girisi_sec">
                                    <span>Beni Hatırla</span>
                                </label>
                            </div>

                            <a href="{{ url('sifremi-unuttum') }}" class="sifremi_unuttum">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <span>Şifremi Unuttum</span>
                            </a>

                            <div class="clear"></div>

                            <button id="signInFormBtn" type="submit" class="giris_buton">
                                <i class="fa fa-user" aria-hidden="true"></i> Giriş Yap
                            </button>

                            @if($guest)
                                <a href="{{url('sepet/fatura-teslimat')}}" class="uade_buton">
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i> Üyeliksiz Alışverişe Devam Et
                                </a>
                            @endif
                        </div>


                    </div>

                    <div class="uye_girisi_gorsel">
                        <img src="{{url('images/uyeolgirisyap.png')}}" alt="">
                    </div>

                    <div class="uye_ol_bilgi">

                        <div class="uye_girisi_baslik">ÜYE OL</div>

                        <div class="uye_girisi_icerik">

                            <strong>• Kolay Sipariş Takibi</strong>
                            <br>
                            <br>
                            • Hızlı ve Kolay Alışveriş
                            <br>
                            <br>
                            • Kampanyalardan Anında Takip
                            <br>
                            <br>
                            • Marketpaketi Üyelerine Özel İndirim
                            <br>
                            <br>
                            @if($guest==true)
                                <a href="{{url('uye-ol')}}?returnUrl=fatura-teslimat" class="giris_buton"><i class="fa fa-users" aria-hidden="true"></i> Üye Ol</a>
                            @else
                                <a href="{{url('uye-ol')}}" class="giris_buton"><i class="fa fa-users" aria-hidden="true"></i> Üye Ol</a>
                            @endif
                            
                            
                        </div>


                    </div>

                    <div class="clear"></div>

                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>

        </div>

        <div class="container_ic">

            @include('frontEnd.include.footerTop')

            <div class="clear"></div>
        </div>

    </div>

@endsection