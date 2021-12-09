@extends('frontEnd.layout.master')

@if(!empty(json_decode($article->seo,true)['seo_title']))
    @section('pageTitle', json_decode($article->seo,true)['seo_title'].' | www.marketpaketi.com.tr')
@else
    @section('pageTitle', $article->title.' | www.marketpaketi.com.tr')
@endif

@if(!empty(json_decode($article->seo,true)['seo_description']))
    @section('pageDescription', json_decode($article->seo,true)['seo_description'])
@endif

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
	        },
            {
               "@type": "ListItem",
               "position": "2",
               "item":
               {
                "@id": "{{url($article->slug)}}",
                "name": "{{$article->title}}"
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
				<a href="{{url('./alisveris-rehberi')}}">Alışveriş Rehberi</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>{{$article->title}}</span>
			</div>
		</div>

		<div class="ic_blog">
		
			<div class="ic_blog_ana_baslik">MARKET PAKETİ ALIŞVERİŞ REHBERİ</div>
			
			<div class="blog_reklam">
				
				<img src="{{asset('images/gorsel-hazirlaniyor/uye-ol-banner-224x500.jpg')}}" alt="">
				
				<img src="{{asset('images/gorsel-hazirlaniyor/uye-ol-banner-224x500.jpg')}}" alt="">
				
			</div>
			
			<div class="ic_blog_left">
				
				<div class="ic_blog_alan">
		
					<a href="javascript:void(0)" class="ic_blog_gorsel"><img src="{{asset('src/uploads/articles/'.$article->image)}}" alt="{{$article->title}}"></a>
					
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
						
						<div class="ic_blog_tarih">
							<a href="#">
								<i class="fa fa-thumbs-up" aria-hidden="true"></i>
								<span>( 3 )</span>
							</a>
							
							<a href="#">
								<i class="fa fa-thumbs-down" aria-hidden="true"></i>
								<span>( 0 )</span>
							</a>
						</div>
						
						*/ ?>
						<?php /*
						<a href="#" class="ic_blog_yorum">
							<i class="fa fa-comments-o" aria-hidden="true"></i>
							<span>Yorum (99)</span>
						</a>
						*/ ?>
						
					</div>
					
					<h1 href="javascript:void(0)" class="ic_blog_baslik">{{$article->title}}</h1>
					<br>
					<span class="ic_blog_icerik">
						{!!$article->content!!}
					</span>

					@if(!empty(json_decode($article->seo)->seo_keywords))
						<div class="ic_etiket">
							@foreach(explode(",",json_decode($article->seo)->seo_keywords) as $keyword)
								<a href="#"><i class="fa fa-tags" aria-hidden="true"></i> {{$keyword}}</a>
							@endforeach
						</div>
					@endif
					
					<div class="blog_sm">
					
						<!-- Go to www.addthis.com/dashboard to customize your tools -->
				 		<div class="addthis_inline_share_toolbox"></div>
				 
				 	</div>

				 	<?php 
/*
<div class="yorum_text">
				 	
				 		<div class="blog_yorum_yap">
				 			<i class="fa fa-comments-o" aria-hidden="true"></i>
							<span>Yorum Yap</span>
				 		</div>
				 		
				 		<div class="yt_satir">
				 			<i class="fa fa-comments" aria-hidden="true"></i>
				 			<div class="yt_icerik">
				 				<strong>Mehmet Yılmaz</strong>
				 				<span>Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 
				 				1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi 
				 				Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları.</span>
				 			</div>
				 		</div>
				 		
				 		<div class="yt_satir">
				 			<i class="fa fa-comments" aria-hidden="true"></i>
				 			<div class="yt_icerik">
				 				<strong>Mehmet Yılmaz</strong>
				 				<span>Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 
				 				1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi 
				 				Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları.</span>
				 			</div>
				 		</div>
				 		
				 		<div class="yt_satir">
				 			<i class="fa fa-comments" aria-hidden="true"></i>
				 			<div class="yt_icerik">
				 				<strong>Mehmet Yılmaz</strong>
				 				<span>Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 
				 				1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi 
				 				Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları.</span>
				 			</div>
				 		</div>
				 		
				 	</div>
					
					
					<div class="blog_yorum">
						
						<input type="text" name="" placeholder="Ad Soyad" class="by_input">
							
						<input type="text" name="" placeholder="E Mail" class="by_input">
						
						<div class="clear"></div>
							
						<textarea placeholder="Mesaj" class="by_text"></textarea>
							
						<a href="#" class="by_buton"><i class="fa fa-comments" aria-hidden="true"></i> Yorum Yap</a>
							
					</div>
*/
				 	?>
				 	
				 	
					
					
					
					
				</div>
		
				
			</div>
			
			<div class="ic_blog_right">
				<?php /*
				<div class="ibr_blok">
					<strong><i class="fa fa-list" aria-hidden="true"></i> Kategoriler</strong>
					<ul>
						@foreach($artCats as $item)
							<li><a href="{{url('blog/'.$item->slug)}}"><img src="{{asset('src/uploads/blogCategory/'.$item->image)}}" alt=""> <span>{{$item->title}}</span></a></li>
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
							<li><a href="{{url('alisveris-rehberi/'.$otherItem->slug)}}"><img src="{{asset('src/uploads/articles/'.$otherItem->image)}}" alt="{{$otherItem->title}}"> <span>{{$otherItem->title}}</span></a></li>
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
			
			
		</div>


		

	</div>
	
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-595cade47ee91a8c"></script>
@endsection