@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')

<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('./')}}">Anasayfa</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Şifremi Unuttum</span>
			</div>
		</div>
		
		<div class="bilgi_left">
			
			<div class="bilgi_left_blok">
				
				<div class="blb_baslik">HESABIM</div>

				<ul class="blb_icerik">
					<li><a href="{{url('hesabim')}}">Hesabım</a></li>
					<li><a href="{{url('hesabim/siparisler')}}">Siparişlerim</a></li>
					<li><a href="{{url('hesabim/sifre-degistir')}}">Şifremi Değiştir</a></li>
				</ul>

			</div>
			
			<div class="bilgi_left_blok">
				
				<div class="blb_baslik">DİĞER BİLGİ SAYFALARI</div>

				<ul class="blb_icerik">
					<li><a href="{{url('mesafeli-satis-sozlesmesi')}}">Mesafeli Satış Sözleşmesi</a></li>
					<li><a href="{{url('odeme-ve-teslimat')}}">Ödeme ve Teslimat</a></li>
					<li><a href="{{url('gizlilik-ve-guvenlik')}}">Gizlilik ve Güvenlik</a></li>
					<li><a href="{{url('iade-sartlari')}}">İade Şartları</a></li>
				</ul>

			</div>
			
		</div>
		
		<div class="bilgi_icerik">

			<div class="bilgi_icerik_baslik">ŞİFRE DEĞİŞTİRME</div>
			
			<div class="bilgi_icerik_ic">

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

                @if(Session::has('success'))

                <p>{{ Session::get('success') }}</p>

                @endif

				@if(Session::has('error'))

                <p>{{ Session::get('error') }}</p>

                @endif

                @if(Session::has('success'))
					
					<p>Mağazamıza yapacağınız girişlerde yeni belirlediğiniz şifreyi kullanınız.</p>

                @else

	                <form id="forgotForm" method="post" action="{{url('sifremi-unuttum/'.$token)}}">
						<div class="satir">
							<div class="satir_baslik">Yeni Şifre</div>
							<span class="satir_nokta">:</span>
							<input name="password" type="password" class="uye_input {{ $errors->first('password') ? "err" : "" }}">
						</div>

						<div class="satir">
							<div class="satir_baslik">Yeni Şifre Tekrar</div>
							<span class="satir_nokta">:</span>
							<input name="password-repeat" type="password" class="uye_input {{ $errors->first('password-repeat') ? "err" : "" }}">
						</div>
						
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						
						<a href="javascript:void(0)" onclick="$('#forgotForm').submit();" class="uye_buton"><i class="fa fa-lock" aria-hidden="true"></i> Gönder</a>
				
					</form>

                @endif

				
				

			</div>
			
		</div>
		
		<div class="clear"></div>
		
		
		

	</div>
	

		
		<div class="container_ic">
		
			
			@include('frontEnd.include.footerTop')
			

			<div class="clear"></div>
		</div>
		
		
		
		
		
</div>



@endsection