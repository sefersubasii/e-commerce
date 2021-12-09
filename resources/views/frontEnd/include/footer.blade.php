<footer>
    <div class="footer_bilgi">
        <div class="fb_ic">
            {{-- <div class="fbi_alan">
                <i class="fa fa-th-large" aria-hidden="true"></i>
				<span>
					<strong>Aynı Gün Kargo</strong>
					Aynı Gün Stoktan Gönderim
				</span>
            </div> --}}

            <div class="fbi_alan">
                <i class="fa fa-shield" aria-hidden="true"></i>
				<span>
					<strong>%100 Güvenli Alışveriş</strong>
					256bit SSL Sertifikası
				</span>
            </div>

            <div class="fbi_alan">
                <i class="fa fa-truck" aria-hidden="true"></i>
				<span>
					<strong>100 TL ve Üzeri</strong>
					Alışverişlerde Kargo Ücretsiz
				</span>
            </div>

            <div class="fbi_alan">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
				<span>
					<strong>%100 Sağlıklı Ürünler</strong>
					Doğal ve Sağlıklı Ürünler
				</span>
            </div>

            <div class="fbi_alan">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
				<span>
					<strong>%100 Güven</strong>
					%100 Müşteri Memnuniyeti
				</span>
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <div class="footer_kurumsal">
        <div class="fk_ic">
            <ul class="fk_ic_menu">
                <li><strong>Hakkımızda</strong></li>
                <li><a href="{{url('markalar')}}">&#8226; Markalar</a></li>
                <li><a href="{{url('uye-ol')}}">&#8226; Yeni Üyelik</a></li>
                <li><a href="{{url('uye-girisi')}}">&#8226; Üye Girişi</a></li>
                <li><a href="{{url('sifremi-unuttum')}}">&#8226; Şifremi Unuttum</a></li>
                <li><a href="{{url('iletisim-formu')}}">&#8226; İletişim Formu</a></li>
                <li><a href="{{url('iletisim')}}">&#8226; İletişim</a></li>
                <li><a href="{{url('sayfa/cerez-politikasi')}}">&#8226; Çerez Politikası</a></li>
                <li><a href="{{url('sayfa/kisisel-verilerin-korunmasi-kanunu-hakkinda')}}">&#8226; Kişisel Verilerin<br>Korunması Kanunu<br>Hakkında</a></li>
            </ul>

            <ul class="fk_ic_menu">
                <li><strong>Sipariş İşlemleri</strong></li>
               <li> <a href="javascript:;" id="order-track-input">&#8226; Sipariş Sorgulama</a></li>
                <li><a href="{{url('sayfa/islem-rehberi')}}">&#8226; İşlem Rehberi</a></li>
                <li><a href="{{url('mesafeli-satis-sozlesmesi')}}">&#8226; Mesafeli Satış Sözleşmesi</a></li>
                <li><a href="{{url('odeme-ve-teslimat')}}">&#8226; Ödeme ve Teslimat</a></li>
                <li><a href="{{url('gizlilik-ve-guvenlik')}}">&#8226; Gizlilik ve Güvenlik</a></li>
                <li><a href="{{url('iade-sartlari')}}">&#8226; İade Şartları</a></li>

            </ul>

            <ul class="fk_ic_menu">
                <li><strong>Formlar</strong></li>
                <li><a href="{{url('hesabim')}}">&#8226; Hesabım</a></li>
                <li><a href="{{url('hesabim/siparisler')}}">&#8226; Sipariş Takip</a></li>
                <?php /*<li><a href="#">&#8226; Favorileriniz</a></li> */ ?>
                <li><a href="{{url('sepet')}}">&#8226; Sepetiniz</a></li>
            </ul>

            <ul class="fk_ic_menu">
                <li><strong>Kategoriler</strong></li>
                @foreach($categories as $category)
                    <li><a href="{{url($category["slug"].'-c-'.$category['id'])}}">&#8226; {{$category["title"]}}</a></li>
                @endforeach
            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <div class="belge_alan">
        <div class="belge_ic">
            {{-- <div id="ETBIS" style="display:inline-block;">
                <div id="975f3d3b9ef1414990f48fd4d3434216">
                    <a href="https://etbis.eticaret.gov.tr/sitedogrulama/975f3d3b9ef1414990f48fd4d3434216" target="_blank">
                        <img class="etbis-img" src="{{ asset('images/etbis/qrcode-small.jpeg') }}"/>
                    </a>
                </div>
            </div> --}}
            <img class="lazy" data-src="{{asset('images/belgeler/rapid-ssl.png')}}" alt="">
            <img class="lazy" data-src="{{asset('images/belgeler/visa.png')}}" alt="">
            <img class="lazy" data-src="{{asset('images/belgeler/master-card.png')}}" alt="">
            <span>Tüm kredi kartı bilgileriniz <strong>256 bit SSL Sertifikası</strong> ile korunmaktadır.</span>
        </div>
    </div>

