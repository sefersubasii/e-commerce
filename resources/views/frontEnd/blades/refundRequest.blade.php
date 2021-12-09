@extends('frontEnd.layout.master')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')



<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('')}}">Sanal Market</a>
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

			<div class="bilgi_icerik_baslik">İPTAL İADE İŞLEMLERİ</div>
			
			<div class="bilgi_icerik_ic">
			
			<div class="siparis_tab_alan">
			

            	<div class="siparis_container">
            	

						<div class="siparis_alan">

							<ul class="ii_islemleri_baslik">
								<li></li>
								<li>Ürün Adı</li>
								<li>İade Edilen Miktar</li>
								<li>Satın Alınan Miktar</li>
								<li>Stok Kodu</li>
								<li>KDV</li>
								<li>Fiyat</li>
								<li>Sebep</li>
							</ul>


							@if($order!=null)

							@foreach($order->items as $key => $value)

								<ul class="ii_islemleri_icerik">
									<li><input data-no="{{$value['product_id']}}" class="check" type="checkbox"></li>
									<li id="name{{$value['product_id']}}">{{$value["name"]}}</li>
									<li>
										<select name="qty{{$value['product_id']}}" class="miktar_select">
											@for($i = 1 ; $i <= $value["qty"]; $i++)
												<option>{{$i}}</option>
											@endfor
										</select>
									</li>
									<li>{{$value["qty"]}}</li>
									<li>{{$value["stock_code"]}}</li>
									<li>{{$value->product->tax}}</li>
									<li>{{$myPrice->currencyFormat($value['price'])}} TL</li>
									<li>
										<select name="reason{{$value['product_id']}}" class="sebep_select">
											<option>Ürünü iade etmek istiyorum.</option>
											<option>Ürünü değiştirmek istiyorum.</option>
											<option>Faturadaki ürünler ile bana gelen ürünler farklı.</option>
											<option>Diğer</option>
										</select>
									</li>
								</ul>

							@endforeach

							@endif
							
							

							

						</div>

						<div class="clear"></div>
	
					</div>
					
					
					<div class="ii_orta_alan">
						
						<label class="ii_left">
							<input  type="checkbox" class="ii_chec confirm">
							<span>İade ve Geri Gönderim Şartlarını okudum, kabul ediyorum.</span>
						</label>
						
						<button class="ii_buton nextStepRefund" type="submit">Devam Et</button>
						
						<div class="clear"></div>
						
					</div>

					<form name="refoundRequestAdd" method="POST">
					
						<div style="display:none;" class="dynamic">
						
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<button class="ii_tamamla" style="display:none;" type="submit" ><i class="fa fa-check" aria-hidden="true"></i> İşlemi Tamamala</button>
					</form>
					<div class="clear"></div>
				
					
				</div>
				
			</div>
				
			
			<div class="clear"></div>	

		</div>
			
		<div class="clear"></div>
		
	</div>
		
		<div class="container_ic">
		
			@include('frontEnd.include.footerTop')

			<div class="clear"></div>

		</div>
		
</div>
@endsection

@section('scripts')

<script>
	$('.nextStepRefund').on('click',function(){

		if ($('.check:checked').length>0) {

			if ($('.confirm:checked').length>0) {
				$('.dynamic').html('');
				$('.check:checked').each(function () {
					var no = $(this).attr('data-no');
					$('.dynamic').append('<ul class="ii_alt_alan"><li><strong>Ürün</strong><span>:</span>'+$('#name'+no).html()+'</li><li><strong>Sebep</strong><span>:</span>'+$('select[name=reason'+no+']').val()+'</li><li><strong>İade Edilmesi İstenen Miktar</strong><span>:</span>'+$('select[name=qty'+no+']').val()+'</li><li><strong>Açıklama</strong><span>:</span><input type="hidden" name="id[]" value="'+no+'"><input type="hidden" name="qty[]" value="'+$('select[name=qty'+no+']').val()+'"><textarea name=description[] class="ii_text"></textarea></li></ul>');				
				});
				$('.ii_tamamla').show();
				$('.dynamic').show();
			}else{
				alert('İade ve Geri Gönderim Şartlarını okuyup, kabul ediniz.');
			}
			
			

		}else{
			alert('En az bir ürün seçmeniz gerekiyor!');
			return false;
		}
		
	});
</script>

@endsection