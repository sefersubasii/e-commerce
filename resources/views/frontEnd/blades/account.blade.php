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
				<span>Hesabım</span>
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

			<div class="bilgi_icerik_baslik">HESABIM</div>
			
			<div class="bilgi_icerik_ic">

				<form id="account" method="POST" action="{{url('hesabim')}}">
	
				<div class="satir">
					<div class="satir_baslik">Ad</div>
					<span class="satir_nokta">:</span>
					<input name="name" type="text" class="uye_input {{ $errors->first('name') ? "err" : "" }}" value="{{$user->name}}">
				</div>
				
				<div class="satir">
					<div class="satir_baslik">Soyad</div>
					<span class="satir_nokta">:</span>
					<input name="surname" type="text" class="uye_input {{ $errors->first('surname') ? "err" : "" }}" value="{{$user->surname}}">
				</div>
				
				<div class="satir">
					<div class="satir_baslik">Email</div>
					<span class="satir_nokta">:</span>
					{{$user->email}}
				</div>
							
				<div class="satir">
					<div class="satir_baslik">Cinsiyet</div>
					<span class="satir_nokta">:</span>
					<label>
						<input name="gender" value="1" type="radio" class="uye_radio" {{$user->gender == 1 ?'checked':''}}>
						<span>Erkek</span>
					</label>
					<label>
						<input name="gender" value="2" type="radio" class="uye_radio" {{$user->gender == 2 ?'checked':''}}>
						<span>Kadın</span>
					</label>
				</div>
				<div class="satir">
					<div class="satir_baslik">Doğum Tarihi</div>
					<span class="satir_nokta">:</span>
					<select name="day" id="" class="dt_select">
						@for($i=1;$i<=31;$i++)
							<option {{ $user->bday == null ? '' : Carbon\Carbon::parse($user->bday <= 9 ? "0".$user->bday : $user->bday )->format('d')==$i ? 'selected':'' }}>{{$i <= 9 ? "0".$i : $i }}</option>
						@endfor
					</select>
					<select name="month" id="" class="dt_select">
						@for($i=1;$i<=12;$i++)
							<option {{$user->bday == null ? '' : Carbon\Carbon::parse($user->bday <= 9 ? "0".$user->bday : $user->bday )->format('m')==$i ? 'selected':''}}>{{$i <= 9 ? "0".$i : $i }}</option>
						@endfor
					</select>
					<select name="year" id="" class="dt_select">
						@for($i=1960;$i<=Carbon\Carbon::now()->year-12;$i++)
							<option {{ $user->bday == null ? '' : Carbon\Carbon::parse($user->bday)->format('Y')==$i ? 'selected':''}}>{{$i}}</option>
						@endfor
					</select>
				</div>
				
				<div class="satir">
					<div class="satir_baslik">Telefon</div>
					<span class="satir_nokta">:</span>
					<input name="phone" type="text" class="uye_input phoneMask {{ $errors->first('phone') ? "err" : "" }}" value="{{$user->phone}}">
				</div>
				
				<div class="satir">
					<div class="satir_baslik">Cep Telefonu</div>
					<span class="satir_nokta">:</span>
					<input name="phoneGsm" type="text" class="uye_input phoneMask {{ $errors->first('phoneGsm') ? "err" : "" }}" value="{{$user->phoneGsm}}">
				</div>
				
				<div class="satir">
					<div class="satir_baslik">Güvenlik Kodu</div>
					<span class="satir_nokta">:</span>

					<img id="captchaCode" onclick="this.src='{{url('/')}}/captcha/default?'+Math.random()" src="{{captcha_src()}}" alt="" class="uye_uyari">
					<a style="float: left" rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='captcha/default?'+Math.random()" class="reflash"><i class="fa fa-refresh" aria-hidden="true"></i></a>
					<input name="captcha" type="text" class="uye_input2 {{ $errors->first('captcha') ? "err" : "" }}">
				</div>
				
				<div class="satir s_left">
					<label>
						<input {{ $user->allowed_to_mail == 1 ? 'checked' : '' }} name="allowed_to_mail" type="checkbox" class="uye_chec">
						<span>Kampanyalardan haberdar olmak istiyorum</span>
					</label>
				</div>
				
				
				<a onclick="$('#account').submit()" href="javascript:void(0)" class="uye_buton"><i class="fa fa-file-text" aria-hidden="true"></i> Değişikliği Kaydet</a>

				<input name="_token" value="{{csrf_token()}}" type="hidden">

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