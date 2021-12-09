@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Kupon Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/campaigns/coupons')}}" class="btn btn-block btn-default btn-rounded">← Kuponlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Kupon Ekle</h3>
                        <form method="post" action="{{url('admin/campaigns/coupons/create')}}" class="form-horizontal form-bordered">

                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Kupon Kodu</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="code" id="code" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max_limit" class="col-sm-2 control-label">Max Kullanım Sayısı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="max_limit" id="max_limit" value="100">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="person_limit" class="col-sm-2 control-label">Kişi Başı Kullanım Sınırı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="person_limit" id="person_limit" value="1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usage" class="col-sm-2 control-label">Kullanım Tipi</label>
                                <div class="col-sm-2">
                                    <select name="usage" id="usage" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="1">Herkes</option>
                                        <option value="2">Belirli Müşteriler</option>
                                        <option value="3">Belirli Gruplar</option>
                                        <option value="4">Belirli Kategoriler</option>
                                        <option value="5">Belirli Ürünler</option>
                                        <option value="6">Belirli Markalar</option>
                                    </select>
                                </div>
                            </div>

                            <div id="usage_2" style="display:none;">
                                <div class="form-group">
                                    <label for="clients" class="col-sm-2 control-label">Müşteriler</label>
                                    <div class="col-sm-10">
                                        <select name="clients[]" id="clients" multiple="" class="clients-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="Müşteri Seçiniz" style="width: 100px;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>

                            <div id="usage_3" style="display:none;">
                                <div class="form-group">
                                    <label for="groups" class="col-sm-2 control-label">Müşteri Grupları</label>
                                    <div class="col-sm-10">
                                        <select name="groups[]" id="groups" multiple="" class="groups-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="Müşteri Grubu Seçiniz" style="width: 100px;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>

                            <div id="usage_4" style="display:none;">
                                <div class="form-group">
                                    <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                    <div class="col-sm-10">
                                        <select name="categories[]" id="categories" multiple="" class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="usage_5" style="display:none;">
                                <div class="form-group">
                                    <label for="products" class="col-sm-2 control-label">Ürünler</label>
                                    <div class="col-sm-10">
                                        <select name="products[]" id="products" multiple="" class="products-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="usage_6" style="display:none;">
                                <div class="form-group">
                                    <label for="brands" class="col-sm-2 control-label">Markalar</label>
                                    <div class="col-sm-10">
                                        <select name="brands[]" id="brands" multiple="" class="brands-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="start_date" class="col-sm-2 control-label">Başlangıç Tarihi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="06/02/2017">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="expire_date" class="col-sm-2 control-label">Bitiş Tarihi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control datepicker" name="expire_date" id="expire_date" value="13/02/2017">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">Değer Tipi</label>
                                <div class="col-sm-2">
                                    <select name="type" id="type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="1">Sabit</option>
                                        <option value="2">Yüzde</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-sm-2 control-label">Değer</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="value" id="value" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="free_shipping" class="col-sm-2 control-label">Kargo Bedava</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" name="free_shipping" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="discount_p" class="col-sm-2 control-label">İndirimli Ürünlerde Geçerli</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" name="discount_p" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usage_limit" class="col-sm-2 control-label">Kullanım Alışveriş Sınırı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="usage_limit" id="usage_limit" value="">
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
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>

        $( document ).ready(function() {

            $("#usage").on('change', function () {
                var value = $(this).val();
                if(value == 1){
                    $("#usage_2").hide();
                    $("#usage_3").hide();
                    $("#usage_4").hide();
                    $("#usage_5").hide();
                    $("#usage_6").hide();
                }else if(value == 2){
                    $("#usage_2").show();
                    $("#usage_3").hide();
                    $("#usage_4").hide();
                    $("#usage_5").hide();
                    $("#usage_6").hide();
                }else if(value == 3){
                    $("#usage_2").hide();
                    $("#usage_3").show();
                    $("#usage_4").hide();
                    $("#usage_5").hide();
                    $("#usage_6").hide();
                }else if(value == 4){
                    $("#usage_2").hide();
                    $("#usage_3").hide();
                    $("#usage_4").show();
                    $("#usage_5").hide();
                    $("#usage_6").hide();
                }else if(value == 5){
                    $("#usage_2").hide();
                    $("#usage_3").hide();
                    $("#usage_4").hide();
                    $("#usage_5").show();
                    $("#usage_6").hide();
                }else if(value == 6){
                    $("#usage_2").hide();
                    $("#usage_3").hide();
                    $("#usage_4").hide();
                    $("#usage_5").hide();
                    $("#usage_6").show();
                }
            });

            // Categories
            $(".categories-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/categories/ajax/list')}}",
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
                                return { id: item.id, text: item.title};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Kategori Seçiniz'
            });

            // Products
            $(".products-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/products/ajax/list')}}",
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
                placeholder: 'Ürün Seçiniz'
            });

            // Brands
            $(".brands-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/brands/ajax/list')}}",
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
                placeholder: 'Marka Seçiniz'
            });

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'tr',
                toggleActive: true
            });

        });

    </script>
@endsection

