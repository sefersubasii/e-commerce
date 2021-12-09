@extends('frontEnd.layout.master')

@section('pageTitle', 'Alışveriş Rehberi - Online Market | www.marketpaketi.com.tr')

@section('pageDescription', 'Online market alışverişi yapmadan önce alıveriş rehberine göz atarak, satın almayı düşündüğünüz tüm ürünler hakkında detaylı bilgi www.marketpaketi.com.tr\'de!')

@if(isset($canonical))
    @section('canonical', '<link rel="canonical" href="$canonical"/>' )
@else
    @section('canonical', '<link rel="canonical" href="'.url()->current().'"/>' )
@endif

@section('content')

<div class="container">

    <script type="application/ld+json">
    {
     "@context": "http://schema.org",
     "@type": "BreadcrumbList",
     "itemListElement":
     [
         {
           "@type": "ListItem",
           "position": "1",
           "item":
           {
            "@id": "https://www.marketpaketi.com.tr/alisveris-rehberi",
            "name": "Alışveriş Rehberi"
            }
          }
     ]
    }
    </script>

	<div class="container_ic">
		

		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('./')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Alışveriş Rehberi</span>
			</div>
		</div>

		<div class="ic_blog">
		
			<h2 class="ic_blog_ana_baslik">MARKET PAKETİ ALIŞVERİŞ REHBERİ</h2>
			
			<div class="blog_reklam">
				
				<img src="{{asset('images/gorsel-hazirlaniyor/uye-ol-banner-224x500.jpg')}}" alt="">
				
				<img src="{{asset('images/gorsel-hazirlaniyor/uye-ol-banner-224x500.jpg')}}" alt="">
				
			</div>
			
			<div class="ic_blog_left">

				@foreach($articles as $article)
				
				<div class="ic_blog_alan">
				
					<a href="{{url('alisveris-rehberi/'.$article->slug)}}" class="ic_blog_gorsel"><img src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/articles/'.$article->image)}}" alt="{{$article->title}}"></a>
					
					<div class="ic_blog_bilgi">
						<div class="ic_blog_tarih">
							<i class="fa fa-calendar" aria-hidden="true"></i>
							<span>{{Carbon\Carbon::parse($article->created_at)->format('d.m.Y')}}</span>
						</div>
						<?php /*
						<div class="ic_blog_tarih">
							<i class="fa fa-eye" aria-hidden="true"></i>
							<span>( 89 )</span>
						</div>
						
						<a href="#" class="ic_blog_yorum">
							<i class="fa fa-comments-o" aria-hidden="true"></i>
							<span></span>
						</a>
						*/ ?>
					</div>
					
					<h4><a href="{{url('alisveris-rehberi/'.$article->slug)}}" class="ic_blog_baslik">{{$article->title}}</a></h4>
					<br>
					<span class="ic_blog_icerik">
						{!!  str_limit($article->content, 500,'...') !!}
					</span>

					@if(!empty(json_decode($article->seo)->seo_keywords))
						<div class="ic_etiket">
							@foreach(explode(",",json_decode($article->seo)->seo_keywords) as $keyword)
								<a href="javascript:void(0)"><i class="fa fa-tags" aria-hidden="true"></i> {{$keyword}}</a>
							@endforeach
						</div>
					@endif
					
				</div>

				@endforeach
				
			</div>
			
			<div class="ic_blog_right">
				<?php /*
				<div class="ibr_blok">
					<strong><i class="fa fa-list" aria-hidden="true"></i> Kategoriler</strong>
					<ul>
						@foreach($artCats as $item)
							<li><a href="{{url('alisveris-rehberi/'.$item->slug)}}"><img src="{{asset('src/uploads/blogCategory/'.$item->image)}}" alt=""> <span>{{$item->title}}</span></a></li>
						@endforeach
					</ul>
				</div>
				
				<div class="ibr_blok">
					
					<div class="blog_arama">
						<input type="text" placeholder="Blog yazısı ara..." class="ba_input">
						<a href="#" class="ba_buton"><i class="fa fa-search" aria-hidden="true" ></i></a>
					</div>
				</div>
 				*/ ?>
				
				<div class="ibr_blok">
				
					<strong><i class="fa fa-comments" aria-hidden="true"></i> Diğer Yazılar</strong>

					<ul>
						@foreach($other as $otherItem)
							<li><a href="{{url('alisveris-rehberi/'.$otherItem->slug)}}"><img src="{{asset('https://d151fsz95gwfi2.cloudfront.net/src/uploads/articles/'.$otherItem->image)}}" alt="{{$otherItem->title}}"> <span>{{$otherItem->title}}</span></a></li>
						@endforeach
					</ul>
				
				</div>
				
				<div class="ibr_blok">
					<strong>Bülten</strong>
					
					<span>Ücretsiz olarak e-bülten aboneliğinizi başlatarak yeni
					kampanya ve ürünlerimizden anında haberdar olun!</span>
						
					<div class="blog_arama">
						<input type="text" placeholder="E-Mail adresinizi yazınız" class="ba_input">
						<a href="#" class="ba_buton"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
					</div>
					
				</div>
				
			</div>
			
			<div class="clear"></div>

			@include('pagination.custom',['paginator'=>$articles])

			<?php /*
			<div class="blog_sayfalama">
				
				<a href="#" class="blog_say"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
				<a href="#" class="blog_say">1</a>
				<a href="#" class="blog_say blog_say_aktif">2</a>
				<a href="#" class="blog_say">3</a>
				<a href="#" class="blog_say">4</a>
				<a href="#" class="blog_say">5</a>
				<a href="#" class="blog_say">6</a>
				<a href="#" class="blog_say">7</a>
				<a href="#" class="blog_say">8</a>
				<a href="#" class="blog_say">9</a>
				<a href="#" class="blog_say"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
				
			</div>
			*/ ?>
		</div>

	</div>

</div>
@endsection
