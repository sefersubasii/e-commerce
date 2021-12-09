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
                    <span>Üye Ol</span>
                </div>
            </div>

            <div class="bilgi_left">

                <img src="{{asset('src/images/yeni-uye.jpg')}}" alt="">

            </div>

            <div class="bilgi_icerik">

                @if(count($errors))
                    <div class="alert alert-danger">
                        <strong>Hata!</strong> Lütfen aşağıdaki alanları kontrol ediniz.
                        <br/>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="signUpFrom" method="post">

                    <div class="bilgi_icerik_baslik">ÜYE OL</div>

                    <div class="bilgi_icerik_ic">

                        <div class="satir">
                            <div class="satir_baslik">Ad</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('name')}}" name="name" type="text" class="uye_input {{ $errors->first('name') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Soyad</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('surname')}}" name="surname" type="text" class="uye_input {{ $errors->first('surname') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Email</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('email')}}" name="email" type="text" class="uye_input {{ $errors->first('email') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Şifre</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('password')}}" name="password" type="password" class="uye_input {{ $errors->first('password') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Şifre ( Tekrar )</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('password_confirm')}}" name="password_confirm" type="password" class="uye_input {{ $errors->first('password_confirm') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Cinsiyet</div>
                            <span class="satir_nokta">:</span>
                            <label>
                                <input checked name="gender" value="1" type="radio" class="uye_radio">
                                <span>Erkek</span>
                            </label>
                            <label>
                                <input name="gender" value="2" type="radio" class="uye_radio">
                                <span>Kadın</span>
                            </label>
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Cep Telefonu</div>
                            <span class="satir_nokta">:</span>
                            <input value="{{old('phone')}}" name="phone" type="text" class="uye_input {{ $errors->first('phone') ? "err" : "" }}">
                        </div>

                        <div class="satir">
                            <div class="satir_baslik">Güvenlik Kodu</div>
                            <span class="satir_nokta">:</span>

                            <img id="captchaCode" onclick="this.src='{{url('/')}}/captcha/default?'+Math.random()" src="{{captcha_src()}}" alt="" class="uye_uyari">
                            <a style="float: left" rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='captcha/default?'+Math.random()" class="reflash"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            <input value="" name="captcha" type="text" class="uye_input2">
                        </div>
                        <style media="screen">
                            .satir.s_left label{ float:none!important;}
                            .satir.s_left label span{ line-height: 30px;}
                        </style>
                        <div class="satir s_left">
                            <label>
                                <input {{old('allowed_to_mail') == 1 ? "checked" : ""}} name="allowed_to_mail" type="checkbox" class="uye_chec">
                                <span>Kampanyalardan haberdar olmak istiyorum</span>
                            </label>
                            <label>
                                <input {{old('userAgreement') == 1 ? "checked" : ""}} name="userAgreement" type="checkbox" class="uye_chec">
                                <span><a data-fancybox class="fancybox" href="#useragreement">Üyelik sözleşmesi</a>ni kabul ediyorum.</span>
                            </label>
                            <label>
                                <input {{old('kvkAgreement') == 1 ? "checked" : ""}} name="kvkAgreement" type="checkbox" class="uye_chec">
                                <span>
                                    Öz Koru Sanal Mağazacılık Gıda İnş. Paz. San. Dış Tic Ltd. Şti(*) ve sahip olduğu markalar tarafından,
                                    yukurıda yer alan iletişim bilgilerime reklam, promosyon, kampanya vb. de dahil ticari elektronik ileti
                                    gönderilmesini bilgilerimin bu amaçla kullanılmasınıi, saklanmasını ve
                                    Öz Koru Sanal Mağazacılık Gıda İnş. Paz. San. Dış Tic Ltd. Şti'nin gönderime ilişkin hizmet aldığı
                                    üçüncü kişilerle paylaşılmasını <a data-fancybox class="fancybox" href="#kvkagreement">mevzuat kapsamındaki haklarım saklı kalmak kaydı</a> ile kabul ediyorum.
                                </span>
                            </label>
                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit"  class="uye_buton"><i class="fa fa-users" aria-hidden="true"></i> Üye Ol</button>

                    </div>

                </form>

            </div>

            <div class="clear"></div>

            <div style="display:none;width: 80%;" id="useragreement">{!!$settings["constants"]->useragreement!!}</div>
            <div style="display:none;width: 80%;" id="kvkagreement">
                <p>Kişisel Verilerin Korunması Kanunu&rsquo;nun 11. maddesinin y&uuml;r&uuml;rl&uuml;ğe girmesi ile birlikte kişisel veri sahibi, veri sorumlusuna başvurarak kendisiyle ilgili;</p>
                <ul style="padding-left:45px;padding-top:15px;">
                    <li>Kişisel veri işlenip işlenmediğini &ouml;ğrenme,</li>
                    <li>Kişisel verileri işlenmişse buna ilişkin bilgi talep etme,</li>
                    <li>Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını &ouml;ğrenme,</li>
                    <li>Yurt i&ccedil;inde veya yurt dışında kişisel verilerin aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişileri bilme,</li>
                    <li>Kişisel verilerin eksik veya yanlış işlenmiş olması halinde bunların d&uuml;zeltilmesini isteme,</li>
                    <li>İlgili mevzuatta &ouml;ng&ouml;r&uuml;len şartlar &ccedil;er&ccedil;evesinde kişisel verilerin silinmesini veya yok edilmesini isteme,</li>
                    <li>İlgili mevzuat uyarınca yapılan d&uuml;zeltme, silme ve yok edilme işlemlerinin, kişisel verilerin aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişilere bildirilmesini isteme,</li>
                    <li>İşlenen verilerin m&uuml;nhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin kendisi aleyhine bir sonucun ortaya &ccedil;ıkmasına itiraz etme,</li>
                    <li>Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması halinde zararın giderilmesini talep etme,</li>
                </ul>
                <p><br />haklarına sahiptir. Bahsi ge&ccedil;en talepleri'ne adresi &uuml;zerinden yazılı olarak iletilebilecektir.</p>
                <div class="yj6qo ajU">&nbsp;</div>
            </div>


        </div>



        <div class="container_ic">

            @include('frontEnd.include.footerTop')


            <div class="clear"></div>
        </div>


    </div>

@endsection
