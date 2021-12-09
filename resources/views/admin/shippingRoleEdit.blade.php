@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Rol Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/shippingRoles')}}" class="btn btn-block btn-default btn-rounded">← Roller</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Rol Düzenle</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{url('admin/shippingRoles/update/'.$data->id)}}" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel Bilgiler</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Oranlar</span></a></li>
                                <li role="presentation" class=""><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Desi Ayarları</span></a></li>
                                <li role="presentation" class=""><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Slot Ayarları</span></a></li>
                                <li role="presentation" class=""><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Özel Fiyat</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Rol Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_id" class="col-sm-2 control-label">Kargo Firması</label>
                                        <div class="col-sm-10">
                                            <select name="company_id" class="shippingCompany-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{$data->company->id}}">{{$data->company->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-2 control-label">Kullanım Tipi</label>
                                        <div class="col-sm-2">
                                            <select name="type" id="type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{$data->type == 1 ? "selected='selected'" : "" }} value="1">Bölge</option>
                                                <option {{$data->type == 2 ? "selected='selected'" : "" }} value="2">Ülke</option>
                                                <option {{$data->type == 3 ? "selected='selected'" : "" }} value="3">Şehir</option>
                                                <?php /* <option {{$data->type == 4 ? "selected='selected'" : "" }} value="4">İlçe</option> */ ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_1" style="display: none;">
                                        <label for="regions" class="col-sm-2 control-label">Bölgeler</label>
                                        <div class="col-sm-10">
                                            <select name="regions[]" id="regions" multiple="" class="regions-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_2" style="">
                                        <label for="countries" class="col-sm-2 control-label">Ülkeler</label>
                                        <div class="col-sm-10">
                                            <select name="countries[]" id="countries" multiple="" class="country-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->contryResult->id}}">{{@$data->contryResult->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_3" style="">
                                        <label for="cities" class="col-sm-2 control-label">Şehirler</label>
                                        <div class="col-sm-10">
                                                
                                            <select name="cities[]" id="cities" multiple="" class="cities-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                
                                                @if(count($data->valuesResult)>0)
                                                @foreach($data->valuesResult as $item)
                                                    @if($item)
                                                    <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <?php /*
                                    <div class="form-group" id="type_4" style="display:none">
                                        <label for="districts" class="col-sm-2 control-label">İlçeler</label>
                                        <div class="col-sm-10">
                                            <select name="districts[]" id="districts" multiple="" class="districts-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>
                                    */ ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="weight_price" class="col-sm-2 control-label">+1 Desi Ücreti</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="weight_price" id="weight_price" value="{{$data->weight_price}}">
                                    <span class="help-block">
                                        Kargo firması için girmiş olduğunuz desi bilgileri 50 Desiye kadar girilebilmektedir. 50'nin üzeri veya girmiş olduğunuz desi miktarının üzerine her +1 desi için eklenecek olan kargo ücreti
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fixed_price" class="col-sm-2 control-label">Sabit Ücret</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="fixed_price" id="fixed_price" value="{{$data->fixed_price}}">
                                    <span class="help-block">
                                        Sabit bir kargo ücreti uygulayacaksanız her sipariş için sabit kargo ücreti girebilirsiniz. Desi bilgilerini kaydetmeniz durumunda desi toplamlarının üzerine sabit ücret eklenecektir.
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="free_shipping" class="col-sm-2 control-label">Ücretsiz Kargo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="free_shipping" id="free_shipping" value="{{$data->free_shipping}}">
                                    <span class="help-block">
                                        Alışveriş sepeti toplamı belirlediğiniz Ücretsiz kargo limitini geçtiğinde müşterileriniz ücretsiz kargo hizmetinden faydalanabilirler.<b style="color:red">(Örn: X Lira üzeri ücretsiz Kargo!)</b>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight_limit" class="col-sm-2 control-label">Ücretsiz Desi Limiti</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="weight_limit" id="weight_limit" value="{{$data->weight_limit}}">
                                            <span class="help-block">Ücretsiz kargo miktarı için maksimum ücretsiz desi miktarıdır. Alışveriş sırasındaki desi miktarı ücretsiz desi miktarından fazlaysa, + Desi miktarını sipariş sırasında sistem müşteriden tahsil eder.<b style="color:red">(Örn: X TL üzeri ücretsiz kargo! Fakat X desiye kadar)</b> Üzeri müşteriden tahsil edilir.</span>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab3">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="10%">Desi</th>
                                                <th>Fiyat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(json_decode($data->desi) as $k => $v )
                                                    <tr>
                                                        <td><?= $k == 0 ? "0-1" : $k ?></td>
                                                        <td><input type="text" class="form-control" value="{{$v}}" name="oranlar[{{$k}}]"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab4">
                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-1 control-label">Ekle</label>
                                        <button id="addSlot" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                    </div>

                                    @if(count($slots)>0)

                                        @foreach($slots as $slot)

                                        <div class="form-group">
                                            <label for="" class="col-sm-1 control-label">Saat</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="time1[]" id="" value="{{$slot->time1}}">
                                            </div>
                                            <label for="" class="col-sm-1 control-label">Saat</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="time2[]" id="" value="{{$slot->time2}}">
                                            </div>
                                            <label for="" class="col-sm-1 control-label">Adet</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="max[]" id="" value="{{$slot->max}}">
                                            </div>
                                            <label for="" class="col-sm-1 control-label">Sil</label>
                                            <div class="col-sm-2">
                                                <button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                            </div>
                                        </div>

                                        @endforeach

                                    @endif
                    
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab5">
                                    <div class="form-group">
                                        <label for="addCustomPrice" class="col-sm-1 control-label">Özel Fiyat Ekle</label>
                                        <button type="button" id="addCustomPrice" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                    </div>

                                    @if($customPrices = $data->custom_prices)
                                        @foreach ($customPrices['conditions'] as $customPriceIndex => $customPrice)
                                            @php($cartAmountStart = $customPrices['cartAmountStart'][$customPriceIndex])
                                            @php($cartAmountEnd = $customPrices['cartAmountEnd'][$customPriceIndex])
                                            @php($shippingPrice = $customPrices['shippingPrice'][$customPriceIndex])

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Koşul</label>
                                                <div class="col-sm-2"> 
                                                    <select required data-old="between" name="customPrices[conditions][]" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                        <option value="between">Arasında</option>
                                                    </select>
                                                </div>
                                                <label class="col-sm-1 control-label">Sepet Tutarı</label>
                                                <div class="col-sm-3 cart-inputs">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input required type="number" min="0" class="form-control" name="customPrices[cartAmountStart][]" value="{{ $cartAmountStart }}" placeholder="Sepet minimum tutarı">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input required type="number" min="0" class="form-control" name="customPrices[cartAmountEnd][]" value="{{ $cartAmountEnd }}" placeholder="Sepet maksimum tutarı">
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-sm-1 control-label">Kargo Ücreti</label>
                                                <div class="col-sm-2">
                                                    <input required type="text" class="form-control entryDecimal" name="customPrices[shippingPrice][]" value="{{ $shippingPrice }}">
                                                </div>
                                                <label for="" class="col-sm-1 control-label">Sil</label>
                                                <div class="col-sm-1">
                                                    <button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>

        $( document ).ready(function() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            $("#type").on('change', function () {
                var value = $(this).val();
                if(value == 1){
                    $("#type_1").show();
                    $("#type_2").hide();
                    $("#type_3").hide();
                    $("#type_4").hide();
                }else if(value == 2){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").hide();
                    $("#type_4").hide();
                }else if(value == 3){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").show();
                    $("#type_4").hide();
                }else if(value == 4){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").show();
                    $("#type_4").show();
                }
            });

            $('#addSlot').on('click',function(e){
                e.preventDefault();
                $('#tab4').append('<div class="form-group"><label class="col-sm-1 control-label">Saat</label><div class="col-sm-2"><input type="text" class="form-control" name="time1[]" id="" value=""></div><label class="col-sm-1 control-label">Saat</label><div class="col-sm-2"><input type="text" class="form-control" name="time2[]" id="" value=""></div><label class="col-sm-1 control-label">Adet</label><div class="col-sm-2"><input type="text" class="form-control" name="max[]" id="" value=""></div><label for="" class="col-sm-1 control-label">Sil</label><div class="col-sm-2"><button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></div></div>');
            });

            $.customPriceCondition = function(element, parentElement, e){
                element = $(element);
                let cardInputs = $('.cart-inputs', parentElement);
                let oldCondition = element.data('old');
                let newCondition = element.val();

                let oneInpuTemplate = `
                    <input type="number" min="0" class="form-control" name="customPrices[cartAmount][]" placeholder="Sepet tutarı">
                `;
                let twoInputTemplate = `
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="number" min="0" class="form-control" name="customPrices[cartAmountStart][]">
                        </div>
                        <div class="col-sm-6">
                            <input type="number" min="0" class="form-control" name="customPrices[cartAmountEnd][]">
                        </div>
                    </div>
                `;

                if(newCondition == 'between'){
                    cardInputs.html(twoInputTemplate);
                }else if(oldCondition == 'between'){
                    cardInputs.html(oneInpuTemplate);
                }

                element.data('old', newCondition);
            };

            $('#addCustomPrice').on('click',function(e){
                let customPriceTemplate = `<div class="form-group">
                    <label class="col-sm-1 control-label">Koşul</label>
                    <div class="col-sm-2"> 
                        <select required name="customPrices[conditions][]" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                            <option value="between">Arasında</option>
                        </select>
                    </div>
                    <label class="col-sm-1 control-label">Sepet Tutarı</label>
                    <div class="col-sm-3 cart-inputs">
                        <div class="row">
                            <div class="col-sm-6">
                                <input required type="number" min="0" class="form-control" name="customPrices[cartAmountStart][]" placeholder="Sepet minimum tutarı">
                            </div>
                            <div class="col-sm-6">
                                <input required type="number" min="0" class="form-control" name="customPrices[cartAmountEnd][]" placeholder="Sepet maksimum tutarı">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-1 control-label">Kargo Ücreti</label>
                    <div class="col-sm-2">
                        <input required type="number" min="0" class="form-control" name="customPrices[shippingPrice][]">
                    </div>
                    <label for="" class="col-sm-1 control-label">Sil</label>
                    <div class="col-sm-1">
                        <button onclick="$(this).parent().parent().remove();" type="button" class="btn btn-danger">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>`;

                $('#tab5').append(customPriceTemplate);

                $('.selectpicker').selectpicker();
            });

            // Shipping Company Ajax
            $(".shippingCompany-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/shippingCompanies/ajax/list')}}",
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
                placeholder: 'Kargo Firması Seçiniz'
            });

            // Regions Ajax
            $(".regions-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/regions/ajax/list')}}",
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
                placeholder: 'Bölge Seçiniz'
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
                            country_id:$('#countries').val()
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
                            city_id:$('#cities').val()
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