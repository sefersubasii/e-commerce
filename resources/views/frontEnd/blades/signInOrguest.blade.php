@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')


<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{ url('/') }}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Üye Girişi</span>
			</div>
		</div>
		
		
		<div class="tek_alan">
			
			<div class="uye_girisi">
				
				<div class="uye_girisi_baslik">ÜYE GİRİŞİ</div>
				
				<div class="uye_girisi_icerik">
					
					<a href="#" class="fb_ile_giris"><i class="fa fa-facebook" aria-hidden="true"></i> İle Bağlan </a>
					
					<a href="#" class="g_ile_giris"><i class="fa fa-google-plus" aria-hidden="true"></i> İle Bağlan </a>
					
					<div class="clear"></div>
					
					<input type="text" class="uye_giris_input" placeholder="E Mail">
					
					<input type="password" class="uye_giris_input" placeholder="Şifre">
					
					<div class="beni_hatirla">
						<label>
							<input type="checkbox" class="uye_girisi_sec">
							<span>Beni Hatırla</span>
						</label>
					</div>
					
					<a href="#" class="sifremi_unuttum">
						<i class="fa fa-lock" aria-hidden="true"></i>
						<span>Şifremi Unuttum</span>
					</a>
					
					<div class="clear"></div>
					
					<a href="#" class="giris_buton"><i class="fa fa-user" aria-hidden="true"></i> Giriş Yap</a>
					
				</div>
				
				
			</div>
			
			<div class="uye_girisi_gorsel">
				<img src="assets/images/gorsel-hazirlaniyor/uye-giris-banner-340x420.jpg" alt="">
			</div>
			
			<div class="uye_girisi">
				
				<div class="uye_girisi_baslik">ÜYELİKSİZ ALIŞVERİŞ</div>
				
				<div class="uye_girisi_icerik">
					
				<div class="ay_left">
					<strong>Üyeliksiz alışveriş yapabilmek için lütfen bilgileri doldurunuz.</strong>
					<br><br>

					<input type="text" class="uye_giris_input" placeholder="Ad">
					
					<input type="text" class="uye_giris_input" placeholder="Soyad">
					
					<input type="text" class="uye_giris_input" placeholder="E Mail">
					
					<a href="#" class="giris_buton"><i class="fa fa-user" aria-hidden="true"></i> Devam Et</a>
					
				</div>
				
				
			</div>
			
			<div class="clear"></div>
			
		</div>
		
		
		

	</div>
	

		
		<div class="container_ic">
	
			 @include('frontEnd.include.footerTop')		

			<div class="clear"></div>
		</div>
			
		
</div>

@endsection