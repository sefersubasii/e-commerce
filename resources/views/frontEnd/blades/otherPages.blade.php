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
				<a href="{{url('./')}}">Anasayfa</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>{{$data->title}}</span>
			</div>
		</div>
		
		<?php /*?><div class="bilgi_left">
			
			<div class="bilgi_left_blok">
				
				<div class="blb_baslik">DİĞER SAYFALAR</div>

				

				@if(count($allPages))
				<ul class="blb_icerik">
					@foreach($allPages as $page)
						<li><a href="{{url('sayfa/'.$page->slug)}}">{{$page->title}}</a></li>
					@endforeach
				</ul>
				@else
				<p>
					Başka Sayfa Bulunmuyor.
				</p>
				@endif

			</div>
			
		</div><?php */?>
		
		<div class="bilgi_icerik_full">

			@if($data->title!="Ayda bir kampanyası")

			<div class="bilgi_icerik_baslik_full">{{$data->title}}</div>
			
			@endif

			<div class="bilgi_icerik_ic_full">
				
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