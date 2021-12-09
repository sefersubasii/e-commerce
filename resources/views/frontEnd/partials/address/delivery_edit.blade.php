<div class="address-edit-title">Teslimat Adresini Güncelle</div>
<div id="newDeliveryAdd" class="adres_ekle_bilgi" style="margin: 0; margin-bottom: 10px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="shippingId" value="{{ $address->id }}">
    <div class="adres_bilgi_left">
        <input value="{{ $old('address_name', $address->address_name) }}" name="address_name" type="text" placeholder="Adres Adı Giriniz Ör:Ev Adresi" class="adres_input deliveryRequired {{ $errors->first('address_name') ? "err" : "" }}">
        @if ($errors->has('address_name'))
            <div class="error">{{ $errors->first('address_name') }}</div>
        @endif
        <input value="{{ $old('name', $address->name) }}" name="name" type="text" placeholder="Ad" class="adres_input deliveryRequired {{ $errors->first('name') ? "err" : "" }}">
        @if ($errors->has('name'))
            <div class="error">{{ $errors->first('name') }}</div>
        @endif
        <input value="{{ $old('surname', $address->surname) }}" name="surname" type="text" placeholder="Soyad" class="adres_input deliveryRequired {{ $errors->first('surname') ? "err" : "" }}">
        @if ($errors->has('surname'))
            <div class="error">{{ $errors->first('surname') }}</div>
        @endif
        <input value="{{ $old('phone', $address->phone) }}" name="phone" type="text" placeholder="Telefon" class="adres_input deliveryRequired phoneMask {{ $errors->first('phone') ? "err" : "" }}">
        @if ($errors->has('phone'))
            <div class="error">{{ $errors->first('phone') }}</div>
        @endif
    </div>

    <div class="adres_bilgi_right">
        <textarea name="address" placeholder="Adres" class="adres_text deliveryRequired {{ $errors->first('address') ? "err" : "" }}">{{ $old('address', $address->address) }}</textarea>
        @if ($errors->has('address'))
            <div class="error">{{ $errors->first('address') }}</div>
        @endif
        <select id="city" onchange="changeCity()" name="city" class="adres_select2 deliveryRequired {{ $errors->first('city') ? "err" : "" }}">
            <option value="">Şehir Seçin</option>
            @foreach($cities as $city)
                <option value="{{ $city->name }}" {{ $old('city', $address->city) == $city->name ? 'selected' : ''}} data-val="{{ $city->id }}">
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('city'))
            <div class="error">{{ $errors->first('city') }}</div>
        @endif

        <select name="state" class="adres_select2 deliveryRequired {{ $errors->first('state') ? "err" : "" }}">
            <option value="">İlçe Seçin</option>
            @foreach ($states as $state)
                <option value="{{ $state->name }}" {{ $old('state', $address->state) == $state->name  ? ' selected ' : '' }}>{{ $state->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('state'))
            <div class="error">{{ $errors->first('state') }}</div>
        @endif

        @if(auth()->guard('members')->check())
            <a href="javascript:void(0)" onclick="AddressEdit.save()" class="adres_kaydet"><i class="fa fa-check" aria-hidden="true"></i>Adresi Kaydet</a>
            <a href="javascript:void(0)" onclick="AddressEdit.close()" class="adres_vazgec"><i class="fa fa-times" aria-hidden="true"></i>Vazgeç</a>
        @endif
    </div>
    <div class="clear"></div>
</div>