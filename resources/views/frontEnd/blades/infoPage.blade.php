@extends('frontEnd.layout.master')

@if(!empty(json_decode($data->seo,true)['seo_title']))
    @section('pageTitle', json_decode($data->seo,true)['seo_title'])
@else
    @section('pageTitle', $data->title)
@endif


@if(!empty(json_decode($data->seo,true)['seo_description']))
    @section('pageDescription', json_decode($data->seo,true)['seo_description'])
@else
    @section('pageDescription', $settings['seo']->seo_description)
@endif

@if(isset($canonical))
    @section('canonical', '<link rel="canonical" href="$canonical"/>' )
@else
    @section('canonical', '<link rel="canonical" href="'.url()->current().'"/>' )
@endif

@section('content')


<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('./')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>{{$data->title}}</span>
			</div>
		</div>
		
		<div class="bilgi_left">
			
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

			<div class="bilgi_icerik_baslik">{{$data->title}}</div>
			
			<div class="bilgi_icerik_ic">
				
				{!!$data->content!!}
			
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
