@extends('frontEnd.layout.master')

@section('content')
<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('/')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Siparişlerim</span>
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

			<div class="bilgi_icerik_baslik">SİPARİŞLERİM</div>
			
			<div class="bilgi_icerik_ic">
			
				<div class="siparis_tab_alan">
				
					<div class="siparis_tab">
						<span class="siparis_link"><a id="orderlink1" href="#sip1">Siparişlerim</a></span>
	                    <span class="siparis_link"><a id="orderlink2" href="#sip2">İade ve İptal Taleplerim</a></span>
					</div>
	            
	            	<div class="siparis_container">
	            	
						<div id="sip1" class="siparis_content">
							
							<div class="clear"></div>
							
							<div class="siparis_alan">

								<ul class="siparis_alan_baslik">
									<li>Ref No</li>
									<li>Ödeme Türü</li>
									<li>Kargo Bilgileri</li>
									<li>Durumu</li>
									<li>Sipariş Tarihi</li>
									<li>Toplam Tutar</li>
									<li><i class="fa fa-pencil-square" aria-hidden="true"></i></li>
									<li><i class="fa fa-cube" aria-hidden="true"></i></li>
									<li><i class="fa fa-print" aria-hidden="true"></i></li>
									<li><i class="fa fa-repeat" aria-hidden="true"></i></li>
									<li><i class="fa fa-exchange" aria-hidden="true"></i></li>
									<li><i class="fa fa-print" aria-hidden="true"></i></li>
								</ul>

								@foreach($orders as $order)
									<ul class="siparis_alan_icerik">
										<li>{{ $order->order_no }}</li>
										<li>{{ $order->payment }}</li>
										<li>
											{{ $order->shippingCompany->name }} 
											<br> 
											@if($order->shipping_no)
												Kargo Takip No {{ $order->shipping_no }}
											@endif
										</li>
										<li>{{ $order->statusText }}</li>
										<li>
											{{ $order->created_at->format('d-m-Y') }} 
											<br> 
											{{ $order->created_at->format('H:i:s') }}
										</li>
										<li>
											{{ $myPrice->currencyFormat($order->grand_total) }} TL
										</li>
										<li><a data-src="{{url('order/detail/'.$order->id)}}" href="{{url('order/detail/'.$order->id)}}" data-fancybox="ajax" data-type="ajax" title="Sipariş Detayları"><i class="fa fa-pencil-square" aria-hidden="true"></i></a></li>
										<li><a data-src="{{url('order/shippingInfo/'.$order->id)}}" href="{{url('order/shippingInfo/'.$order->id)}}" data-fancybox="ajax" data-type="ajax" title="Teslimat Bilgileri"><i class="fa fa-cube" aria-hidden="true"></i></a></li>
										<li><a href="#" title="Kargo Bilgilerini Yazdır"><i class="fa fa-print" aria-hidden="true"></i></a></li>
										<li>
											{{-- onclick="repeatOrder(this, event, {{ $order->id }})" --}}
											<a 
												{{-- href="{{ route('member.repeat-order', $order->id) }}"  --}}
												href="#"
												onclick="repeatOrderStock(this, event)"
												data-url="{{ route('member.repeat-order', $order->id) }}"
												data-stock-url="{{ route('member.repeat-order.stock', $order->id) }}"
												title="Bu Siparişi Tekrarla"
											>
												<i class="fa fa-repeat" aria-hidden="true"></i>
											</a>
										</li>
										@if($order->refundRequest)
											<li><a href="javascript:void(0);" onclick="$('#orderlink2').trigger('click');" title="Bu sipariş için istek bulunduğundan işlem gerçekleştirilemez."><i class="fa fa-exchange" aria-hidden="true"></i></a></li>
										@else
										<li><a href="{{url('refundRequest/' . $order->id)}}" title="Yasal iptal ve iade süresi dolan siparişler için bu işlem gerçekleştirilemez."><i class="fa fa-exchange" aria-hidden="true"></i></a></li>
										@endif
										<li><a href="#" title="Sipariş Detaylarını Yazdır"><i class="fa fa-print" aria-hidden="true"></i></a></li>
									</ul>
								@endforeach

							</div>
							
							<div class="clear"></div>
		
						</div>
						
						<div id="sip2" class="siparis_content">
							
							<div class="clear"></div>

							<div class="iptal_iade">

								<ul class="siparis_alan_baslik">
									<li>Sipariş Ref No</li>
									<li>Talep Kodu</li>
									<li>Ödeme Türü</li>
									<li>Talep Durumu</li>
									<li>İade Tutar</li>
									<li>Talep Tarihi</li>
									<li><i class="fa fa-list-ul" aria-hidden="true"></i></li>
								</ul>

								@foreach($user->refundRequest as $k => $v)
									<ul class="siparis_alan_icerik">
										<li>{{$v->order->order_no}}</li>
										<li>{{$v->code}}</li>
										<li>{{$v->order->payment}}</li>
										<li>{{$v->status == 1 ? 'Onaylandı.':'Onay bekliyor.'}}</li>
										<li>{{$myPrice->currencyFormat($v->refundAmount)}} TL</li>
										<li>{{Carbon\Carbon::parse($v->created_at)->format('d-m-Y H:i:s')}}</li>
										<li><a href="#iptal_detay{{$v->id}}" title="Sipariş Detayları" class="fancybox"><i class="fa fa-list-ul" aria-hidden="true"></i></a></li>
									</ul>
									<div style="display:none;" id="iptal_detay{{$v->id}}">
									
										<div class="sip_baslik"> İade ve İptal Talebi</div>
									
										<div class="sip_detay">
											<ul class="sip_detay_satir">
												<li><strong>Ref No</strong></li>
												<li><strong>:</strong></li>
												<li>{{$v->order->order_no}}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>İade Talebi Kodu</strong></li>
												<li><strong>:</strong></li>
												<li>{{$v->code}}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>Ödeme Türü</strong></li>
												<li><strong>:</strong></li>
												<li>{{$v->order->payment}}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>Talep Durumu</strong></li>
												<li><strong>:</strong></li>
												<li>{{$v->status == 1 ? 'Onaylandı.':'Onay Bekliyor.' }}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>Sipariş Tarihi</strong></li>
												<li><strong>:</strong></li>
												<li>{{Carbon\Carbon::parse($v->order->created_at)->format('d-m-Y H:i:s')}}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>İade Talebi Tarihi</strong></li>
												<li><strong>:</strong></li>
												<li>{{Carbon\Carbon::parse($v->created_at)->format('d-m-Y H:i:s')}}</li>
											</ul>
											<ul class="sip_detay_satir">
												<li><strong>Toplam Tutar</strong></li>
												<li><strong>:</strong></li>
												<li>{{$myPrice->currencyFormat($v->refundAmount)}} TL</li>
											</ul>
											<div class="iptal_detay_alan">
											
												<ul class="siparis_detay_baslik">
													<li>Ürün Adı</li>
													<li>İade Miktarı</li>
													<li>İade Sebebi</li>
													<li>İade Açıklaması</li>
												</ul>
												
												@foreach($v->products as $pro => $p)
													<ul class="siparis_detay_icerik">
														<li>{{$p->product->name}}</li>
														@if($p->status==0)
														<li>0</li>
														@else
														<li>{{$p->qty}}</li>
														@endif
														<li>{{$p->description}}</li>
														<li>{{$p->description}}</li>
													</ul>
												@endforeach
											</div>	
										</div>
									</div>
								@endforeach
							</div>
						</div>
							
						<div class="liste_secenek">
							
							<a href="#" class="ls_yenile">Yenile</a>
							<?php /*
							<div  class="ls_sec_alan">
								<span>Kayıt Sayısı Seçiniz :</span>
								<select name="" id="" class="ls_sec">
									<option>10</option>
								</select>
							</div>
							
							<div  class="ls_sec_alan">
								<span>Sayfa Seçiniz :</span>
								<select name="" id="" class="ls_sec">
									<option>1</option>
								</select>
							</div>
							*/ ?>
						</div>
						
						<div class="clear"></div>
							
					</div>

				</div>
		
			</div>
				
		</div>
			
		<div class="clear"></div>

	</div>

	<div class="clear"></div>

	<div class="container_ic">
		@include('frontEnd.include.footerTop')
		<div class="clear"></div>
	</div>

