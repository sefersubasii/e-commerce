@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')

<div class="container">

	<div class="container_ic">

		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('./')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>İletişim Formu</span>
			</div>
		</div>

		<div class="bilgi_left">

			<img src="{{url('src/images/iletisim.jpg')}}" alt="">

		</div>

		<div class="bilgi_icerik">

			<div class="bilgi_icerik_baslik">İLETİŞİM FORMU</div>

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

                @if(Session::has('error'))
					<div class="error">
						{{Session::get('error')}}
					</div>
                @endif

                @if(Session::has('success'))
					<div class="success">
						{{Session::get('success')}}
					</div>
                @endif

				<form id="contactForm" action="{{url('iletisim-formu')}}" method="post">

					<div class="satir">
						<div class="satir_baslik">Ad Soyad</div>
						<span class="satir_nokta">:</span>
						<input value="{{old('name')}}" name="name" type="text" class="uye_input {{ $errors->first('name') ? "err" : "" }}">
					</div>

					<div class="satir">
						<div class="satir_baslik">Email</div>
						<span class="satir_nokta">:</span>
						<input value="{{old('email')}}" name="email" type="text" class="uye_input {{ $errors->first('email') ? "err" : "" }}">
					</div>

					<div class="satir">
						<div class="satir_baslik">Telefon</div>
						<span class="satir_nokta">:</span>
						<input value="{{old('phone')}}" name="phone" type="text" class="uye_input {{ $errors->first('phone') ? "err" : "" }}">
					</div>

					<div class="satir">
						<div class="satir_baslik">Konu</div>
						<span class="satir_nokta">:</span>
						<input value="{{old('subject')}}" name="subject" type="text" class="uye_input {{ $errors->first('subject') ? "err" : "" }}">
					</div>

					<div class="satir">
						<div class="satir_baslik">Mesaj</div>
						<span class="satir_nokta">:</span>
						<textarea  name="message" class="uye_adres_text {{ $errors->first('message') ? "err" : "" }}">{{old('message')}}</textarea>
					</div>


					<div class="satir">
						<div class="satir_baslik">Güvenlik Kodu</div>
						<span class="satir_nokta">:</span>
						<img id="captchaCode" onclick="this.src='{{url('/')}}/captcha/default?'+Math.random()" src="{{captcha_src()}}" alt="" class="uye_uyari">
						<a style="float: left" rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='captcha/default?'+Math.random()" class="reflash"><i class="fa fa-refresh" aria-hidden="true"></i></a>
						<input name="captcha" type="text" class="uye_input2 {{ $errors->first('captcha') ? "err" : "" }}">
					</div>

					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<a href="javascript:void(0)" onclick="$('#contactForm').submit()" class="uye_buton"><i class="fa fa-envelope-o" aria-hidden="true"></i> Gönder</a>

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