<?php /*
    <div class="banka_alan">
        <div class="banka_ic">
            <img src="{{asset('images/belgeler/banka/bonus.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/maximum.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/axess.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/world.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/advantage.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/card-finans.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/vakif-bank.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/paraf.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/asya-card.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/turkiye-finans.png')}}" alt="">
            <img src="{{asset('images/belgeler/banka/citi.png')}}" alt="">
        </div>
    </div>
*/ ?>

    <div class="sm_alan">
        <div class="sm_ic">
            <a target="_blank" href="{{$settings["social"]->facebook->facebook_link}}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a target="_blank" href="{{$settings["social"]->twitter->twitter_link}}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a target="_blank" href="{{$settings["social"]->youtube->youtube_link}}"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            <a target="_blank" href="{{$settings["social"]->instagram->instagram_link}}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a target="_blank" href="{{$settings["social"]->google->google_link}}"><i class="fa fa-google" aria-hidden="true"></i></a>
        </div>
    </div>

	<div class="copy">
		<div class="copy">Copyright © 2018 Market Paketi Tüm Hakları Saklıdır</div>
	</div>

</footer>

<div id="inputopen" class="tracking-modal ">
    <div class="modaltrack-bg">

        <img src="{{ asset('images/logo.png') }}" alt="marketpaketi">
        <div class="track-title">Sipariş detaylarınızı buradan öğrenebilirsiniz.</div>
        <div class="getform">
            <input type="text" placeholder="Sipariş numaranızı giriniz." id="ordernoget"
                class="input-field">

            <a href="javascript:;" id="submit-trackorder"><span>Siparişi Sorgula</span></a>
            <a href="javascript:;" class="tracking-close">Kapat</a>
        </div>
    </div>
</div>

{{-- Sipariş Takip --}}
<div id="open-ordertrack" class="tracking-modal">
    <div>
        <div class="trackingview-class"></div>
        <a href="javascript:;" class="tracking-close detail-closetwo">Kapat</a>
    </div>
</div>

@if(isset($homePopups) || isset($categoryPopups) || isset($globalPopups))
    @push('scripts')
        <script>
            window.onload = function(){
                @if(isset($homePopups))
                    popupShow('{{ $homePopups->id }}', '{{ $homePopups->name }}', '{!! popup_str($homePopups->content) !!}', '{{ $homePopups->frequency }}');
                @elseif(isset($categoryPopups))
                    popupShow('{{ $categoryPopups->id }}', '{{ $categoryPopups->name }}', '{!! popup_str($categoryPopups->content) !!}', '{{ $categoryPopups->frequency }}');
                @endif
                
                @if(isset($globalPopups))
                    popupShow('{{ $globalPopups->id }}', '{{ $globalPopups->name }}', '{!! popup_str($globalPopups->content) !!}', '{{ $globalPopups->frequency }}');
                @endif
            }
        </script>
    @endpush
@endif
