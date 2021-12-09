@extends('frontEnd.layout.checkout')

@section('pageTitle', $settings['seo']->seo_title)

@section('pageDescription', $settings['seo']->seo_description)

@section('content')

<div class="container">

	<div class="container_ic">
		
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('/')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<a href="{{url('sepet')}}">Sepetim</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Ödeme İşlemi </span>   
				             
			</div>
		</div>
		
		
		<div class="tek_alan">
			
			<div class="sepet_adimlari">
				 
				<div class="sa_alan saa_aktif">Sepetim</div>
				
				<div class="sa_alan saa_aktif">Fatura ve Teslimat</div>
				
				<div class="sa_alan saa_aktif">Ödeme İşlemi</div>
				
				<div class="sa_alan">Sipariş Onayı</div>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="odeme_alan_bilgi">
				
				<div class="oa_baslik">Ödeme İşlemi</div>
				
				<div class="oa_icerik">
					
					<strong class="icerik_not">Lütfen sipariş bilgilerinizi gözden geçirip onaylayın.</strong>

					<div class="siparis_sepet_alan">

							<ul class="satin_al_baslik">
								<li>Ürün</li>
								<li>Adet</li>
								<li>Toplam</li>
								<li>Havale</li>
							</ul>

							@foreach($cart->items as $p)

								<ul class="satin_al_icerik">
									<li>{{$p["item"]->p->name}}</li>
									<li>{{$p["qty"]}} X {{$myPrice->currencyFormat($p["item"]->realPrice)}} ₺</li>
									<li>{{$myPrice->currencyFormat($p["item"]->realPrice*$p["qty"])}} ₺</li>
									<li>{{$myPrice->currencyFormat($p["item"]->realPrice*$p["qty"])}} ₺</li>
								</ul>
							@endforeach
						
					</div>
					
					<div class="bolum_baslik">
						<strong>Teslimat Bilgileri</strong> - <a href="{{url('sepet/fatura-teslimat')}}">Değiştir</a>
					</div>
					
					<div class="adres_bilgi_alan">
					
						<div class="adres_bilgi">

							<strong class="adres_baslik">Teslimat Adresi</strong>

							<span>
								<i class="fa fa-user" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberDelivery"]->name." ".$cart->others["memberDelivery"]->surname : $cart->others["newDeliveryName"]." ".$cart->others["newDeliverySurname"]}}
								<br>
								<i class="fa fa-phone" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberDelivery"]->phone : $cart->others["newDeliveryPhone"]}}
								<br>
								<i class="fa fa-map-marker" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberDelivery"]->address : $cart->others["newDeliveryAddress"]}} <br> {{Auth::guard('members')->check() ? $cart->others["memberDelivery"]->city : $cart->others["newDeliveryCity"]}} / {{Auth::guard('members')->check() ?  $cart->others["memberDelivery"]->state : $cart->others["newDeliveryState"]}}
							</span>
						</div>

						<div class="adres_bilgi">

							<strong class="adres_baslik">Fatura Adresi</strong>

							<span>
								<i class="fa fa-user" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberBilling"]->name." ".$cart->others["memberBilling"]->surname : $cart->others["newBillingName"]." ".$cart->others["newBillingSurname"]}}
								<br>
								<i class="fa fa-phone" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberBilling"]->phone : $cart->others["newBillingPhone"]}}
								<br>
								<i class="fa fa-map-marker" aria-hidden="true"></i> {{Auth::guard('members')->check() ? $cart->others["memberBilling"]->address  : $cart->others["newBillingAddress"]}} <br> {{Auth::guard('members')->check() ? $cart->others["memberBilling"]->city : $cart->others["newBillingCity"]}} / {{Auth::guard('members')->check() ? $cart->others["memberBilling"]->state : $cart->others["newBillingState"]}}
							</span>

						</div>
						
						<div class="clear"></div>
						
					</div>
					
					<div class="siparis_odeme_bilgileri">
						
						
					<div class="bolum_baslik">
						<strong>Ödeme Türünü Seçiniz</strong>
					</div>
						
					<div class="odeme_tab">
						<strong data-opt="kk" class="ot_link"><a href="#os_1" >Kredi Kartı</a></strong>
						<?php /*
						<strong data-opt="bkm" class="ot_link"><a href="#os_2" >BKM Express </a></strong>
						*/ ?>				
						<strong data-opt="havale" class="ot_link"><a href="#os_3" >Havale</a></strong>
						@if($cart->shipping->pd_status==1)
						<strong data-opt="ko" class="ot_link"><a href="#os_4" >Kapıda Ödeme</a></strong>
						@endif
					</div>

					
					<div class="odeme_sec">
            	
						<div id="os_1" class="odeme_sec_icerik">
							
							<div class="odeme_kart_alan">

								<div style="display:none;" class="formHDD"></div>
							
								<div class="oka_satir">
									<strong>Kart Üzerindeki İsim</strong>
									<input name="firstname" type="text" class="oka_input cardRequired">
								</div>
								
								<div class="oka_satir">
									<strong>Kart Numarası</strong>
									<input type="text" name="card_number" id="card_number" class="oka_input card_number_mask cardRequired">

									<label id="cart_type_name">
										<i class="icon_cart_type icon_visa"></i>
									</label>
									<input type="hidden" name="type" id="cart_type" value="1">

									{{-- <input maxlength="4" type="text" onkeyup="nextInput(this.id);" id="card1" name="card1" class="oka_input2 cardRequired">
									<input maxlength="4" type="text" onkeyup="nextInput(this.id);" id="card2" name="card2" class="oka_input2 cardRequired">
									<input maxlength="4" type="text" onkeyup="nextInput(this.id);" id="card3" name="card3" class="oka_input2 cardRequired">
									<input maxlength="4" type="text" onkeyup="nextInput(this.id);" id="card4" name="card4" class="oka_input2 cardRequired"> --}}
								</div>
								
								<div class="oka_satir">
									<strong>Son Kullanma Tarihi</strong>
									<select name="month" class="oka_select3 cardRequired">
										@for($i=1; $i<=12; $i++)
											<option value="{{ $i <= 9 ? '0'.$i : $i }}">{{ $i <= 9 ? '0'.$i : $i }}</option>
										@endfor
									</select>
									<select name="year" class="oka_select3 cardRequired">
										@for($i=date('y'); $i<=date('y')+25; $i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
								
								<div class="oka_satir">
									<strong>CCV</strong>
									<input name="cvc" type="text" maxlength="3" class="oka_input2 cardRequired">
									<a href="javascript:void(0)" class="cvc2_no">
										<i class="fa fa-question-circle" aria-hidden="true"></i>
										<img src="{{ asset('images/cvc2.png') }}" alt="" class="cvc2_gorsel">
									</a>
								</div>
							</div>
							<?php /*
							<div class="odeme_kart_taksit">
								
								<img src="{{asset('images/belgeler/banka/bonus.png')}}" alt="">

								<ul class="okt_alan">
									<li><strong>Taksit Sayısı</strong></li>
									<li><strong>Aylık Ödeme</strong></li>
									<li><strong>Toplam Tutar</strong></li>
								</ul>
								
								<ul class="okt_alan">
									<li><label><input type="radio" class="okt_radio"> <span>Tek Ödeme</span> </label></li>
									<li>00,00 ₺</li>
									<li>00,00 ₺</li>
								</ul>
								
								<ul class="okt_alan">
									<li><label><input type="radio" class="okt_radio"> <span>2 Taksit</span> </label></li>
									<li>00,00 ₺</li>
									<li>00,00 ₺</li>
								</ul>
								
								<ul class="okt_alan">
									<li><label><input type="radio" class="okt_radio"> <span>3 Taksit</span> </label></li>
									<li>00,00 ₺</li>
									<li>00,00 ₺</li>
								</ul>
								
								<ul class="okt_alan">
									<li><label><input type="radio" class="okt_radio"> <span>4 Taksit</span> </label></li>
									<li>00,00 ₺</li>
									<li>00,00 ₺</li>
								</ul>
								
								<ul class="okt_alan">
									<li><label><input type="radio" class="okt_radio"> <span>5 Taksit</span> </label></li>
									<li>00,00 ₺</li>
									<li>00,00 ₺</li>
								</ul>

								
							</div>
							*/ ?>
							
							<div class="clear"></div>
							
							
						</div>

						<?php /*

						<div id="os_2" class="odeme_sec_icerik">

							<img src="{{asset('images/bkm.jpg')}}" alt="" class="bkm_gorsel">

							<a href="#" class="bkm_buton">Ödeme Yapmak İçin Tıklayınız</a>

							<div class="tab_bilgi">
								BKM Express ile ödeme yaparken www.bkmexpress.com.tr sayfasına yönlendirileceksiniz. BKM Express sitesine üye olurken kullandığınız kullanıcı adı ve şifreniz ile uygulamaya giriş yapmanız gerekmektedir. Karşınıza gelen ödeme ekranından işlem yapmak istediğiniz kartı seçerek kolayca ödeme yapabilirsiniz. Alışverişinizi tamamladıktan sonra otomatik olarak www.........com sitesine döneceksiniz.
							</div>

						</div>

						*/ ?>

						<div id="os_3" class="odeme_sec_icerik">
							<ul class="havale_baslik">
								<li>Banka İsmi</li>
								<li>Hesap Türü</li>
								<li>Hesap Sahibi</li>
								<li>IBAN NUMARASI</li>
							</ul>

							@foreach($settings["banks"] as $key => $bank)
								<ul class="havale_icerik">
									<li>
										<label>
											<input {{ $key == 0 ? 'checked' : '' }} name="havaleOpt" type="radio" value="{{ $bank->id }}" class="havale_radio">
											<img src="{{asset('src/uploads/banks/'.$bank->image)}}" alt="">
										</label>
									</li>
									<li>{{$bank->currency}}</li>
									<li>{{$bank->owner}}</li>
									<li>{{$bank->iban}}</li>
								</ul>
							@endforeach
						</div>

						@if($cart->shipping->pd_status==1)
						<div id="os_4" class="odeme_sec_icerik">

							<div class="odeme_kart_alan">
								<div class="oka_satir">
									<strong>Ödeme Seçeneği</strong>
									<select name="pdo" class="oka_select">
										@if($cart->shipping->pdCash_status==1)
										<option value="pdCash">Kapıda Ödeme ( Nakit ) {{$myPrice->currencyFormat($cart->shipping->pdCash_price)}} TL</option>
										@endif
										@if($cart->shipping->pdCard_status==1)
										<option value="pdCard">Kapıda Ödeme ( Kredi Kartı ) {{$myPrice->currencyFormat($cart->shipping->pdCard_price)}} TL</option>
										@endif
									</select>
								</div>
							</div>

							<div class="clear"></div>

						</div>
						@endif
					</div>
						

					</div>
					<?php /*
					<div class="sozlesme_alani">
						
						<div class="bolum_baslik">
							<strong>Cayma Hakkı</strong>
						</div>
						
						<div class="sozlesme_text">
							Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.
							<br><br>
							Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.
							
						</div>
						
						
					</div>
					*/ ?>
					
					<div id="on_bilgilendirme" class="sozlesme_alani">
						
						<div class="bolum_baslik">
							<strong>Ön Bilgilendirme Formu</strong>
						</div>
						<div class="sozlesme_text">
							{!!  str_replace(["{saticiunvan}","{saticiadres}","{saticitelefon}","{saticifax}","{saticimail}"], [$settings["company"]->company_name, $settings["company"]->company_address, $settings["company"]->company_phone, $settings["company"]->company_fax, $settings["company"]->company_email ], str_replace($aliciSearch,$aliciReplace,$settings["constants"]->notificationform)) !!}							
						</div>
						
						
					</div>
					
					<div id="mesafeli_satis" class="sozlesme_alani">
						
						<div class="bolum_baslik">
							<strong>Mesafeli Satış Sözleşmesi</strong>
						</div>
						
						<div class="sozlesme_text">
							{!! $settings["constants"]->paymentagreement !!}							
						</div>
					
						
					</div>
				
					<span class="live_error"></span>
					<a href="{{url('sepet/fatura-teslimat')}}" class="sepet_geri_buton"><i class="fa fa-reply" aria-hidden="true"></i> Geri</a>
					
					<a href="#" class="sepet_odeme_buton approveOrder"><i class="fa fa-money" aria-hidden="true"></i> Siparişi Onayla</a>
					

					
					
				</div>
				
			</div>
			

			
			<div class="odeme_alan_ozet" id="wrap">
				
				<div class="oa_baslik">Sipariş Özeti</div>
				
				<div class="oa_icerik">
					<div class="sepet_ozet_adet">{{$cart->totalQty}} ürün</div>
					
					<div class="sepet_ozet_title">Ödenecek Tutar</div>
					
					<strong class="sepet_ozet_tutar pDefault">{{$myPrice->currencyFormat(($cart->totalPrice+$cart->shippingPrice)-$cart->promotionDiscount)}} TL</strong>
					@if($cart->shipping->pd_status==1)
					<strong style="display:none" class="sepet_ozet_tutar pdCash">{{$myPrice->currencyFormat(($cart->totalPrice+$cart->shippingPrice+$cart->shipping->pdCash_price)-$cart->promotionDiscount)}} TL</strong>
					<strong style="display:none" class="sepet_ozet_tutar pdCard">{{$myPrice->currencyFormat(($cart->totalPrice+$cart->shippingPrice+$cart->shipping->pdCard_price)-$cart->promotionDiscount)}} TL</strong>
					@endif

					
					<div class="ozet_sozlesme">
						
						<label>
							<input id="on_bilgilendirme" checked type="checkbox" class="ozet_sozlesme_chec"> 
							<span><a href="#on_bilgilendirme">Ön bilgilendirme formunu</a> <br> kabul ediyorum.</span>
						
						</label>
					
						<label>
							<input id="mesafeli_satis" checked  type="checkbox" class="ozet_sozlesme_chec"> 
							<span><a href="#mesafeli_satis">Mesafeli satış sözleşmesini</a> <br> kabul ediyorum.</span>
						</label>
						<span class="live_error"></span>

					</div>
					
					<a href="#" class="sepet_ozet_buton approveOrder"><i class="fa fa-money" aria-hidden="true"></i> Siparişi Onayla</a>
					
					<span class="ozet_bilgi">Siparişi Onayla butonuna bastığınızda, toplam tutar tahsil edilecektir.</span>
					
					<div class="sepet_ozet_fiyat">
						<span>Toplam ( KDV Dahil )</span>
						<strong class="pDefault">{{$myPrice->currencyFormat(($cart->totalPrice+$cart->shippingPrice)-$cart->promotionDiscount)}} TL</strong>
						@if($cart->shipping->pd_status==1)
						<strong style="display:none" class="pdCash">{{$myPrice->currencyFormat($cart->totalPrice+$cart->shippingPrice+$cart->shipping->pdCash_price)}} TL</strong>
						<strong style="display:none" class="pdCard">{{$myPrice->currencyFormat($cart->totalPrice+$cart->shippingPrice+$cart->shipping->pdCard_price)}} TL</strong>
						@endif
					</div>
					<div class="sepet_ozet_fiyat">
						<span>Kargo Ücreti</span>
						<strong>{{$cart->shippingPrice}} TL</strong>
					</div>

				</div>
				
			</div>
			
			<div class="clear"></div>

		</div>
		
		


	</div>
	
	

		
		
</div>


@endsection

@section('scripts')
	<script src="{{ asset('js/pay.js') }}"></script>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: {!!json_encode(array_map('strval',array_keys(Session::get("cart")->items)))!!},
			ecomm_pagetype: 'cart',
			ecomm_totalvalue: {{Session::get("cart")->totalPrice}},
		};
	</script>
@endsection
