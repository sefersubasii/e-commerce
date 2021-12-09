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
				<span>İletişim</span>
			</div>
		</div>

		<div class="bilgi_left">

			<img src="{{url('src/images/iletisim.jpg')}}" alt="">

		</div>

		<div class="bilgi_icerik">

			<div class="bilgi_icerik_baslik">İLETİŞİM</div>

			<div class="bilgi_icerik_ic">




				<div class="iletisim_left">

					<div class="satir_text">
						<strong class="satir_baslik_text">Firma Resmi Adı </strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_name}}</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Telefon 1</strong>
						<span class="satir_icerik_text">: <a href="tel:{{str_replace(' ','',$settings["company"]->company_phone)}}">{{$settings["company"]->company_phone}}</a></span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Fax</strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_fax}}</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Adres</strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_address}}</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Vergi No</strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_tax_id}}</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Vergi Dairesi</strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_tax_office}}</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">Lojistik Depo </strong>
						<span class="satir_icerik_text">: {{$settings["company"]->company_logistics}}</span>
					</div>
					<div class="satir_text">
						<strong class="satir_baslik_text">Kep Adresi </strong>
						<span class="satir_icerik_text">: <a href="mailto:ozkoru@hs01.kep.tr">ozkoru@hs01.kep.tr</a></span>
					</div>
					<div class="satir_text">
						<strong class="satir_baslik_text">Mersis NO </strong>
						<span class="satir_icerik_text">: 0662073848600011</span>
					</div>
					<div class="satir_text">
						<strong class="satir_baslik_text">Mensubu Olduğu Sektörel Kuruluş </strong>
						<span class="satir_icerik_text">: Elektronik Ticaret İşletmecileri Derneği, Ankara Ticaret Odası</span>
					</div>

					<div class="satir_text">
						<strong class="satir_baslik_text">İletişim Formu </strong>
						<span class="satir_icerik_text">: <a href="{{url('iletisim-formu')}}">İletişim Formu</a></span>
					</div>

				</div>

				<div class="iletisim_right">

					@foreach($settings["banks"] as $bank)
					<div class="iletisim_hesap">
						<div class="iletisim_hesap_satir"><img src="{{url('src/uploads/banks/'.$bank->image)}}" alt=""></div>

						<div class="iletisim_hesap_satir">
							<strong>Banka İsmi</strong>
							<span>{{$bank->name}}</span>
						</div>
						<div class="iletisim_hesap_satir">
							<strong>Hesap Sahibi</strong>
							<span>{{$bank->owner}}</span>
						</div>

						<div class="iletisim_hesap_satir">
							<strong>Hesap Türü</strong>
							<span>{{$bank->currency}}</span>
						</div>

						<div class="iletisim_hesap_satir">
							<strong>IBAN Numarası</strong>
							<span>{{$bank->iban}}</span>
						</div>
					</div>
					@endforeach


				</div>


				<div class="clear"></div>
				<hr style="border:none; border-bottom:1px solid #ddd;"><br>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3058.6651052949196!2d32.89523631563878!3d39.94888009188327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d34dff48674a15%3A0x82acc22dd7ead2f8!2sMarketpaketi!5e0!3m2!1str!2str!4v1555681734416!5m2!1str!2str" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

			</div>

		</div>

		<div class="clear"></div>


	</div>



		<div class="container_ic">
			@include('frontEnd.include.footerTop')

			<div class="clear"></div>
		</div>


@endsection

</div>
