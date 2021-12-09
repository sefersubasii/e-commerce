@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">

                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <?php /*
                    <a href="#" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Buy Now
                    </a>
                    */ ?>

                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15"> Raporlar</h3>
                        <form autocomplete="off" method="post" action="{{url('admin/settings//')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Sipariş Raporları</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs"> Ürün Raporları</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">

                                    <div class="form-group">
                                        <label for="orderDate" class="col-sm-2 control-label">Tarih Aralığı Filtresi</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" id="orderDate" name="orderDate" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label for="start_date" class="col-sm-2 control-label">Tarih</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" name="expire_date" id="expire_date" value="">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="time" class="col-sm-2 control-label">Saat</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="time" name="time1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="time2" name="time1">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment" class="col-sm-2 control-label">Ödeme Türü</label>
                                        <div class="col-sm-2">
                                            <select name="payment" id="payment" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="">Tümü</option>
                                                <option value="1">Havale</option>
                                                <option value="3">Kredi Kartı</option>
                                                <option value="2">Kapıda Ödeme Nakit</option>
                                                <option value="4">Kapıda Ödeme Kredi Kartı</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Sipariş Durumu</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="">Tümü</option>
                                                <option value="0">Onay Bekliyor</option>
                                                <option value="1">Onaylandı</option>
                                                <option value="2">Kargoya Verildi</option>
                                                <option value="3">İptal Edildi</option>
                                                <option value="4">Teslim Edildi</option>
                                                <option value="5">Tedarik sürecinde</option>
                                                <option value="6">Ödeme Bekleniyor</option>
                                                <option value="7">Hazırlanıyor</option>
                                                <option value="8">İade Edildi</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <input type="button" class="btn btn-success buttonLarge" onclick="javascript:PrintExcel('OrderReport');" value="Excel'e Aktar">
                                        </div>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">

                                    <div class="form-group">
                                        <label for="orderDatetab2" class="col-sm-2 control-label">Tarih Aralığı Filtresi</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" id="orderDatetab2" name="orderDatetab2" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label for="start_date_tab2" class="col-sm-2 control-label">Tarih</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" name="start_date_tab2" id="start_date_tab2" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" name="expire_date_tab2" id="expire_date_tab2" value="">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="time" class="col-sm-2 control-label">Saat</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="time_tab2" name="time1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="time2_tab2" name="time2">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                        <div class="col-sm-10">
                                            <select name="categories[]" id="categories" multiple=""  class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="brands" class="col-sm-2 control-label">Markalar</label>
                                        <div class="col-sm-10">
                                            <select name="brands[]" id="brands" multiple="" class="brands-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="statusreport" class="col-sm-2 control-label">Sipariş Durumu</label>
                                        <div class="col-sm-2">
                                            <select name="statusreport" id="statusreport" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="">Tümü</option>
                                                <option value="0">Onay Bekliyor</option>
                                                <option value="1">Onaylandı</option>
                                                <option value="2">Kargoya Verildi</option>
                                                <option value="3">İptal Edildi</option>
                                                <option value="4">Teslim Edildi</option>
                                                <option value="5">Tedarik sürecinde</option>
                                                <option value="6">Ödeme Bekleniyor</option>
                                                <option value="7">Hazırlanıyor</option>
                                                <option value="8">İade Edildi</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment" class="col-sm-2 control-label">Ürün Raporu</label>
                                        <div class="col-sm-4">
                                            <input type="button" class="btn btn-success buttonLarge" onclick="javascript:PrintExcel('ProductReport');" value="Excel'e Aktar">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment" class="col-sm-2 control-label">Ürün Satış Raporu</label>
                                        <div class="col-sm-4">
                                            <input type="button" class="btn btn-success buttonLarge" onclick="javascript:PrintExcel('exportProductsSalesExcel');" value="Excel'e Aktar">
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
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.tr.js')}}"></script>
    <script>

    function PrintExcel(type){
        switch(type){
            case "OrderReport":
                var date1 = $("#start_date").val();
                var date2 = $("#expire_date").val();
                var hour1 = $("#time").val();
                var hour2 = $("#time2").val();
                var ek    = '';

                if(hour1 && hour2){
                    if(hour1 > hour2){
                        return alert('Saat Aralığı Hatalıdır');
                    }else {
                        ek += '&time1=' + hour1 + '&time2=' + hour2;
                    }
                }

                var paymentType = $("#payment").val();
                var orderStatus = $("#status").val();

                if($('#orderDate').is(':checked')){
                    window.open('reports/exportOrdersExcel?type='+type+'&date1='+date1+'&date2='+date2+'&payment_type='+paymentType+'&status='+orderStatus+ek, '_blank');
                }else{
                    window.open('reports/exportOrdersExcel?type='+type+'&payment_type='+paymentType+'&status='+orderStatus+ek, '_blank');
                }
            break;
            case "ProductReport":
                var ek="";
                var date1 = $("#start_date_tab2").val();
                var date2 = $("#expire_date_tab2").val();
                var hour1 = $("#time_tab2").val();
                var hour2 = $("#time2_tab2").val();
                var categories = $("#categories").val();
                var brands = $("#brands").val();
                var orderStatus = $("#statusreport").val();

                if (date1 && date2 && $('#orderDatetab2').is(':checked')) {
                    ek+='&added_date1='+date1+'&added_date2='+date2;
                }

                if(hour1 && hour2){
                    if(hour1 > hour2){
                        return alert('Saat Aralığı Hatalıdır');
                    }else {
                        ek += '&time1=' + hour1 + '&time2=' + hour2;
                    }
                }

                if(orderStatus){
                    ek += '&status=' + orderStatus;
                }

                if (brands.length) {
                    ek += '&brand_ids[]='+brands;
                }

                if (categories.length) {
                    ek += '&category_ids[]='+categories;
                }

                window.open('reports/exportProductsExcel?type=' + type + ek);
                 //window.open('reports/exportProductsExcel?type='+type+'&added_date1='+date1+'&added_date2='+date2+'&category_ids[]='+categories+'&brand_ids[]='+brands);
            break;
            case "exportProductsSalesExcel":
                var ek="";
                var date1 = $("#start_date_tab2").val();
                var date2 = $("#expire_date_tab2").val();
                var hour1 = $("#time_tab2").val();
                var hour2 = $("#time2_tab2").val();
                var categories = $("#categories").val();
                var brands = $("#brands").val();
                var orderStatus = $("#statusreport").val();

                if (date1 && date2 && $('#orderDatetab2').is(':checked')) {
                    ek+='&date1='+date1+'&date2='+date2;
                }

                if(hour1 && hour2){
                    if(hour1 > hour2){
                        return alert('Saat Aralığı Hatalıdır');
                    }else {
                        ek += '&time1=' + hour1 + '&time2=' + hour2;
                    }
                }

                if(orderStatus){
                    ek += '&order_status=' + orderStatus;
                }

                if (brands.length) {
                    ek += '&brand_ids[]='+brands;
                }

                if (categories.length) {
                    ek += '&category_ids[]='+categories;
                }

                window.open('reports/exportProductsSalesExcel?type=' + type + ek);
            break;
        }
    }

    $( document ).ready(function() {

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
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'tr',
            toggleActive: true
        });

    });

    </script>
@endsection
