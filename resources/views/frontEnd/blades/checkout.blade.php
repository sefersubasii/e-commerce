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
				<span>Fatura ve Teslimat </span>

			</div>
		</div>


		<div class="tek_alan">

			<div class="sepet_adimlari">

				<div class="sa_alan saa_aktif">Sepetim</div>

				<div class="sa_alan saa_aktif">Fatura ve Teslimat</div>

				<div class="sa_alan">Ödeme İşlemi</div>

				<div class="sa_alan">Sipariş Onayı</div>

				<div class="clear"></div>

			</div>


			<div class="odeme_alan_bilgi">
<?php /*
				@if(count($errors))
					<div class="alert alert-danger">
						<strong>Hata!</strong> Lütfen aşağıdaki alanları kontrol ediniz.
						<br/>
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
*/ ?>
				<div class="oa_baslik">Fatura ve Teslimat</div>
				@if ($errors->any())
					<div class="alert alert-danger" style="margin-top: 5px;">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
					
				<form id="checkout" method="post" action="{{url('sepet/fatura-teslimat')}}">

					<input type="hidden" name="_token" value="{{csrf_token()}}">

					<div id="addressEdit" style="display: none;"></div>

					<div id="checkout-content" class="oa_icerik">

						@if(!Auth::guard('members')->check())

							<div class="adres_ekle_bilgi guest">
								<div class="adres_bilgi_left">
									<input value="{{old('guest_name', optional($shippingInfos)->guest_name)}}"  name="guest_name" type="text" placeholder="Ad" class="adres_input {{ $errors->first('guest_name') ? "err" : "" }}">
									@if ($errors->has('guest_name'))
										<div class="error">{{ $errors->first('guest_name') }}</div>
									@endif
									<input value="{{old('guest_surname', optional($shippingInfos)->guest_surname)}}"  name="guest_surname" type="text" placeholder="Soyad" class="adres_input {{ $errors->first('guest_surname') ? "err" : "" }}">
									@if ($errors->has('guest_surname'))
										<div class="error">{{ $errors->first('guest_surname') }}</div>
									@endif
								</div>
								<div class="adres_bilgi_right">
									<input value="{{old('guest_email', optional($shippingInfos)->guest_email)}}"  name="guest_email" type="text" placeholder="Email" class="adres_input {{ $errors->first('guest_email') ? "err" : "" }}">
									@if ($errors->has('guest_email'))
										<div class="error">{{ $errors->first('guest_email') }}</div>
									@endif
									<input value="{{old('guest_email_comfirm', optional($shippingInfos)->guest_email_comfirm)}}"  name="guest_email_comfirm" type="text" placeholder="Email Tekrar" class="adres_input {{ $errors->first('guest_email_comfirm') ? "err" : "" }}">
									@if ($errors->has('guest_email_comfirm'))
										<div class="error">{{ $errors->first('guest_email_comfirm') }}</div>
									@endif
								</div>
							</div>

						@endif

						@if(Auth::guard('members')->check())

							<div class="oa_fatura_sec">
								<span class="icerik_not">Teslimat adresi seçin yada yeni teslimat adresi oluşturun.</span>

								<select id="shippingAddress" onchange="changeDeliveryAddress()" name="deliveryAdress" class="adres_select">
									@if(count(@Auth::guard('members')->user()->getShippingAddress)>0)
										@foreach(Auth::guard('members')->user()->getShippingAddress as $address)
											<option {{old('deliveryAdress') == $address->id ? 'checked' : '' }} value="{{$address->id}}">{{$address->address_name}}</option>
										@endforeach
									@else
										<option value="">Kayıtlı Adres Bulunmuyor.</option>
									@endif
								</select>

								<a href="javascript:void(0)" class="adres_ekle tggl1">Teslimat Adresi Ekle</a>

							</div>


							<div class="oa_fatura_sec">
								<span class="icerik_not">Fatura adresi seçin yada yeni fatura adresi oluşturun.</span>

								<select id="billingAddress" name="billingAddress" onchange="changeBillingAddress()" class="adres_select">
									@if(count(Auth::guard('members')->user()->getBillingAddress)>0)
										@foreach(Auth::guard('members')->user()->getBillingAddress as $address)
											<option {{old('billingAddress') == $address->id ? 'checked' : '' }} value="{{$address->id}}">{{$address->address_name}}</option>
										@endforeach
									@else
										<option value="">Kayıtlı Adres Bulunmuyor.</option>
									@endif
								</select>

								<a href="javascript:void(0)" class="adres_ekle tggl2">Fatura Adresi Ekle</a>
							</div>


							<div class="clear"></div>

						@endif

							<div id="newDeliveryAdd" style="{{ Auth::guard('members')->check() == 1 ? 'display:none' : '' }}" class="adres_ekle_bilgi">

								<div class="adres_bilgi_left">

									<input value="{{old('newDeliveryAddressName', optional($shippingInfos)->newDeliveryAddressName)}}" name="newDeliveryAddressName" type="text" placeholder="Adres Adı Giriniz Ör:Ev Adresi" class="adres_input deliveryRequired {{ $errors->first('newDeliveryAddressName') ? "err" : "" }}">
									@if ($errors->has('newDeliveryAddressName'))
										<div class="error">{{ $errors->first('newDeliveryAddressName') }}</div>
									@endif
									<input value="{{old('newDeliveryName', optional($shippingInfos)->newDeliveryName)}}" name="newDeliveryName" type="text" placeholder="Ad" class="adres_input deliveryRequired {{ $errors->first('newDeliveryName') ? "err" : "" }}">
									@if ($errors->has('newDeliveryName'))
										<div class="error">{{ $errors->first('newDeliveryName') }}</div>
									@endif
									<input value="{{old('newDeliverySurname', optional($shippingInfos)->newDeliverySurname)}}" name="newDeliverySurname" type="text" placeholder="Soyad" class="adres_input deliveryRequired {{ $errors->first('newDeliverySurname') ? "err" : "" }}">
									@if ($errors->has('newDeliverySurname'))
										<div class="error">{{ $errors->first('newDeliverySurname') }}</div>
									@endif
									<input value="{{old('newDeliveryPhone', optional($shippingInfos)->newDeliveryPhone)}}" name="newDeliveryPhone" type="text" placeholder="Telefon" class="adres_input deliveryRequired phoneMask {{ $errors->first('newDeliveryPhone') ? "err" : "" }}">
									@if ($errors->has('newDeliveryPhone'))
										<div class="error">{{ $errors->first('newDeliveryPhone') }}</div>
									@endif
									{{-- <input value="{{old('newDeliveryPhoneGsm', optional($shippingInfos)->newDeliveryPhoneGsm)}}" name="newDeliveryPhoneGsm" type="text" placeholder="Cep Telefonu" class="adres_input deliveryRequired phoneMask {{ $errors->first('newDeliveryPhoneGsm') ? "err" : "" }}">
									@if ($errors->has('newDeliveryPhoneGsm'))
										<div class="error">{{ $errors->first('newDeliveryPhoneGsm') }}</div>
									@endif --}}
									<?php /*
								<input name="newDeliveryIdentity" type="text" placeholder="T.C. Kimlik No" class="adres_input {{ $errors->first('newDeliveryIdentity') ? "err" : "" }}">
								*/ ?>
								</div>

								<div class="adres_bilgi_right">

									<textarea name="newDeliveryAddress" placeholder="Adres" class="adres_text deliveryRequired {{ $errors->first('newDeliveryAddress') ? "err" : "" }}">{{old('newDeliveryAddress', optional($shippingInfos)->newDeliveryAddress)}}</textarea>
									@if ($errors->has('newDeliveryAddress'))
										<div class="error">{{ $errors->first('newDeliveryAddress') }}</div>
									@endif
									<select id="newDeliveryCity" onchange="changeCity()" name="newDeliveryCity" class="adres_select2 deliveryRequired {{ $errors->first('newDeliveryCity') ? "err" : "" }}">
										<option value="">Şehir Seçin</option>
										@foreach($cities as $city)
											<option {{old('newDeliveryCity') == $city->name ? 'selected' : ''}} data-val="{{$city->id}}" value="{{$city->name}}">{{$city->name}}</option>
										@endforeach
									</select>
									@if ($errors->has('newDeliveryCity'))
										<div class="error">{{ $errors->first('newDeliveryCity') }}</div>
									@endif

									<select name="newDeliveryState" class="adres_select2 deliveryRequired {{ $errors->first('newDeliveryState') ? "err" : "" }}">
										@if(old('newDeliveryState'))
											<option value="{{old('newDeliveryState')}}">{{old('newDeliveryState')}}</option>
										@else
											<option value="">İlçe Seçin</option>
										@endif
									</select>
									@if ($errors->has('newDeliveryState'))
										<div class="error">{{ $errors->first('newDeliveryState') }}</div>
									@endif

									<label>
										<input name="chooseBilling" value="1" {{ empty(old('sameInfo')) ? 'checked' : (old('sameInfo') == 1 ? 'checked' : '') }} type="checkbox" class="fatura_sec_radio {{Auth::guard('members')->check() == 1 ? '' : 'guestSame'}}">
										<input type="hidden" value="{{ empty( old('sameInfo') ) ? 1 : old('sameInfo') }}" name="sameInfo">
										<span>Fatura bilgilerim teslimat bilgilerim ile aynı olsun.</span>
									</label>

									@if(Auth::guard('members')->check())
										<a href="javascript:void(0)" onclick="saveNewDeliveryAddress()" class="adres_kaydet"><i class="fa fa-check" aria-hidden="true"></i>Adresi Kaydet</a>
										<a href="javascript:void(0)" onclick="$('#newDeliveryAdd').slideUp();$('.adres_bilgi_alan').show();" class="adres_vazgec"><i class="fa fa-times" aria-hidden="true"></i>Vazgeç</a>
									@endif
								</div>

								<div class="clear"></div>

							</div>

							<?php /*<div class="clear"></div>*/ ?>

							<div id="newBillingAdd" {{ empty(old('sameInfo')) ? 'style=display:none' : (old('sameInfo') == 1 ? 'style=display:none' : 'style=display:block') }}   class="adres_ekle_bilgi">


								<div class="kisisel_adres_sec">

									<label>
										<input name="billingType" value="1" type="radio" {{old('billingType') == 2 ? '' : 'checked'}}   class="kisisel_adres_sec_radio">
										<span>Bireysel</span>
									</label>

									<label>
										<input name="billingType" value="2" type="radio" {{old('billingType') == 2 ? 'checked' : ''}} class="kisisel_adres_sec_radio">
										<span>Kurumsal</span>
									</label>

									<div class="clear"></div>

								</div>

								<div class="adres_bilgi_left">

									<input value="{{old('newBillingAddressName')}}"  name="newBillingAddressName" type="text" placeholder="Adres Adı Giriniz" class="adres_input billingRequired {{ $errors->first('newBillingAddressName') ? "err" : "" }}">

									@if ($errors->has('newBillingAddressName'))
										<div class="error">{{ $errors->first('newBillingAddressName') }}</div>
									@endif

									<input value="{{old('newBillingName')}}"  name="newBillingName" type="text" placeholder="{{old('billingType') == 2 ? 'Ticari Ünvanı' : 'Ad' }}" class="adres_input billingRequired {{ $errors->first('newBillingName') ? "err" : "" }}">

									@if ($errors->has('newBillingName'))
										<div class="error">{{ $errors->first('newBillingName') }}</div>
									@endif

									<input value="{{old('newBillingSurname')}}" {{ old('billingType') == 2 ? 'style=display:none' : '' }}  name="newBillingSurname" type="text" placeholder="Soyad" class="adres_input billingRequired {{ $errors->first('newBillingSurname') ? "err" : "" }}">

									@if ($errors->has('newBillingSurname'))
										<div {{ old('billingType') == 2 ? 'style=display:none' : '' }} class="error">{{ $errors->first('newBillingSurname') }}</div>
									@endif

									<input value="{{old('newBillingPhone')}}"  name="newBillingPhone" type="text" placeholder="Telefon" class="adres_input phoneMask billingRequired {{ $errors->first('newBillingPhone') ? "err" : "" }}">

									@if ($errors->has('newBillingPhone'))
										<div class="error">{{ $errors->first('newBillingPhone') }}</div>
									@endif

									{{-- <input value="{{old('newBillingPhoneGsm')}}"  name="newBillingPhoneGsm" type="text" placeholder="Cep Telefonu" class="adres_input phoneMask billingRequired {{ $errors->first('newBillingPhoneGsm') ? "err" : "" }}">

									@if ($errors->has('newBillingPhoneGsm'))
										<div class="error">{{ $errors->first('newBillingPhoneGsm') }}</div>
									@endif --}}

									<?php /*
								<input name="newBillingIdentity" type="text" placeholder="T.C. Kimlik No" class="adres_input">
								*/ ?>

								</div>


								<div class="adres_bilgi_right">

									<textarea name="newBillingAddress" placeholder="Adres" class="adres_text billingRequired {{ $errors->first('newBillingAddress') ? "err" : "" }}">{{old('newBillingAddress')}}</textarea>
									@if ($errors->has('newBillingAddress'))
										<div class="error">{{ $errors->first('newBillingAddress') }}</div>
									@endif

									<select name="newBillingCity" onchange="changeCity2()" id="newBillingCity" class="adres_select2 billingRequired {{ $errors->first('newBillingCity') ? "err" : "" }}">
										<option value="">Şehir Seçin</option>
										@foreach($cities as $city)
											<option {{old('newBillingCity')==$city->name ? 'selected' : ''}} data-val="{{$city->id}}" value="{{$city->name}}">{{$city->name}}</option>
										@endforeach
									</select>

									@if ($errors->has('newBillingCity'))
										<div class="error">{{ $errors->first('newBillingCity') }}</div>
									@endif

									<select name="newBillingState" class="adres_select2 billingRequired {{ $errors->first('newBillingState') ? "err" : "" }}">
										@if(old('newBillingState'))
											<option value="{{old('newBillingState')}}">{{old('newBillingState')}}</option>
										@else
											<option value="">İlçe Seçin</option>
										@endif
									</select>

									@if ($errors->has('newBillingState'))
										<div class="error">{{ $errors->first('newBillingState') }}</div>
									@endif

									<div {{ old('billingType') == 2 ? '' : 'style=display:none' }} id="corporateArea">

										<input value="{{old('newBillingTaxOffice')}}" name="newBillingTaxOffice" type="text" placeholder="Vergi Dairesi" class="adres_input {{ $errors->first('newBillingTaxOffice') ? "err" : "" }}">

										@if ($errors->has('newBillingTaxOffice'))
											<div class="error">{{ $errors->first('newBillingTaxOffice') }}</div>
										@endif

										<input value="{{old('newBillingTaxNo')}}" name="newBillingTaxNo" type="text" placeholder="Vergi Numarası" class="adres_input {{ $errors->first('newBillingTaxNo') ? "err" : "" }}">

										@if ($errors->has('newBillingTaxNo'))
											<div class="error">{{ $errors->first('newBillingTaxNo') }}</div>
										@endif
									</div>
									@if(Auth::guard('members')->check())
										<a href="javascript:void(0)" onclick="saveNewBillingAddress()" class="adres_kaydet"><i class="fa fa-check" aria-hidden="true"></i>Adresi Kaydet</a>
										<a href="javascript:void(0)" onclick="$('#newBillingAdd').slideUp();$('.adres_bilgi_alan').show();" class="adres_vazgec"><i class="fa fa-times" aria-hidden="true"></i>Vazgeç</a>
									@endif
								</div>

								<div class="clear"></div>

							</div>


						@if(Auth::guard('members')->check())

							<div  class="adres_bilgi_alan">

								<div class="position-relative adres_bilgi historyAddress historyDelivery" style="{{count(Auth::guard('members')->user()->getShippingAddress) <= 0 ? 'display:none' : ''}}">

									<strong class="adres_baslik">Teslimat Adresi</strong>

									<span id="currentDelivery">
										<i class="fa fa-user" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getShippingAddress[0]->name}} {{@Auth::guard('members')->user()->getShippingAddress[0]->surname}}
										<br>
										<i class="fa fa-phone" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getShippingAddress[0]->phone}}
										<br>
										<i class="fa fa-map-marker" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getShippingAddress[0]->address}} <br> {{@Auth::guard('members')->user()->getShippingAddress[0]->city}} / {{@Auth::guard('members')->user()->getShippingAddress[0]->state}}
									</span>

									<div class="address-edit" onclick="AddressEdit.show({{ @Auth::guard('members')->user()->getShippingAddress[0]->id }}, 'shipping')">
										<i class="fa fa-pencil"></i> Düzenle
									</div>
								</div>

								<div class="position-relative adres_bilgi historyAddress historyBilling" style="{{count(Auth::guard('members')->user()->getBillingAddress) <= 0 ? 'display:none' : ''}}">

									<strong class="adres_baslik">Fatura Adresi</strong>

									<span id="currentBilling">
										<i class="fa fa-user" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getBillingAddress[0]->name}} {{@Auth::guard('members')->user()->getBillingAddress[0]->surname}}
										<br>
										<i class="fa fa-phone" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getBillingAddress[0]->phone}}
										<br>
										<i class="fa fa-map-marker" aria-hidden="true"></i> {{@Auth::guard('members')->user()->getBillingAddress[0]->address}} <br> {{@Auth::guard('members')->user()->getBillingAddress[0]->city}} / {{@Auth::guard('members')->user()->getBillingAddress[0]->state}}
									</span>

									<div class="address-edit" onclick="AddressEdit.show({{ @Auth::guard('members')->user()->getBillingAddress[0]->id }}, 'billing')">
										<i class="fa fa-pencil"></i> Düzenle
									</div>
								</div>

								<div class="clear"></div>

							</div>

						@endif




							<?php /*</div>*/ ?>


						<div class="kargo_alani">
							<strong>Kargo Firması Seçiniz</strong>
							<select onchange="changeShipping()" name="shipping" class="kargo_select {{ ($errors->first('shipping') || $errors->first('shipping_role_type')) ? "err" : "" }}">
								<option value="">Firma Seçiniz</option>
								@foreach($shippingCompanies as $company)
									<option {{Session::get('cart')->shipping->id == $company->id ? 'selected' : ''}} value="{{$company->id}}">{{$company->name}}</option>
								@endforeach
							</select>
							<input id="shippingPrice" type="text" value="{{ Session::get('cart')->getShippingPrice(true) }} TL" disabled class="kargo_input">
							<div class="clear"></div>
							<br>
							<input type="hidden" name="shipping_role_type"> 
							@if ($errors->has('shipping_role_type'))
								<div class="error" style="">{{ $errors->first('shipping_role_type') }}</div>
							@endif

							@if(count($slots)>0)
								<span class="icerik_not">Teslimat saati seçiniz.</span>
							@endif

							<div class="kargo_saat_sec {{ $errors->first('shippingSlot') ? "err" : "" }}">
								@if(count($slots)>0)
									@foreach($slots as $k => $v)
										<label>
											<input value="{{$v['id']}}" {{old('shippingSlot') == $v['id'] ? 'checked' : ''}} name="shippingSlot" type="radio" class="kargo_saat_radio">
											<span>{{substr($v['time1'], 0, -3)}} - {{substr($v['time2'], 0, -3)}}</span>
										</label>
									@endforeach
								@endif
							</div>

							<span id="freeShipText">
								@if(Session::get('cart')->shippingPrice > 0 && Session::get('cart')->freeShipping==0 && Session::get('cart')->shipping->roles->free_shipping > 0 )
									<strong> ! </strong>{{ Session::get('cart')->getFreeShipingText() }}
								@endif
							</span>

						</div>
						<?php /*
						<div class="fatura_secimi">

							<strong>Fatura Seçimi</strong>

							<div class="fatura_secimi_sec">

								<label>
									<input name="chooseBilling" value="1" checked type="checkbox" class="fatura_sec_radio">
									<span>Fatura adresim teslimat adresimle aynı.</span>
								</label>

							</div>

						</div>
						*/ ?>
						<div class="siparis_notu">

							<strong>Sipariş Notu Detayları</strong>

							<div class="kisisel_adres_sec">

								<label>
									<input name="giftnote" onclick="$('#giftnote').css('display','inline');" type="radio" class="kisisel_adres_sec_radio">
									<span>Evet</span>
								</label>

								<label>
									<input name="giftnote" onclick="$('#giftnote').css('display','none');" checked type="radio" class="kisisel_adres_sec_radio">
									<span>Hayır</span>
								</label>

								<div class="clear"></div>

							</div>

							<textarea name="giftNote" id="giftnote" placeholder="Sipariş Notu" style="display: none;" class="siparis_notu_text"></textarea>


						</div>

						<a href="{{url('sepet')}}" class="sepet_geri_buton"><i class="fa fa-reply" aria-hidden="true"></i> Geri</a>

						<a href="#" class="sepet_odeme_buton nextAction"><i class="fa fa-money" aria-hidden="true"></i> Ödeme İşlemi</a>


					</div>
				</form>
			</div>



			<div class="odeme_alan_ozet" id="wrap">

				<div class="oa_baslik">Sipariş Özeti</div>

				<div class="oa_icerik">
					<div class="sepet_ozet_adet">{{Session::get('cart')->totalQty}} ürün</div>

					<div class="sepet_ozet_title">Ödenecek Tutar</div>

					<strong class="sepet_ozet_tutar">{{$myPrice->currencyFormat((Session::get('cart')->totalPrice+Session::get('cart')->shippingPrice)-Session::get('cart')->promotionDiscount)}} TL</strong>

					<a href="#" class="sepet_ozet_buton nextAction"><i class="fa fa-money" aria-hidden="true"></i> Ödeme İşlemi</a>

					<div class="sepet_ozet_fiyat">
						<span>Toplam ( KDV Dahil )</span>
						<strong>{{$myPrice->currencyFormat(Session::get('cart')->totalPrice-Session::get('cart')->promotionDiscount)}} TL</strong>
					</div>

					<div class="sepet_ozet_fiyat">
						<span>Kargo Ücreti</span>
						<strong id="shippingPriceRight">{{$myPrice->currencyFormat(Session::get('cart')->shippingPrice+0)}} TL</strong>
					</div>

				</div>

			</div>

			<div class="clear"></div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/address.js') }}"></script>

<script type="text/javascript">
	var google_tag_params = {
		ecomm_prodid: {!!json_encode(array_map('strval',array_keys(Session::get("cart")->items)))!!},
		ecomm_pagetype: 'cart',
		ecomm_totalvalue: {{Session::get("cart")->totalPrice}},
	};
</script>

@endsection
