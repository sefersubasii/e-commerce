@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Ürün ve Stok Butonları</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light" href="{{url('admin/productButton/descriptions')}}"> Tanımlar </a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="alert alert-warning fade in alert-dismissable text-center">
                <strong>Ürün ve stok butonlarının resim tanımlamalarına, sağ üst tarafta bulunan <u><i>Tanımlar</i></u> alanından ulaşabilirsiniz.</strong>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <a href="#" data-perform="panel-collapse">
                            <div class="panel-heading">Ürün Filtreleme <div class="pull-right"><i class="ti-minus"></i></div></div>
                        </a>
                        <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form method="POST" id="search-form" class="form-horizontal" role="form">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status" class="col-sm-5 control-label">Durum</label>
                                            <div class="col-sm-7">
                                                <select name="status" id="status" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    <option value="">Seçiniz</option>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id" class="col-sm-5 control-label">Ürün ID</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="id" id="id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-5 control-label">Ürün Adı</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stock_code" class="col-sm-5 control-label">Stok Kodu</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="stock_code" id="stock_code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category_id" class="col-sm-5 control-label">Kategori</label>
                                            <div class="col-sm-7">
                                                <select name="category_id"  id="category_id" class="category-ajax js-states form-control" tabindex="-1" style="display: none; width: 100%">
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="brand_id" class="col-sm-5 control-label">Marka</label>
                                            <div class="col-sm-7">
                                                <select name="brand_id" id="brand_id" class="brand-ajax js-states form-control" tabindex="-1" style="display: none; width: 100%">
                                                </select>
                                            </div>
                                        </div>
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
                                                    <option value="">Seçiniz</option>
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
                                                <select name="stock_type" id="stock_type" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    <option value="">Seçiniz</option>
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
                                                    <input type="text" class="form-control" name="stock1" id="stock1">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input type="text" class="form-control" name="stock2" id="stock2">
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
                                                <select name="discount_type" id="discount_type"  class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    <option value="">Seçiniz</option>
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
                                        <div class="form-group">
                                            <label for="hasNotCat" class="col-sm-5 control-label">Kategorisi Olmayan</label>
                                            <div class="col-sm-7">
                                                <input type="checkbox" id="hasNotCat" name="hasNotCat" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="form-actions" style="border-top:1px solid #f1f2f7; padding-top:10px;">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-search"></i> Arama</button>
                                                <button type="button" id="clear_btn" class="btn btn-outline btn-default"> <i class="fa fa-times"></i> Temizle</button>
                                                <?php /*<button type="button" id="exportExcel" class="btn btn-outline btn-info"> <i class="fa fa-file-excel-o"></i> Sonuçları Excele Aktar</button> */?>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div style="background: #ffffff;padding: 10px;margin-bottom: 5px;height: 35px;font-size: 12px">
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgPurple"></div>Durum</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgBlue"></div>Anasayfa Vitrini</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgYellow"></div>Kampanyalı Ürün</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgOrange"></div>Kategori Vitrini</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgBlack"></div>Marka Vitrini</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgGreen"></div>Yeni Ürün</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgRed"></div>Sponsor Ürün</div>
                        <div class="fleft p-l-10"><div class="boxCh2 m-r-10 bgPink"></div>Popüler Ürün</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div style="background: #ffffff;padding: 10px;margin-bottom: 5px;height: 35px;font-size: 12px">
                        <div class="pull-right p-l-10"><div class="boxCh2 m-r-10 bgRed"></div>Stok Butonları</div>
                        <div class="pull-right p-l-10"><div class="boxCh2 m-r-10 bgSky"></div>Kargo Butonları</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <div id="products_wrapper" class="dataTables_wrapper no-footer">

                                <table id="products" class="display table dataTable no-footer" style="width: 100%; font-size: 12px" role="grid" aria-describedby="products_info">
                                    <thead>
                                    <tr style="font-size:12px" role="row">
                                        <th width="2%" class="sorting_disabled dt-body-center" rowspan="1" colspan="1" style="width: 26px;">
                                            <div class="checkbox checkbox-inverse">
                                                <input id="select_all" value="1" type="checkbox">
                                                <label for="select_all"></label>
                                            </div>
                                        </th>
                                        <th width="1%" class="text-center" rowspan="1" colspan="1">ID</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 18px;">Resim</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Ürün Adı</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 61px;">Marka</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 18px;">KDV</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 41px;">Fiyat</th>
                                        <th width="35px" class="sorting_disabled text-center" rowspan="1" colspan="1">
                                            <div style="position: relative;">
                                                <div style="background:url('{{asset('src/images/kargo_butonlari.png')}}'); width: 26px;height: 117px;right: 10px;top: -9px;position: absolute;"></div>
                                            </div>
                                        </th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[0]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[1]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[2]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[3]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[4]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[5]->title}}" class="boxCh2 bgSky"></div></th>
                                        <th width="35px" class="sorting_disabled text-center" rowspan="1" colspan="1">
                                            <div style="position: relative;">
                                                <div style="background:url('{{asset('src/images/stok_butonlari.png')}}'); width: 26px;height: 117px;right: 10px;top: -9px;position: absolute;"></div>
                                            </div>
                                        </th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[6]->title}}" class="boxCh2 bgRed"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[7]->title}}" class="boxCh2 bgRed"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[8]->title}}" class="boxCh2 bgRed"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[9]->title}}" class="boxCh2 bgRed"></div></th>
                                        <th width="15px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" data-original-title="{{$data[10]->title}}" class="boxCh2 bgRed"></div></th>
                                        <th width="35px" class="sorting_disabled text-center" rowspan="1" colspan="1"><div data-toggle="tooltip" class="boxCh2 emptyCol"></div></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <a style="display: none;!important;" id="add_brand" data-toggle="modal" data-target="#brand-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
                        <div class="shortEditModal">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>

    <script>

        function showCategories(data,parent){
            if (data=='') {
               $('#sub-category-'+parent).html('');
               $('#cat_ids').val(""); 
               return;
            }

            var formData = new FormData();
                formData.append('id',data);
                formData.append('_token',$('meta[name=_token]').attr("content"));
            $.ajax({
                url: "{{url('admin/categories/getCategories')}}",
                type:'POST',
                contentType: false,
                data: formData,
                processData: false,
                dataType: "json",
                success: function(response){

                    if (response.status==200) {

                        if (response.data.length <= 0) {
                            $('#sub-category-'+parent).html('');
                            return;
                        }
                        $('#sub-category-'+parent).html('<div class="form-group"><label for="templateName" class="col-sm-2 control-label"></label><div class="col-sm-10"><select rel="local-category" onchange="showCategories(this.value,'+response.parent+')" name="" id="'+response.parent+'" title="Seçiniz" data-style="form-control" class="selectpicker show-tick bs-select-hidden"></select></div></div><div id="sub-category-'+response.parent+'"><div>');
                        $.each(response.data, function (i,e){
                            $('#'+response.parent).append('<option value="'+e.id+'">'+e.title+'</option>');
                        });

                        $('.selectpicker').selectpicker();
                    }

                },
                complete: function(){
                    $('#cat_ids_vals').html('');
                    $('[rel=local-category]').each(function(){

                        if ($(this).val()!="") {
                            $('#cat_ids_vals').append('<input type="hidden" rel="selected_cat_ids" name="cat_ids[]" value="'+$(this).val()+'">');
                        }
                        
                        //console.log($(this).val());
                    }); 
                }
            });

            

            //$('#cat_ids').val(data);
    

        }

        $(function() {

            $('[data-toggle="popover"]').popover();

            $("body").on("click",".shortEditBtn",function(e){
                e.preventDefault();
                var formData = new FormData();
                formData.append('id',$(this).attr("data-id"));
                formData.append('_token',$('meta[name=_token]').attr("content"));
                $.ajax({
                    url: "{{url('admin/products/shortEdit')}}",
                    type:'POST',
                    contentType: false,
                    data: formData,
                    processData: false,
                    dataType: "json",
                    success: function(response){
                        $(".shortEditModal").html(response.message);
                        $("#add_brand").trigger("click");


                        /*
                         if(response.status == true){
                         $.toast({
                         heading: 'Başarılı',
                         text: response.message,
                         position: 'top-right',
                         loaderBg:'#1EB300',
                         icon: 'success',
                         hideAfter: 3500
                         });
                         }else{
                         $.toast({
                         heading: 'Hata',
                         text: response.message,
                         position: 'top-right',
                         loaderBg:'#ff6849',
                         icon: 'error',
                         hideAfter: 3500
                         });
                         }
                         */
                    }
                });

            });

            // $(".product_image").unveil(300);


            var oTable = $('#products').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                orderable:true,
                bFilter: false,
                displayLength: 10,
                ajax: {
                    url: '{{url('admin/productButton/datatable')}}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.brand_id = $('#brand_id').val();
                        d.supplier_id = $('#supplier_id').val();
                        d.category_id = $('#category_id').val();
                        d.status = $('#status').val();
                        d.product_type = $('#product_type').val();
                        d.stock_code = $('#stock_code').val();
                        d.barcode = $('#barcode').val();
                        d.tax_id = $('#tax_id').val();
                        d.discount_type = $('#discount_type').val();
                        d.tax = $('#tax').val();
                        d.discount = $('#discount').val();
                        d.stock1 = $('#stock1').val();
                        d.stock2 = $('#stock2').val();
                        d.stock_type = $('#stock_type').val();
                        d.detail_filter = $('#detail_filter').val();
                        d.added_date1 = $('#added_date1').val();
                        d.added_date2 = $('#added_date2').val();
                        d.p_id = $('#id').val();
                        d.tag_id = $('#tag_id').val();
                        d.guarantee_term = $('#guarantee_term').val();
                        d.client_min = $('#client_min').val();
                        d.client_max = $('#client_max').val();
                        d.vat_inclusive = $('#vat_inclusive').val();
                        d.price1_1 = $('#price1_1').val();
                        d.price1_2 = $('#price1_2').val();
                        d.price2_1 = $('#price2_1').val();
                        d.price2_2 = $('#price2_2').val();
                        d.price3_1 = $('#price3_1').val();
                        d.price3_2 = $('#price3_2').val();
                        d.weight1 = $('#weight1').val();
                        d.weight2 = $('#weight2').val();
                        d.dealer_min = $('#dealer_min').val();
                        d.dealer_max = $('#dealer_max').val();
                        d.cargo_type = $('#cargo_type').val();
                        d.hasNotCat = $('#hasNotCat:checked').val();
                    }
                },
                order: [[1, 'desc']],
                'columnDefs': [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center',
                    render: function (data, type, full, meta){
                        return '<div class="checkbox checkbox-inverse"><input id="checkbox_'+data.id+'" type="checkbox" value="'+data.id+'" data-url="'+data.id+'" class="product_checkbox"><label for="checkbox_'+data.id+'"></label></div>';
                    }
                }],
                columns: [
                    {
                        className: '',
                        orderable: false,
                        searchable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {data: 'id', name: 'id', orderable: true, className:'text-center'},
                    {data: 'img', name: 'img',className:'text-center'},
                    {data: 'name', name: 'name'},
                    {data: 'brand.name', name: 'brand', className:'text-center', defaultContent: ""},
                    {data: 'tax', name: 'tax', className:'text-center'},
                    {data: 'price', name: 'price', className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '';
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if(row.buttons[0].c1==1){
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="cs'+row.id+'" name="c1" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[0]->title}}" for="cs'+row.id+'"></label>';
                            }else{
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cs'+row.id+'" name="c1" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[0]->title}}" for="cs'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cs'+row.id+'" name="c1" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[0]->title}}" for="cs'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].c2==1){
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="c'+row.id+'" name="c2" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[1]->title}}" for="c'+row.id+'"></label>';
                            }else{
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="c'+row.id+'" name="c2" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[1]->title}}" for="c'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="c'+row.id+'" name="c2" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[1]->title}}" for="c'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].c3==1){
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="ck'+row.id+'" name="c3" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[2]->title}}" for="ck'+row.id+'"></label>';
                            }else{
                                return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="ck'+row.id+'" name="c3" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[2]->title}}" for="ck'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="ck'+row.id+'" name="c3" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[2]->title}}" for="ck'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].c4==1){
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="ckat'+row.id+'" name="c4" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[3]->title}}" for="ckat'+row.id+'"></label>';
                            }else{
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="ckat'+row.id+'" name="c4" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[3]->title}}" for="ckat'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="ckat'+row.id+'" name="c4" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[3]->title}}" for="ckat'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].c5==1){
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="cm'+row.id+'" name="c5" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[4]->title}}" for="cm'+row.id+'"></label>';
                            }else{
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cm'+row.id+'" name="c5" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[4]->title}}" for="cm'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cm'+row.id+'" name="c5" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[4]->title}}" for="cm'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].c6==1){
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="1" id="cy'+row.id+'" name="c6" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[5]->title}}" for="cy'+row.id+'">';
                            }else{
                                return '<input  class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cy'+row.id+'" name="c6" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[5]->title}}" for="cy'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cy'+row.id+'" name="c6" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[5]->title}}" for="cy'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        return '';
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].s1==1){
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="csp'+row.id+'" name="s1" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[6]->title}}" for="csp'+row.id+'">';
                            }else{
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="csp'+row.id+'" name="s1" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[6]->title}}" for="csp'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="csp'+row.id+'" name="s1" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[6]->title}}" for="csp'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].s2==1){
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="cpop'+row.id+'" name="s2" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[7]->title}}" for="cpop'+row.id+'">';
                            }else{
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="cpop'+row.id+'" name="s2" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[7]->title}}" for="cpop'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cpop'+row.id+'" name="s2" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[7]->title}}" for="cpop'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].s3==1){
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="cpop2'+row.id+'" name="s3" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[8]->title}}" for="cpop2'+row.id+'">';
                            }else{
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="cpop2'+row.id+'" name="s3" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[8]->title}}" for="cpop2'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cpop2'+row.id+'" name="s3" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[8]->title}}" for="cpop2'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].s4==1){
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="cpop3'+row.id+'" name="s4" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[9]->title}}" for="cpop3'+row.id+'">';
                            }else{
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="cpop3'+row.id+'" name="s4" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[9]->title}}" for="cpop3'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cpop3'+row.id+'" name="s4" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[9]->title}}" for="cpop3'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if(row.buttons.length > 0){
                            if (row.buttons[0].s5==1){
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="cpop4'+row.id+'" name="s5" checked type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[10]->title}}" for="cpop4'+row.id+'">';
                            }else{
                                return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="cpop4'+row.id+'" name="s5" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[10]->title}}" for="cpop4'+row.id+'"></label>';
                            }
                        }else{
                            return '<input class="chckbxBlue checkChange" data-id="'+row.id+'" value="0" id="cpop4'+row.id+'" name="s5" type="checkbox"><label data-toggle="tooltip" data-original-title="{{$data[10]->title}}" for="cpop4'+row.id+'"></label>';
                        }
                    }, className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        return '';
                    }, className:'text-center noSortIcon'},
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, 100 ],
                    [ '10 Adet', '25 Adet', '50 Adet', '100 Adet' ]
                ],
                buttons: [
                    'pageLength',
                    {
                        text: 'Yenile',
                        action: function ( e, dt, node, config ) {
                            this.draw();
                        }
                    }
                ],
            });



            $.productTransport = function(){
                var formData = new FormData();
                formData.append('categories', $('#categoriesJoin').val());
                $.each($('.product_checkbox:checked'), function(index) {
                    formData.append('products[]', $(this).val());
                });
                $.ajax({
                    url: "/admin/products/bulk/transport",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    success: function(response){
                        if(response.status == true){
                            $.toast({
                                heading: 'Başarılı',
                                text: response.message,
                                position: 'top-right',
                                loaderBg:'#1EB300',
                                icon: 'success',
                                hideAfter: 3500
                            });
                        }else{
                            $.toast({
                                heading: 'Hata',
                                text: response.message,
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'error',
                                hideAfter: 3500
                            });
                        }
                    },
                    type:'POST',
                    processData: false,
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Taşınıyor..."
                        });
                    },
                    complete: function () {
                        $("#productTransport-modal").modal('hide');
                        oTable.draw();
                        $('#select_all').prop('checked', false);
                        HoldOn.close();
                    }
                });
            }


            $('#select_all').on('click', function(){
                var rows = oTable.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#products tbody').on('change', 'input[type="checkbox"]', function(){
                if(!this.checked){
                    var el = $('#select_all').get(0);
                    if(el && el.checked && ('indeterminate' in el)){
                        el.indeterminate = true;
                    }
                }
            });



            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });

            $('#detail_btn').on('click', function(e) {
                $("#detailFilters").toggle();
            });

            $('#clear_btn').on('click', function(e){
                $('#name').val("");
                $('#brand_id').val('').change();
                $('#supplier_id').val('').change();
                $('#category_id').val('').change();
                $('#status').selectpicker('val', '');
                $('#detail_filter').selectpicker('val', '');
                $('#product_type').selectpicker('val', '');
                $('#stock_code').val("");
                $('#barcode').val("");
                $('#tax').val("");
                $('#stock1').val("");
                $('#stock2').val("");
                $('#discount').val("");
                $('#added_date1').val("");
                $('#added_date2').val("");
                $('#stock_type').selectpicker('val', '');
                $('#discount_type').selectpicker('val', '');
                $('#vat_inclusive').selectpicker('val', '');
                $('#cargo_type').selectpicker('val', '');
                $('#id').val("");
                $('#price1_1').val("");
                $('#price1_2').val("");
                $('#price2_1').val("");
                $('#price2_2').val("");
                $('#price3_1').val("");
                $('#price3_2').val("");
                $('#weight1').val("");
                $('#weight2').val("");
                $('#dealer_min').val("");
                $('#dealer_max').val("");
                $('#guarantee_term').val("");
                $('#client_min').val("");
                $('#client_max').val("");
                $('#tag_id').val('').change();
                oTable.draw();
                e.preventDefault();
            });

            $("body").on("change",".checkChange",function () {

                var checkbox = $(this);
                if(checkbox.is(':checked')){
                    var status=1;
                }else{
                    var status=0;
                }

                var formData = new FormData();
                formData.append('id',checkbox.attr('data-id'));
                formData.append('status',status);
                formData.append('which',checkbox.attr('name'));
                formData.append('_token',$('meta[name=_token]').attr("content"));
                $.ajax({
                    url: "{{url('admin/productButton/update')}}",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    success: function(response){
                        if(response.status == true){
                            $.toast({
                                heading: 'Başarılı',
                                text: response.message,
                                position: 'top-right',
                                loaderBg:'#1EB300',
                                icon: 'success',
                                hideAfter: 3500
                            });
                        }else{
                            $.toast({
                                heading: 'Hata',
                                text: response.message,
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'error',
                                hideAfter: 3500
                            });
                        }
                    },
                    type:'POST',
                    processData: false,
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Güncelleniyor..."
                        });
                    },
                    complete: function () {
                        //oTable.draw();
                        HoldOn.close();
                    }
                });

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


        });

        $(document).ready(function () {
            $('body').tooltip({
                selector: '[data-toggle=tooltip]'
            });
        });

    </script>
    <?php /*
    <script>
        $(function() {
            $('#categories').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                ordering:false,
                ajax: "{{url('admin/products/datatable')}}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'stock', name: 'stock', orderable: false, searchable: false},
                    {data: 'brand.name', name: 'brand.name', orderable: false, searchable: false},
                    {data: 'price', name: 'price', orderable: false, searchable: false},
                    {data: 'stock', name: 'stock', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 4 },
                    { "width": "20", "targets": 5 }
                ]
            });
        });
    </script>
*/ ?>
@endsection

