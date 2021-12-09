@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">

                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Promosyon Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/campaigns/promotion')}}" class="btn btn-block btn-default btn-rounded">← Promosyonlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Promosyon Düzenle</h3>
                        <form method="post" action="{{url('admin/campaigns/promotion/update/'.$data->id)}}" class="form-horizontal form-bordered">

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Durum</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" name="status" {{$data->status == 1 ? "checked" : "" }} value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Promosyon Adı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="selectedDate" class="col-sm-2 control-label">Promosyonunuzda Tarih Aralığı Geçerli Olsun mu?</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" name="selectedDate" {{$data->selectedDate == 1 ? "checked" : "" }} value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>

                            <div {{$data->selectedDate==0 ? "style=display:none":""}} class="optional1">
                                <div class="form-group">
                                    <label for="start_date" class="col-sm-2 control-label">Başlangıç Tarihi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control datepicker" name="start_date" id="start_date" value={{str_replace("-","/",$data->startDate)}}>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="expire_date" class="col-sm-2 control-label">Bitiş Tarihi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control datepicker" name="expire_date" id="expire_date" value="{{str_replace("-","/",$data->stopDate)}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Promosyon Tanımı</label>
                                <div class="col-sm-10 radio-list">
                                    <label class="radio-inline p-0">
                                        <div class="radio radio-info">
                                            <input {{$data->type == 0 ? "checked":""}} type="radio" name="radio" id="radio1" value="0">
                                            <label for="radio1">Sepet Bazlı Promosyon</label>
                                        </div>
                                    </label>
                                    <label class="radio-inline">
                                        <div class="radio radio-info">
                                            <input {{$data->type == 1 ? "checked":""}} type="radio" name="radio" id="radio2" value="1">
                                            <label for="radio2">Ürün Bazlı Promosyon</label>
                                        </div>
                                    </label>
                                    <label class="radio-inline">
                                        <div class="radio radio-info">
                                            <input {{$data->type == 2 ? "checked":""}} type="radio" name="radio" id="radio3" value="2">
                                            <label for="radio3">Kategori veya Marka Bazlı Promosyon</label>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="max_limit" class="col-sm-2 control-label">Max Kullanım Sayısı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="max_limit" id="max_limit" value="{{$data->maxUsage}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group_id" class="col-sm-2 control-label">Müşteri Grubu</label>
                                <div class="col-sm-3">
                                    <select name="group_id" class="group-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                    <?php if($data->memberGroupId!=0){ ?>
                                            <option selected value="{{$data->memberGroupId}}">{{$data->group->name}}</option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div id="optional3" {{$data->type==0 ? "style=display:none" : ""}} class="form-group">
                                <label for="usebaseprice" class="col-sm-2 control-label">Kullanım Alışveriş Sınırı</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" {{$data->basePriceLimit != 0 ? "checked" : ""}} name="usebaseprice" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>

                            <div {{$data->basePriceLimit == 0 ? "style=display:none" : ""}}   id="optional4" class="form-group">
                                <label for="basePriceLimit" class="col-sm-2 control-label">Kullanım Alışveriş Sınırı</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="basePriceLimit" id="basePriceLimit" value="{{$data->basePriceLimit}}">
                                </div>
                                <label style="text-align: left;" class="col-sm-4 control-label" for="">TL üstü alışverişlerde kullanılabilsin.</label>
                            </div>

                            <div id="section3" style="{{$data->type == 2 ? "" : "display:none" }}">
                                <div class="form-group">
                                    <label for="category" class="col-sm-2 control-label">Kategoriler</label>
                                    <div class="col-sm-10">
                                        <select name="category" id="category" class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        <?php if($data->baseCategoryId!=null){ ?>
                                            <option selected value="{{$data->category->id}}">{{$data->category->title}}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand" class="col-sm-2 control-label">Markalar</label>
                                    <div class="col-sm-10">
                                        <select name="brand" id="brand" class="brands-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            <?php if($data->baseBrandId!=null){ ?>
                                            <option selected value="{{$data->brand->id}}">{{$data->brand->name}}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div {{$data->type != 1 ? "style=display:none" : ""}} id="section2">
                                <div class="form-group sectionin2">
                                    <label for="baseProducts" class="col-sm-2 control-label">Ana Ürünler</label>
                                    <div class="col-sm-10">
                                        <select name="baseProducts[]" id="baseProducts" multiple="" class="products-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            @if(!empty($data->baseProducts))
                                                @foreach($data->baseProducts as $item)
                                                    <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group sectionin2">
                                    <label class="col-sm-2 control-label">Promosyon Geçerlilik Kontrolü</label>
                                    <div class="col-sm-10 radio-list">
                                        <label class="radio-inline p-0">
                                            <div class="radio radio-info">
                                                <input {{@$data->baseProductsOperator==0?"checked":""}} type="radio" name="radio2" id="radio21" value="0">
                                                <label for="radio21">Ana ürünlerin birlikte alınması zorunlu olsun</label>
                                            </div>
                                        </label>
                                        <label class="radio-inline">
                                            <div class="radio radio-info">
                                                <input {{@$data->baseProductsOperator==1?"checked":""}} type="radio" name="radio2" id="radio22" value="1">
                                                <label for="radio22">Ana ürünlerden herhangi birinin alınması zorunlu olsun</label>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="baseCount" class="col-sm-2 control-label">Ana Ürünlerin Minimum Alım Adedi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="baseCount" id="baseCount" value="{{$data->baseCount}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="affectedProducts" class="col-sm-2 control-label">Ayrıca Promosyonlu Ürün Tanımlamak İster misiniz?</label>
                                <div class="col-sm-2">
                                    <input type="checkbox"  {{@$data->affectedProducts == null ? "" : "checked"}} name="affectedProducts" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                </div>
                            </div>
                        
                            <div  {{@$data->affectedProducts == null ? "style=display:none" : ""}} id="usage_5">

                                <div class="form-group">
                                    <label for="products" class="col-sm-2 control-label">Ürünler</label>
                                    <div class="col-sm-10">
                                        
                                        <select name="products[]" id="products" multiple="" class="products-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            @if(count(@$data->products)>0)
                                                @foreach(@$data->products as $item)
                                                    <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="affectedCount" class="col-sm-2 control-label">Promosyonlu Ürün Adedini Giriniz</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="affectedCount" id="affectedCount" value="{{$data->affectedCount}}">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="promotionDiscountType" class="col-sm-2 control-label">Promosyon Tipi</label>
                                <div class="col-sm-3">
                                    <select name="promotionDiscountType" class="promotionDiscountType js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">

                                        <option {{$data->promotionDiscountType=="rebateProduct" ? "selected":""}} value="rebateProduct">İndirim Miktarı (KDV Dahil)</option>
                                        <option {{$data->promotionDiscountType=="rebatePercentProduct" ? "selected":""}} value="rebatePercentProduct">% İndirim</option>

                                        @if($data->type==1 || $data->type==2)
                                            <option {{$data->promotionDiscountType=="fixedPrice" ? "selected":""}} id="fixedPrice" value="fixedPrice">Sabit Fiyat (KDV Dahil)</option>
                                        @endif

                                        @if($data->affectedProducts == null)
                                            <option {{$data->promotionDiscountType=="extraPoint" ? "selected":""}} id="extraPoint" value="extraPoint">Extra Puan</option>
                                        @else
                                            <option {{$data->promotionDiscountType=="free" ? "selected":""}} id="free" value="free">Bedava</option>
                                        @endif


                                    </select>
                                </div>
                            </div>

                            @if($data->promotionValue!=0)
                            <div id="optional2" class="form-group">
                                <label for="promotionValue" class="col-sm-2 control-label">Promosyon Değeri</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="promotionValue" id="promotionValue" value="{{$data->promotionValue}}">
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Açıklama</label>
                                <div class="col-sm-10">
                                    <textarea id="description" class="form-control" name="description" style="height: 140px;">{{$data->description}}</textarea>
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

            $("input[name=selectedDate]").on("change",function () {
                if ($(this).is(":checked"))
                {
                    $(".optional1").slideDown();
                }else{
                    $(".optional1").slideUp();
                }
            });
            $("input[name=affectedProducts]").on("change",function () {
                if ($(this).is(":checked"))
                {
                    if($("#radio1").is(":checked")) {
                        $(".promotionDiscountType").append('<option id="fixedPrice" value="fixedPrice">Sabit Fiyat (KDV Dahil)</option><option id="free" value="free">Bedava</option>');
                        $("#extraPoint").remove();
                    }else if($("#radio2").is(":checked") || $("#radio3").is(":checked"))
                    {
                        $("#extraPoint").remove();
                        $(".promotionDiscountType").append('<option id="free" value="free">Bedava</option>');
                    }

                    $("#usage_5").slideDown();
                }else{
                    if($("#radio1").is(":checked")){
                        $("#free, #fixedPrice").remove();
                        $(".promotionDiscountType").append('<option id="extraPoint" value="extraPoint">Extra Puan</option>');
                    }else if($("#radio2").is(":checked") || $("#radio3").is(":checked"))
                    {
                        $("#free").remove();
                        $(".promotionDiscountType").append('<option id="extraPoint" value="extraPoint">Extra Puan</option>');
                    }

                    $("#usage_5").slideUp();
                }
            });
            $("select[name=promotionDiscountType]").on("change",function () {
                if ($(this).val()=="free") {
                    $("#optional2").slideUp();
                }else{
                    $("#optional2").slideDown();
                }
            });

            $('input[name=radio]').on("change",function () {

                if($(this).val()==1) {
                    if($('input[name=affectedProducts]').is(':checked')){
                        $('input[name=affectedProducts]').next().trigger('click');
                    }

                    $(".promotionDiscountType").html(
                            '<option id="rebateProduct" value="rebateProduct" selected="selected">İndirim Miktarı (KDV Dahil)</option>'+
                            '<option id="rebatePercentProduct" value="rebatePercentProduct">% İndirim</option>'+
                            '<option id="fixedPrice" value="fixedPrice">Sabit Fiyat (KDV Dahil)</option>'+
                            '<option id="extraPoint" value="extraPoint">Extra Puan</option>'
                    );
                    $("#section2").show();
                    $("#optional3").show();
                    $("#optional4").hide();
                    $("#section3").hide();
                    $(".sectionin2").show();

                }else if($(this).val()==2) {
                    if($('input[name=affectedProducts]').is(':checked')){
                        $('input[name=affectedProducts]').next().trigger('click');
                    }

                    $(".promotionDiscountType").html(
                            '<option id="rebateProduct" value="rebateProduct" selected="selected">İndirim Miktarı (KDV Dahil)</option>'+
                            '<option id="rebatePercentProduct" value="rebatePercentProduct">% İndirim</option>'+
                            '<option id="fixedPrice" value="fixedPrice">Sabit Fiyat (KDV Dahil)</option>'+
                            '<option id="extraPoint" value="extraPoint">Extra Puan</option>'
                    );
                    $("#optional3").show();
                    $("#optional4").hide();
                    $(".sectionin2").hide();
                    $("#section3").show();
                }else{
                    if($('input[name=affectedProducts]').is(':checked')){
                        $('input[name=affectedProducts]').next().trigger('click');
                    }

                    $(".promotionDiscountType").html(
                            '<option id="rebateProduct" value="rebateProduct" selected="selected">İndirim Miktarı (KDV Dahil)</option>'+
                            '<option id="rebatePercentProduct" value="rebatePercentProduct">% İndirim</option>'+
                            '<option id="extraPoint" value="extraPoint">Extra Puan</option>'
                    );
                    $("#optional3").hide();
                    $("#optional4").show();
                    $("#section2").hide();
                    $("#section3").hide();
                }

            });

            $("input[name=usebaseprice]").on("change",function () {
                if ($(this).is(":checked")){
                    $("#optional4").slideDown();
                }else{
                    $("#optional4").slideUp();
                }

            });

            $(".promotionDiscountType").select2();

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
            var newState = new Option("Tümü", "0", false, false);
            $(".group-ajax").append(newState);


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

