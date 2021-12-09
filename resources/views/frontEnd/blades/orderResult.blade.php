@extends('frontEnd.layout.checkout')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@if($cart->status==true)
	@section('headscript')
		<!-- Event snippet for Donusum conversion page -->
		<script>
		  gtag('event', 'conversion', {
		      'send_to': 'AW-825155402/bhIsCN31jXoQyr67iQM',
		      'value': "{{ @number_format($order->grand_total,2) }}",
		      'currency': 'TRY',
		      'transaction_id': '{{@$cart->orderId}}'
		  });

		  gtag('event', 'page_view', {
			'send_to': 'AW-825155402/bhIsCN31jXoQyr67iQM',
		   	'ecomm_prodid': '{!! @json_encode(@array_map("strval",@$order->items->pluck("product_id")->toArray())) !!}',
		   	'ecomm_pagetype': 'purchase',
		   	'ecomm_totalvalue': '{{ @$order->grand_total }}'
		  });
		</script>
		<script>
			fbq('track', 'Purchase', {
				value: "{{ @number_format($order->grand_total,2) }}",
				currency: 'TRY',
				content_type: 'product',
				content_ids: '{!! @json_encode(@array_map("strval",@$order->items->pluck("product_id")->toArray())) !!}'
			});
		</script>
		<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
		<script>
 			window.___gcfg = {lang: 'tr'};
		  	window.renderOptIn = function() {
		    	window.gapi.load('surveyoptin', function() {
		      		window.gapi.surveyoptin.render({
						// REQUIRED FIELDS
						"merchant_id": 210590127,
						"order_id": "{{ @$cart->orderNo }}",
						"email": "{{ @Auth::guard('members')->user()->email }}",
						"delivery_country": "TR",
						"estimated_delivery_date": "{{ $deliveryDate }}", //YYYY-MM-DD
						// OPTIONAL FIELDS
						@if(count($order->items) > 0)
						"products": [{ 	"gtin":"{{ $order->items->first()->stock_code }}"}]
						@endif
			        });
		    	});
		  	}
		</script>
	@endsection

@endif

@section('content')
<div class="container">
	<div class="container_ic">
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('./')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<a href="{{url('sepet')}}">Sepetim</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Sipariş Onayı </span>
			</div>
		</div>
		<div class="tek_alan">
			<div class="sepet_adimlari">
				<div class="sa_alan saa_aktif">Sepetim</div>
				<div class="sa_alan saa_aktif">Fatura ve Teslimat</div>
				<div class="sa_alan saa_aktif">Ödeme İşlemi</div>
				<div class="sa_alan saa_aktif">Sipariş Onayı</div>
				<div class="clear"></div>
			</div>

			@if($cart->status == true)
				<div class="onay_alan">
					<img src="{{asset('images/onay.png')}}" alt="" class="onay_icon">

					<strong class="onay">Teşekkürler, {{ $cart->orderNo }} numaralı siparişiniz oluşturulmuştur.</strong>
					<span>
						İletmiş olduğunuz bilgiler başarıyla ulaşmıştır.
						<br>
						Anasayfaya dönmek için lütfen <a href="{{ url('/') }}">tıklayınız</a>
						@if(Auth::guard('members')->check() == true)
						. Siparişlerime gitmek için lütfen <a href="{{ url('hesabim/siparisler') }}">tıklayınız</a>.
						@endif
					</span>
				</div>
			@else
				<div class="onay_alan">
					<img src="{{asset('images/hata.png')}}" alt="" class="onay_icon">
					<strong class="hata">Üzgünüz, siparişiniz oluşturulamadı.</strong>
					<span>
						<strong>Hata mesajı:</strong> Tarafınızdan hiçbir ödeme alınmadı.
							@if(Session::has('message'))
							{{ Session::get('message') }}
							@endif
						İşlemi tekrar deneyebilir ya da bizimle irtibata geçerek detaylı bilgi alabilirsiniz.
						<br> 
						0 850 259 99 44 no'lu telefondan da siparişinizi hızlı bir şekilde verebileceğinizi hatırlatmak isteriz.
						<br>
						<a href="{{url('sepet')}}">Sipariş vermeyi tekrar denemek istiyorum.</a>
					</span>

				</div>
			@endif
		</div>
	</div>

</div>
@endsection

@section('scripts')

@if($cart->status==true)
<script>var prods = [];</script>
<!-- Google Code for siparis Conversion Page -->

<!-- kenshoo Code  -->
<script type="text/javascript" src="https://services.xg4ken.com/js/kenshoo.js?cid=f461840d-b109-4db2-b5d9-2243b490e956" ></script>
<script type="text/javascript">
	kenshoo.trackConversion('6013','f461840d-b109-4db2-b5d9-2243b490e956',{
		conversionType: 'conv',
		revenue: "{{ @number_format($order->grand_total,2) }}",
		currency: 'TRY',
		orderId:'{{ @$cart->orderId }}',
	});
</script>

<noscript>
   <img src="https://6013.xg4ken.com/pixel/v1?track=1&token=f461840d-b109-4db2-b5d9-2243b490e956&conversionType=conv&revenue={{@number_format($order->grand_total,2)}}&currency=TRY&orderId={{@$cart->orderId}}&promoCode=&customParam1=&customParam2=" width="1" height="1" />
</noscript>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-55907344-3', 'auto');
ga('require', 'ecommerce');
ga('ecommerce:addTransaction', { 'id': '{{@$cart->orderId}}', 'affiliation': 'Marketpaketi', 'revenue': '{{@number_format($order->grand_total,2)}}', 'shipping': '{{@number_format($order->shipping_amount,2)}}', 'tax': '{{@number_format($order->tax_amount,2)}}' });

@if(count($order->items)>0)
	@foreach($order->items as $item)
		ga('ecommerce:addItem', {
		'id': '{{@$cart->orderId}}',                     // Transaction ID. Required.
		'name': '{{$item->name}}',    // Product name. Required.
		'sku': '{{$item->stock_code}}',                 // SKU/code.
		'category': '',         // Category or variation.
		'price': '{{number_format($item->price,2)}}',                 // Unit price.
		'quantity': '{{$item->qty}}',                   // Quantity.
		'currency': 'TRY'  // local currency code.
		});
	@endforeach
@endif
ga('ecommerce:send');
</script>

<script>
	@if(count($order->items)>0)
		@foreach($order->items as $item)
		prods.push({
		    'id': '{{$item->product_id}}',
		    'price': '{{number_format($item->price,2)}}',
		    'quantity': '{{$item->qty}}'
		});
		@endforeach
	@endif
</script>

<!-- Criteo Sales Tag -->
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
	window.criteo_q = window.criteo_q || [];
	var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
	window.criteo_q.push(
		{ event: "setAccount", account: 26770}, // You should never update this line
		{ event: "setEmail", email: "" }, // Can be an empty string
		{ event: "setSiteType", type: deviceType},
		{ event: "trackTransaction", id: {{@$cart->orderId}}, item: prods}
	);
</script>
<!-- END Criteo Sales Tag -->
@endif

@endsection
