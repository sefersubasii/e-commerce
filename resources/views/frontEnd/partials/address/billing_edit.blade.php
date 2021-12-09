<div class="address-edit-title">Fatura Adresini Güncelle</div>
<div id="newBillingAdd" class="adres_ekle_bilgi" style="margin: 0; margin-bottom: 10px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="billingId" value="{{ $address->id }}">
    <div class="kisisel_adres_sec">
        <label>
            <input name="type" value="1" type="radio" {{ ($old('type', $address->type)) == 2 ? '' : 'checked' }} class="billing-type kisisel_adres_sec_radio">
            <span>Bireysel</span>
        </label>
        <label>
            <input name="type" value="2" type="radio" {{ ($old('type', $address->type)) == 2 ? 'checked' : '' }} class="billing-type kisisel_adres_sec_radio">
            <span>Kurumsal</span>
        </label>
        <div class="clear"></div>
    </div>

    <div class="adres_bilgi_left">

        <input value="{{ $old('address_name', $address->address_name) }}"  name="address_name" type="text" placeholder="Adres Adı Giriniz" class="adres_input billingRequired {{ $errors->first('address_name') ? "err" : "" }}">
        @if ($errors->has('address_name'))
            <div class="error">{{ $errors->first('address_name') }}</div>
        @endif

        <input value="{{ $old('name', $address->name) }}"  name="name" type="text" placeholder="{{ ($old('type', $address->type)) == 2 ? 'Ticari Ünvanı' : 'Ad' }}" class="adres_input billingRequired {{ $errors->first('name') ? "err" : "" }}">
        @if ($errors->has('name'))
            <div class="error">{{ $errors->first('name') }}</div>
        @endif

        <input value="{{ $old('surname', $address->surname) }}" {{ ($old('type', $address->type)) == 2 ? 'style=display:none' : '' }}  name="surname" type="text" placeholder="Soyad" class="adres_input billingRequired {{ $errors->first('surname') ? "err" : "" }}">
        @if ($errors->has('surname'))
            <div {{ ($old('type', $address->type)) == 2 ? 'style=display:none' : '' }} class="error">{{ $errors->first('surname') }}</div>
        @endif

        <input value="{{ $old('phone', $address->phone) }}"  name="phone" type="text" placeholder="Telefon" class="adres_input phoneMask billingRequired {{ $errors->first('phone') ? "err" : "" }}">
        @if ($errors->has('phone'))
            <div class="error">{{ $errors->first('phone') }}</div>
        @endif
    </div>

    <div class="adres_bilgi_right">

        <textarea name="address" placeholder="Adres" class="adres_text billingRequired {{ $errors->first('address') ? "err" : "" }}">{{ $old('address', $address->address) }}</textarea>
        @if ($errors->has('address'))
            <div class="error">{{ $errors->first('address') }}</div>
        @endif

        <select name="city" id="city" class="adres_select2 billingRequired {{ $errors->first('city') ? "err" : "" }}">
            <option value="">Şehir Seçin</option>
            @foreach($cities as $city)
                <option {{ $old('city', $address->city) == $city->name ? 'selected' : ''}} data-val="{{$city->id}}" value="{{$city->name}}">{{$city->name}}</option>
            @endforeach
        </select>
        @if ($errors->has('city'))
            <div class="error">{{ $errors->first('city') }}</div>
        @endif

        <select name="state" class="adres_select2 billingRequired {{ $errors->first('state') ? "err" : "" }}">
            <option value="">İlçe Seçin</option>
            @foreach ($states as $state)
                <option value="{{ $state->name }}" {{ $old('state', $address->state) == $state->name ? ' selected ' : '' }}>{{ $state->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('state'))
            <div class="error">{{ $errors->first('state') }}</div>
        @endif

        <div {{ ($old('type', $address->type)) == 2 ? '' : 'style=display:none' }} id="corporateArea">
            <input value="{{ $old('tax_place', $address->tax_place) }}" name="tax_place" type="text" placeholder="Vergi Dairesi" class="adres_input {{ $errors->first('tax_place') ? "err" : "" }}">
            @if ($errors->has('tax_place'))
                <div class="error">{{ $errors->first('tax_place') }}</div>
            @endif

            <input value="{{ $old('tax_no', $address->tax_no) }}" name="tax_no" type="text" placeholder="Vergi Numarası" class="adres_input {{ $errors->first('tax_no') ? "err" : "" }}">
            @if ($errors->has('tax_no'))
                <div class="error">{{ $errors->first('tax_no') }}</div>
            @endif
        </div>
        @if(Auth::guard('members')->check())
            <a href="javascript:void(0)" onclick="AddressEdit.save()" class="adres_kaydet"><i class="fa fa-check" aria-hidden="true"></i>Adresi Kaydet</a>
            <a href="javascript:void(0)" onclick="AddressEdit.close()" class="adres_vazgec"><i class="fa fa-times" aria-hidden="true"></i>Vazgeç</a>
        @endif
    </div>

    <div class="clear"></div>
</div>