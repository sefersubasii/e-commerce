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

			<div class="bilgi_icerik_baslik">ŞİFREMİ DEĞİŞTİR</div>

			@if(session()->has('message'))
			    <div class="alert alert-success">
			        {{ session()->get('message') }}
			    </div>
			@endif
			
			<div class="bilgi_icerik_ic">

				<form method="POST" action="{{url('hesabim/sifre-degistir')}}">

					<div class="satir">
						<div class="satir_baslik">Şifre</div>
						<span class="satir_nokta">:</span>
						<input name="password" type="password" class="uye_input {{ $errors->first('password') ? "err" : "" }}">
					</div>

					<div class="satir">
						<div class="satir_baslik">Şifre ( Tekrar )</div>
						<span class="satir_nokta">:</span>
						<input name="password_confirm" type="password" class="uye_input {{ $errors->first('password_confirm') ? "err" : "" }}">
					</div>

					<input type="hidden" name="_token" value="{{csrf_token()}}">

					<button class="uye_buton" type="submit"><i class="fa fa-lock" aria-hidden="true"></i>Değişikliği Kaydet</button>

				</form>

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