@extends('frontEnd.layout.master')

@section('pageTitle', "Marketpaketinde Satılan Markalar")
@section('pageDescription', "Marketpaketinde satılan markaları bu sayfadan inceleyebilirsiniz")
@section('canonical', '<link rel="canonical" href="'.url()->current().'"/>' )

@section('content')
<div class="container">
	<div class="container_ic">
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{ url('/') }}">Anasayfa</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Markalar</span>
			</div>
		</div>
		<div class="bilgi_icerik_full">
			<div class="bilgi_icerik_baslik_full">Marketpaketinde Satılan Markalar</div>
			<div class="brand-list">
                @foreach ($brands as $brand)
                    <a class="brand" href="{{ url($brand->slug) }}">
                        <div class="name">{{ $brand->name }}</div>
                        <div class="count"><b>{{ $brand->productsCount->count() }}</b> Ürün</div>
                    </a>
                @endforeach
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