</div>

<style>
	.repeatOrderTable {
		width: 100%;
		border:1px solid #ddd;
		border-collapse: collapse;
		font-size: 13px;
	}
	.repeatOrderTable .list-head {
		color:#000;
		background: #ddd;
	}
	.repeatOrderTable .list-head td {
		border:1px solid #999;
	}

	.repeatOrderTable tr,
	.repeatOrderTable td {
		border: 1px solid #999;
		padding: 5px;
	}

	.repeatOrderTable .max_stock {
		/* background: #000; */
		/* color:#fff; */
	}

	.repeatOrderStockList .error_text {
		color:red;
		font-size:14px;
		margin-bottom: 5px;
	}
</style>
@endsection

@section('scripts')
	<script>
		async function repeatOrder(elem, event){
			event.preventDefault();

			// await Swal.fire("", "Ürünlerin miktarları kullanılabilir stok sayılarına göre düzeltilecektir. <br><br> <u>Sepet adımında ürün miktarlarını kontrol edin!</u>", "warning");

			var url = $(elem).data('url');

			$.get(url, function(response){
				if(!response){
					Swal.fire("", "İşlemler sırasında bir hata oluştu!", "error");
				}

				response.forEach(function(item){
					$.post("{{ url('getAddToCart') }}", {
						product_id: item.product_id,
						quantity: item.quantity,
						_token: "{{ csrf_token() }}"
					}, function(response){
						console.log(response);
					});	
				});
			});
		};

		async function repeatOrderStock(elem, event){
			event.preventDefault();

			var confirm = await Swal.fire({
				title: 'Seçilen siparişteki ürünler sepete eklensin mi?',
				icon: 'warning',
				showCancelButton: true,
				showConfirmButton: true,
				confirmButtonText: "Evet",
				cancelButtonText: "İptal Et"
			});


			if(!confirm.hasOwnProperty('value') || !confirm.value){
				return;
			}

			$.get($(elem).data('stock-url'), async function(response){
				if(!response){
					return;
				}

				var stockWarning = false;
				var genel = $('<div/>').addClass('repeatOrderStockList');

				if(response.hasOwnProperty('stokYok') && response.stokYok.length){
					var stokYokList = $('<table/>')
									.addClass('repeatOrderTable')
									.append('<tr class="list-head"><td width="70%">Ürün</td><td width="15%">Sipariş Miktarı</td><td width="15%" class="max_stock">Stok Miktarı</td></tr>');
					response.stokYok.forEach(function(item){
						stokYokList.append('<tr><td>'+item.name+'</td><td>'+item.quantity+'</td><td class="max_stock">'+item.maxStock+'</td></tr>');
					});
					genel.append('<h4>Stoğu Olmayan Ürünler</h4><br>');
					genel.append('<p class="error_text">Stoğu olmayan ürünler sepete eklenemeyecek!!</p>');
					genel.append(stokYokList);
					stockWarning = true;
				}
				

				if(response.hasOwnProperty('stokYetersiz') && response.stokYetersiz){
					var stokYetersizList = $('<table/>')
										.addClass('repeatOrderTable')
										.append('<tr class="list-head"><td width="70%">Ürün</td><td width="15%">Sipariş Miktarı</td><td width="15%" class="max_stock">Stok Miktarı</td></tr>');
					response.stokYetersiz.forEach(function(item){
						stokYetersizList.append('<tr><td>'+item.name+'</td><td>'+item.quantity+'</td><td class="max_stock">'+item.maxStock+'</td></tr>');
					});

					genel.append('<br><h4>Stoğu Yetersiz Ürünler</h4><br>');
					genel.append('<p class="error_text">Sipariş miktarından düşük stoğu olan ürünlerin sipariş miktarı ürün stok miktarı olarak eklenecektir!</p>');
					genel.append(stokYetersizList);
					stockWarning = true;
				}

				if(stockWarning){
					var confirm = await Swal.fire({
						html: genel,
						width: ($(window).width() <= 768 ? '100%' : '60%'),
						showCancelButton: true,
						showConfirmButton: true,
						confirmButtonText: "Onayla",   
						cancelButtonText: "İptal Et",   
					});

					if(!confirm.hasOwnProperty('value') || !confirm.value){
						return;
					}
				}

				window.location.href = $(elem).data('url');
			});
		};
	</script>	
@endsection
