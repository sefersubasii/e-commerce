@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Müşteri Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/customers')}}" class="btn btn-block btn-default btn-rounded">← Müşteriler</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Müşteri Ekle</h3>
                        <form method="post" action="{{url('admin/customers/create')}}" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel Bilgiler</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">İletişim Bilgileri</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1" selected="selected">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="group_id" class="col-sm-2 control-label">Müşteri Grubu</label>
                                        <div class="col-sm-3">
                                            <select name="group_id" class="group-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">İsim</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="name" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="surname" class="col-sm-2 control-label">Soyisim</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="surname" id="surname" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">E-Posta</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="email" id="email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sex" class="col-sm-2 control-label">Cinsiyet</label>
                                        <div class="col-sm-2">
                                            <select name="sex" id="sex" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1">Erkek</option>
                                                <option value="2">Kadın</option>
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
                                            <input type="text" class="form-control" name="company" id="company" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tax_office" class="col-sm-2 control-label">Vergi Dairesi</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="tax_office" id="tax_office" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tax_number" class="col-sm-2 control-label">Vergi No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="tax_number" id="tax_nunber" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="identity_number" class="col-sm-2 control-label">TC Kimlik No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="identity_number" id="identity_number" value="">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="phone" id="phone" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phoneGsm" class="col-sm-2 control-label">Cep Telefonu</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="phoneGsm" id="phoneGsm" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Adres</label>
                                        <div class="col-sm-3">
                                            <textarea class="form-control" name="address" id="address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id" class="col-sm-2 control-label">Ülke</label>
                                        <div class="col-sm-3">
                                            <select name="country_id" id="country_id" class="country-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city_id" class="col-sm-2 control-label">Şehir</label>
                                        <div class="col-sm-3">
                                            <select name="city_id" id="city_id" class="cities-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="district_id" class="col-sm-2 control-label">İlçe</label>
                                        <div class="col-sm-3">
                                            <select name="district_id" id="district_id" class="districts-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="postal_code" class="col-sm-2 control-label">Posta Kodu</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="postal_code" id="postal_code" value="">
                                        </div>
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
                            country_id:$('#country_id').val()
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
                            city_id:$('#city_id').val()
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