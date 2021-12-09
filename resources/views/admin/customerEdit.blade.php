@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Müşteri Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/customers')}}" class="btn btn-block btn-default btn-rounded">← Müşteriler</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Müşteri Düzenle</h3>
                        <form method="post" action="{{url('admin/customers/update/'.$data->id)}}" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel Bilgiler</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">İletişim Bilgileri</span></a></li>
                                <li role="presentation" class=""><a href="#shippingAddress" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Teslimat Adres Bilgileri</span></a></li>
                                <li role="presentation" class=""><a href="#billingAddress" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Fatura Adres Bilgileri</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{$data->status == 1 ? 'selected="selected"' : '' }} value="1">Aktif</option>
                                                <option {{$data->status == 0 ? 'selected="selected"' : '' }} value="0">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="group_id" class="col-sm-2 control-label">Müşteri Grubu</label>
                                        <div class="col-sm-3">
                                            <select name="group_id" class="group-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->Group->id}}">{{@$data->Group->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">İsim</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="surname" class="col-sm-2 control-label">Soyisim</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="surname" id="surname" value="{{$data->surname}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">E-Posta</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="email" id="email" value="{{$data->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sex" class="col-sm-2 control-label">Cinsiyet</label>
                                        <div class="col-sm-2">
                                            <select name="sex" id="sex" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{$data->gender == 1 ? 'selected' : ''}} value="1">Erkek</option>
                                                <option {{$data->gender == 2 ? 'selected' : ''}} value="2">Kadın</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Şifre</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-sm-2 control-label">Şifre Tekrarı</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="password_confirmation" id="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company" class="col-sm-2 control-label">Firma Adı</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="company" id="company" value="{{@$data->company}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tax_office" class="col-sm-2 control-label">Vergi Dairesi</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="tax_office" id="tax_office" value="{{@$data->tax_office}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tax_number" class="col-sm-2 control-label">Vergi No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="tax_number" id="tax_nunber" value="{{@$data->tax_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="identity_number" class="col-sm-2 control-label">TC Kimlik No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="identity_number" id="identity_number" value="{{@$data->identity_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @php($mailAllowed = $data->allowed_to_mail == '1' )
                                        @php($mailTextColor = $mailAllowed ? 'text-success' : 'text-danger')
                                        @php($mailIcon = $mailAllowed ? 'check' : 'times')
                                        <label class="col-sm-2 font-bold control-label {{ $mailTextColor }}">
                                            Elektronik İleti İzni
                                        </label>
                                        <div class="col-sm-3">
                                            <select name="allowed_to_mail"  class="selectpicker show-tick bs-select-hidden" data-style="form-control">
                                                <option {{ $mailAllowed ? ' selected ' : '' }} value="1">İzin Verildi</option>
                                                <option {{ !$mailAllowed ? ' selected ' : '' }} value="0">İzin Verilmedi</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <div style="font-size: 27px;" class="text-left">
                                                <i class="fa fa-{{ $mailIcon}} {{ $mailTextColor }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{@$data->phone}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phoneGsm" class="col-sm-2 control-label">Cep Telefonu</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="phoneGsm" id="phoneGsm" value="{{@$data->phoneGsm}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Adres</label>
                                        <div class="col-sm-3">
                                            <textarea class="form-control" name="address" id="address">{{@$data->Address->address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id" class="col-sm-2 control-label">Ülke</label>
                                        <div class="col-sm-3">
                                            <select name="country_id" class="country_id country-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->Address->countries_id}}">{{@$data->Address->country->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city_id" class="col-sm-2 control-label">Şehir</label>
                                        <div class="col-sm-3">
                                            <select name="city_id" class="city_id cities-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->Address->cities_id}}">{{@$data->Address->city->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="district_id" class="col-sm-2 control-label">İlçe</label>
                                        <div class="col-sm-3">
                                            <select name="district_id" id="district_id" class="districts-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->Address->districts_id}}">{{@$data->Address->district->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="postal_code" class="col-sm-2 control-label">Posta Kodu</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{@$data->Address->postal_code}}">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="shippingAddress">
                                    <h3 class="text-center">Teslimat Adres Listesi</h3>
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        @foreach ($data->getShippingAddress as $shipping)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="heading{{ $shipping->id }}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $shipping->id }}"
                                                        aria-expanded="false" aria-controls="collapse{{ $shipping->id }}">
                                                        <small>Adres Başlığı: </small><b>{{ $shipping->address_name }}</b>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse{{ $shipping->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $shipping->id }}">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Adres Başlığı</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][address_name]" value="{{ $shipping->address_name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Ad</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][name]" value="{{ $shipping->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Soyad</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][surname]" value="{{ $shipping->surname }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][phone]" id="phone" value="{{ $shipping->phone}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phoneGsm" class="col-sm-2 control-label">Cep Telefonu</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][phoneGsm]" id="phoneGsm" value="{{ $shipping->phoneGsm}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address" class="col-sm-2 control-label">Adres</label>
                                                        <div class="col-sm-3">
                                                            <textarea class="form-control" name="shipping[{{ $shipping->id }}][address]" id="address" required>{{ $shipping->address}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Şehir</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][city]" value="{{ $shipping->city }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">İlçe</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][state]" value="{{ $shipping->state }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">TC Kimlik Numarası</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="shipping[{{ $shipping->id }}][identity_number]" value="{{ $shipping->identity_number }}">
                                                            <small class="help-block">(Zorunlu Değil)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="billingAddress">
                                    <h3 class="text-center">Fatura Adres Listesi</h3>
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        @foreach ($data->getbillingAddress as $billing)
                                        <input type="hidden" name="type" value="{{ $billing->type }}">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="heading{{ $billing->id }}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $billing->id }}"
                                                        aria-expanded="false" aria-controls="collapse{{ $billing->id }}">
                                                        <small>Adres Başlığı: </small><b>{{ $billing->address_name }}</b>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse{{ $billing->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $billing->id }}">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Adres Başlığı</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][address_name]" value="{{ $billing->address_name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Ad</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][name]" value="{{ $billing->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Soyad</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][surname]" value="{{ $billing->surname }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][phone]" id="phone" value="{{ $billing->phone}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phoneGsm" class="col-sm-2 control-label">Cep Telefonu</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][phoneGsm]" id="phoneGsm" value="{{ $billing->phoneGsm}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address" class="col-sm-2 control-label">Adres</label>
                                                        <div class="col-sm-3">
                                                            <textarea class="form-control" name="billing[{{ $billing->id }}][address]" id="address" required>{{ $billing->address}}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Vergi Dairesi</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][tax_place]" value="{{ $billing->tax_place }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Vergi Numarası</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][tax_no]" value="{{ $billing->tax_no }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Şehir</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][city]" value="{{ $billing->city }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">İlçe</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][state]" value="{{ $billing->state }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">TC Kimlik Numarası</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="billing[{{ $billing->id }}][identity_number]" value="{{ $billing->identity_number }}">
                                                            <small class="help-block">(Zorunlu Değil)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Gönder</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $( document ).ready(function() {

            // Client Groups Ajax
            $(".group-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/customerGroups/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Müşteri Grubu Seçiniz',
            });


            // Countries Ajax
            $(".country-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/countries/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Ülke Seçiniz'
            });

            // Cities Ajax
            $(".cities-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/cities/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            country_id:$('.tab-pane.active').find('.country_id').val()
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Şehir Seçiniz'
            });

            // Districts Ajax
            $(".districts-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/districts/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            city_id:$('.tab-pane.active').find('.city_id').val()
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'İlçe Seçiniz'
            });

        });

    </script>
@endsection