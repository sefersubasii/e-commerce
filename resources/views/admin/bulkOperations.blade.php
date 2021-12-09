@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper" style="min-height: 376px;">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-12">
                    <h4 class="page-title">Toplu Ürün İşlemleri</h4>
                </div>
            </div>


            <form action="{{url('admin/bulkOperations/process')}}" method="post" id="processForm" class="form-horizontal" role="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Ürün Filtreleme</div>
                            <div class="panel-wrapper">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status" class="col-sm-5 control-label">Durum</label>
                                                <div class="col-sm-7">
                                                    <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%"><option class="bs-title-option" value="">Seçiniz</option>
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php /*
                                            <div class="form-group">
                                                <label for="p_types" class="col-sm-5 control-label">Ürün Tipi</label>
                                                <div class="col-sm-7">
                                                    <select name="p_types[]" id="p_types" multiple="multiple" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
                                                        <option value="s_new">Yeni Ürün</option>
                                                        <option value="s_category">Kategori Vitrini</option>
                                                        <option value="s_campaign">Kampanyalı Ürün</option>
                                                        <option value="s_sponsor">Sponsor Ürün</option>
                                                        <option value="s_showcase">Vitrin Ürünü</option>
                                                        <option value="s_brand">Marka Vitrini</option>
                                                        <option value="s_sell">Çok Satan Ürün</option>
                                                        <option value="s_popular">Popüler Ürün</option>
                                                    </select>
                                                </div>
                                            </div>
                                            */ ?>
                                            <div class="form-group">
                                                <label for="p_id" class="col-sm-5 control-label">Ürün ID</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="p_id" id="p_id" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-5 control-label">Ürün Adı</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="stock_code" class="col-sm-5 control-label">Stok Kodu</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="stock_code" id="stock_code" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="category_id" class="col-sm-5 control-label">Kategori</label>
                                                <div class="col-sm-7">
                                                    <select name="category_id" id="category_id" class="category-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="brand_id" class="col-sm-5 control-label">Marka</label>
                                                <div class="col-sm-7">
                                                    <select name="brand_id" id="brand_id" class="brand-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                    </select>
                                                </div>
                                            </div>
                                            <?php /*
                                            <div class="form-group">
                                                <label for="supplier_id" class="col-sm-5 control-label">Tedarikçi</label>
                                                <div class="col-sm-7">
                                                    <select name="supplier_id" id="supplier_id" class="supplier-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="sale_price1" class="col-sm-5 control-label">Satış Fiyatı</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="sale_price1" id="sale_price1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="sale_price2" id="sale_price2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            */ ?>
                                            <div class="form-group">
                                                <label for="price1" class="col-sm-5 control-label">Fiyatı</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="price1" id="price1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="price2" id="price2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tax_id" class="col-sm-5 control-label">KDV</label>
                                                <div class="col-sm-7">
                                                    <select name="tax_id" id="tax_id" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
                                                        <option value="8">8%</option>
                                                        <option value="18">18%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="barcode" class="col-sm-5 control-label">Barkod</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="barcode" id="barcode" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="stock_type" class="col-sm-5 control-label">Stok Tipi</label>
                                                <div class="col-sm-7">
                                                    <select name="stock_type" id="stock_type" multiple="multiple" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
                                                        <option value="1">Adet</option>
                                                        <option value="2">Cm</option>
                                                        <option value="3">Düzine</option>
                                                        <option value="4">Gram</option>
                                                        <option value="5">Kg</option>
                                                        <option value="6">Kişi</option>
                                                        <option value="7">Paket</option>
                                                        <option value="8">Metre</option>
                                                        <option value="9">m2</option>
                                                        <option value="10">Çift</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="stock1" class="col-sm-5 control-label">Stok</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="stock1" id="stock1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="stock2" id="stock2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="added_date1" class="col-sm-5 control-label">Eklenme Tarihi</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="added_date1" id="added_date1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="added_date2" id="added_date2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="discount_type" class="col-sm-5 control-label">İndirim</label>
                                                <div class="col-sm-7">
                                                    <select name="discount_type" id="discount_type"  class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
                                                        <option value="1">Yüzdeli İndirim (%)</option>
                                                        <option value="2">İndirimli Fiyat</option>
                                                        <option value="3">İndirim Oranı</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="discount1" class="col-sm-5 control-label">İndirim</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="discount1" id="discount1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="discount2" id="discount2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php /*
                                            <div class="form-group">
                                                <label for="cargo_weight1" class="col-sm-5 control-label">Kargo Ağırlığı</label>
                                                <div class="col-sm-7">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" name="cargo_weight1" id="cargo_weight1" value="">
                                                        <span class="input-group-addon bg-default b-0">ve</span>
                                                        <input type="text" class="form-control" name="cargo_weight2" id="cargo_weight2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cargo_type" class="col-sm-5 control-label">Ağırlık Birimi</label>
                                                <div class="col-sm-7">
                                                    <select name="cargo_type" id="cargo_type" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%"><option class="bs-title-option" value="">Seçiniz</option>
                                                        <option value="1">Kg</option>
                                                        <option value="2">Gr</option>
                                                        <option value="3">Desi</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="detail_filter" class="col-sm-5 control-label">Diğer</label>
                                                <div class="col-sm-7">
                                                    <select name="detail_filter" id="detail_filter" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-live-search="true" data-style="form-control" data-width="100%"><option class="bs-title-option" value="">Seçiniz</option>
                                                        <optgroup label="Tarihe Göre Filtreleme">
                                                            <option value="1">Bugün Eklenenler</option>
                                                            <option value="2">Dün Eklenenler</option>
                                                            <option value="3">Son 1 Haftada Eklenenler</option>
                                                            <option value="4">Son 2 Haftada Eklenenler</option>
                                                            <option value="5">Son 1 Ayda Eklenenler</option>
                                                        </optgroup>
                                                        <optgroup label="Satışa Göre Filtreleme">
                                                            <option value="6">En Çok Satılanlar</option>
                                                            <option value="7">En Az Satılanlar</option>
                                                        </optgroup>
                                                        <optgroup label="Özelliğe Göre Filtreleme">
                                                            <option value="8">Resimli Ürünler</option>
                                                            <option value="9">Resimsiz Ürünler</option>
                                                            <option value="10">Açıklamalı Ürünler</option>
                                                            <option value="11">Açıklamasız Ürünler</option>
                                                            <option value="12">KDV Dahil Ürünler</option>
                                                            <option value="13">KDV Hariç Ürünler</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            */ ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="pull-left">
                                    <button type="button" id="ajax_total" class="btn btn-outline btn-default"> <i class="fa fa-check"></i> Sonuçları Listele</button>
                                    <button type="button" onclick="$.clearFilter()" class="btn btn-outline btn-default"> <i class="fa fa-times"></i> Temizle</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Yapılacak İşlemler</div>
                            <div class="panel-wrapper">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div id="ajax_result">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-12" style="margin-bottom:8px;">Ürünlere uygulamak istediğiniz işlemi belirleyin.</label>
                                            <div class="col-sm-12">
                                                <select name="action_type" id="action_type" class="selectpicker bs-select-hidden" data-live-search-normalize="true" data-dropup-auto="false" title="Seçiniz" data-size="5" data-live-search="true" data-style="form-control" data-width="100%"><option class="bs-title-option" value="">Seçiniz</option>
                                                    <optgroup label="Fiyat">
                                                        <option value="price_change">Fiyat Değiştir</option>
                                                        <option value="tax_change">KDV Ayarlarını Değiştir</option>
                                                        <option value="discount_change">İndirim Fiyatını Değiştir</option>
                                                    </optgroup>
                                                    <optgroup label="Ürün">
                                                        <option value="status_update">Durum Değiştir</option>
                                                        <?php /*
                                                        <option value="product_type">Tip Değiştir</option>
                                                        */ ?>
                                                        <option value="delete_product">Sil</option>
                                                    </optgroup>
                                                    <optgroup label="Stok">
                                                        <option value="stock_change">Stokları Belirle</option>
                                                        <option value="stock_reset">Stokları Sıfırla</option>
                                                    </optgroup>
                                                    <optgroup label="Kargo">
                                                        <option value="shipping_price_change">Kargo Fiyatı</option>
                                                    </optgroup>
                                                    <?php /*
                                                    <optgroup label="Kategori">
                                                        <option value="category_move">Kategorilere Taşı</option>
                                                        <option value="category_add">Kategorilere Ekle</option>
                                                        <option value="category_reset">Kategorileri Sıfırla</option>
                                                    </optgroup>

                                                    <optgroup label="Marka">
                                                        <option value="brand_update">Marka Güncelle</option>
                                                        <option value="brand_reset">Marka Sıfırla</option>
                                                    </optgroup>
                                                    */ ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="process_type" id="process_type" value="status_update">
                                        <div id="action_template"><h3 class="box-title">Ürün Durumunu Değiştir</h3>
                                            <div class="alert alert-default" role="alert"> <span class="glyphicon glyphicon-exclamation-sign"></span> Seçili işlem bulunamadı. Lütfen bir işlem seçiniz.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box" style="padding:15px!important;">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" onclick="$.formSubmit('processForm');" class="btn btn-success"><i class="fa fa-check"></i> İşlemi Başlat</button>
                                                <button type="button" id="action_reset" class="btn btn-outline btn-default"><i class="fa fa-times"></i> İşlemi Sıfırla</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>

        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });

        $(function() {
            $("#ajax_total").on('click', function(){

                var form = $('#processForm')[0];
                var formData = new FormData(form);
                formData.append('_token',$('meta[name=_token]').attr("content"));

                $.ajax({
                    type:'POST',
                    contentType: false,
                    processData: false,
                    url: "{{'bulkOperations/ajaxTotalProducts'}}",
                    data: formData,
                    success: function(response){
                        $("#ajax_result").html('');
                        $("#ajax_result").html('<div style="margin-bottom: 20px;"><div class="alert alert-danger" style="margin-top: 0!important;"><span class="glyphicon glyphicon-exclamation-sign"></span> Toplam '+response+' sonuç etkilenecektir.</div></div>');
                    },
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Yükleniyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });
            });

            $("#action_reset").on("click", function(){
                HoldOn.open({
                    theme:"sk-bounce",
                    message: "Sıfırlanıyor..."
                });
                $(this).selectpicker('val', '');
                $("#action_template").html("");
                $("#ajax_result").html('');
                $("#process_type").val("");
                $.clearFilter();
                HoldOn.close();
            });

            $.formSubmit = function(form_id) {
                swal({
                    title: "Bu işlemi başlatmak istediğinize emin misiniz ?",
                    text: "Eğer bu işlemi yaparsanız bir daha geri alamazsınız.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Devam Et",
                    cancelButtonText: "İptal Et",
                    closeOnConfirm: true
                }, function(){
                    $(".add_form").each(function (index, value) {
                        $(value).appendTo(value);
                    });

                    $('#processForm')[0].submit();
                });

            };

            $("#action_type").on('change', function(){
                var value = $(this).val();
                if(value){
                    $.ajax({
                        url: "{{url('admin/bulkOperations/template')}}",
                        data: {value:value},
                        success: function(response){
                            $("#action_template").html("");
                            if(response){
                                $("#action_template").html(response);
                            }
                        },
                        beforeSend: function () {
                            HoldOn.open({
                                theme:"sk-bounce",
                                message: "Yükleniyor..."
                            });
                        },
                        complete: function () {
                            HoldOn.close();
                        }
                    });
                }

                $("#process_type").val(value);
                //$(this).selectpicker('val', '');
            });

            $("#price_action").on('change', function(){
                var value = $(this).is(':checked');
                if(value == true){
                    $("#action_1").show();
                }else{
                    $("#action_1").hide();
                }
            });

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            $('#date-range').datepicker({
                language:'tr',
                toggleActive: true,
                format:'dd/mm/yyyy'
            });

            // Category Ajax
            $(".category-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/categories/ajax/list')}}",
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
                                return { id: item.id, text: item.title };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Kategori Seçiniz',
            });

            // Brand Ajax
            $(".brand-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/brands/ajax/list')}}",
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
                placeholder: 'Marka Seçiniz',
            });

            // Supplier Ajax
            $(".supplier-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/suppliers/ajax/list')}}",
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
                                return { id: item.id, text: item.s_name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Tedarikçi Seçiniz',
            });

            $.clearFilter = function(){
                $('#status').selectpicker('val', '');
                $('#p_types').selectpicker('val', '');
                $('#p_id').val("");
                $('#name').val("");
                $('#stock_code').val("");
                $('#category_id').val('').change();
                $('#brand_id').val('').change();
                $('#supplier_id').val('').change();
                $('#sale_price1').val("");
                $('#sale_price2').val("");
                $('#buying_price1').val("");
                $('#buying_price2').val("");
                $('#barcode').val("");
                $('#stock_type').selectpicker('val', '');
                $('#stock1').val("");
                $('#stock2').val("");
                $('#tax_id').val('').change();
                $('#added_date1').val("");
                $('#added_date2').val("");
                $('#discount_type').selectpicker('val', '');
                $('#discount1').val("");
                $('#discount2').val("");
                $('#cargo_weight1').val("");
                $('#cargo_weight2').val("");
                $('#cargo_type').selectpicker('val', '');
                $('#detail_filter').selectpicker('val', '');
            };
        });

    </script>

@endsection
