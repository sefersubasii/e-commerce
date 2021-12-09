@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">

@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Ürünler</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/products/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Ürün Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
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
                                                @if(count(@$data)>0)
                                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                                @endif
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
                                                <select name="stock_type" id="stock_type"  class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-style="form-control" data-width="100%">
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
                                                <button type="button" id="exportExcel" class="btn btn-outline btn-info"> <i class="fa fa-file-excel-o"></i> Sonuçları Excele Aktar</button>
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
                                        <th width="2%" class="text-center" rowspan="1" colspan="1" style="width: 18px;">ID</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 18px;">Resim</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 267px;">Ürün Adı</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" >Barkod</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 87px;">Kategori</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 61px;">Marka</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 38px;">KDV</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 51px;">Fiyat</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 40px;">Stok</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 61px;">Karlılık</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 61px;">İndirimli Fiyat</th>
                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 61px;">Maliyet</th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgPurple"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgBlue"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgYellow"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgOrange"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgBlack"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgGreen"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgRed"></div></th>
                                        <th width="15px" class="text-center" rowspan="1" colspan="1"><div class="boxCh bgPink"></div></th>
                                        <th width="1%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="1%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="1%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="1%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <a style="display: none;!important;" id="add_brand" data-toggle="modal" data-target="#brand-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
                        <div class="shortEditModal">

                        </div>

                        <div style="display:none;" class="modal fade" id="productTransport-modal">

                            <div class="modal-dialog">
                                
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Toplu Ürün Taşıma</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form enctype="multipart/form-data" class="bulk-transport">
                                                   <div class="form-group">
                                                        <label for="parent_id" class="col-sm-2 control-label">Kategori</label>
                                                        <div class="col-sm-10">
                                                            <select onchange="showCategories(this.value,0)" name="" id="" rel="local-category" title="Seçiniz" data-style="form-control" class="selectpicker show-tick bs-select-hidden">
                                                                @foreach($allSubCategories as $k => $v)
                                                                    <option value="{{$v->id}}">{{$v->title}}</option>
                                                                @endforeach
                                                            </select>
                                                            <?php /* 
                                                            <select multiple name="cat_ids[]" id="categoriesJoin" class="selectpicker bs-select-hidden multiple" data-style="form-control" data-live-search="1" title="Seçiniz" data-width="100%">
                                                                @foreach ($allSubCategories as $category)
                                                                    <?php $count=0; ?>
                                                                    {{--@foreach ($category->children as $children)--}}
                                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                                    @if(count($category->childs))
                                                                        @include('admin.manageChild',['childs' => $category->childs,'count'=>1])
                                                                    @endif

                                                                @endforeach
                                                            </select>
                                                            */ ?>
                                                        </div>
                                                    </div> 
                                                    <div id="sub-category-0"></div>
                                                    <div id="cat_ids_vals">
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onClick="$.productTransport();" class="btn btn-default">Uygula</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                                    </div>
                              </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/tr.js"></script>
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

        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();

            $("body").on("click",".shortEditBtn",function(e){
                var trElem = $(this).parent().parent();
                var index = $('tr').index(trElem);
                
                e.preventDefault();
                var formData = new FormData();
                formData.append('id',$(this).attr("data-id"));
                formData.append('_token',$('meta[name=_token]').attr("content"));
                formData.append('index',index);
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

            $(document).on("submit","#add_brand",function(e){
                e.preventDefault();
                $.ajax({
                    url: this.action,
                    type:'POST',
                    data: $(this).serialize(),
                    success: function(response){
                       response=JSON.parse(response);
                       if (response.status==200) {
                           $('tr').eq(response.index).find('td').eq(3).html(response.data.name);
                           $('tr').eq(response.index).find('td').eq(7).html(response.data.price);
                           $('tr').eq(response.index).find('td').eq(8).html(response.data.stock);
                           $("#add_brand").trigger("click");  
                       }else{
                        alert(response.message);
                       }
                        
                    }
                });

                e.preventDefault();
            });

            
            $('#exportExcel').on('click',function(e){
              
                e.preventDefault();

                var d={};
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
                d.discount1 = $('#discount1').val();
                d.discount2 = $('#discount2').val();
                d.price1 = $('#price1').val();
                d.price2 = $('#price2').val();
                d.price3_1 = $('#price3_1').val();
                d.price3_2 = $('#price3_2').val();
                d.weight1 = $('#weight1').val();
                d.weight2 = $('#weight2').val();
                d.dealer_min = $('#dealer_min').val();
                d.dealer_max = $('#dealer_max').val();
                d.cargo_type = $('#cargo_type').val();

                var data = $.param( d );
                window.open("{{url('admin/products/outputProductEcxell?')}}"+data);
            });

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
                displayLength: 20,
                ajax: {
                    url: "{{ url('admin/products/datatable') }}",
                    type: "POST",
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
                        d.discount1 = $('#discount1').val();
                        d.discount2 = $('#discount2').val();
                        d.price1 = $('#price1').val();
                        d.price2 = $('#price2').val();
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
                //deferRender: true,
                //deferLoading: 20,
                order: [[
                    1, 'desc'
                ]],
                'columnDefs': [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        className: 'dt-body-center',
                        render: function (data, type, full, meta){
                            return '<div class="checkbox checkbox-inverse"><input id="checkbox_'+data.id+'" type="checkbox" value="'+data.id+'" data-url="'+data.id+'" class="product_checkbox"><label for="checkbox_'+data.id+'"></label></div>';
                        }
                    },
                    { 
                        "width": "20",
                        "targets": 4 
                    },
                    {
                        targets: [0, 2, 4, 5, 6],
                        orderable: false
                    }
                ],
                columns: [
                    {
                        "className": '',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'id', orderable: true, className:'text-center'},
                    {data: 'img', name: 'img',className:'text-center'},
                    {data: 'name', name: 'name'},
                    {data: 'barcode', name: 'barcode'},
                    { "mRender": function ( data, type, row ) {
                        try {
                            var title="";
                            for (var i = 0; i <= row.categori.length-1; i++) {
                                title += row.categori[i].title + (i != row.categori.length-1 ? " > " : " ");
                            }
                            return title;
                        }catch(err) {
                            return "";
                        }
                    }, className:'text-center'},
                    {data: 'brand_name.name', name: 'brand', className:'text-center', defaultContent: ""},
                    {data: 'tax', name: 'tax', className:'text-center'},
                    {data: 'price', name: 'price', className:'text-center'},
                    {data: 'stock', name: 'stock', className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        if (row.discount_type >=1){
                            if(row.costprice > 0 && row.costprice !=null){
                                var sum = (row.final_price - row.costprice)/row.final_price*100;
                                return sum.toFixed(3)+'%';
                            }else{
                                return ' ';
                            }
                        }else{
                            if(row.costprice > 0 && row.costprice !=null){
                                var sum =(row.price - row.costprice)/row.price*100;
                                return sum.toFixed(3)+'%';
                            }else{
                                
                                return ' ';
                            }
                        }
                    }, className:'text-center', orderable: false},
                    { "mRender": function ( data, type, row ) {
                        if (row.discount_type >=1){
                            return row.final_price;
                        }else{
                           return ' ';
                        }
                    }, name: 'final_price', className:'text-center', orderable: false},
                    {data: 'costprice',name: 'costprice', className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        if (row.status==1){
                            return '<input class="chckbx checkChange" data-id="'+row.id+'" value="1" id="cs'+row.id+'" name="status" checked type="checkbox"><label for="cs'+row.id+'"></label>';
                        }else{
                            return '<input class="chckbx checkChange" data-id="'+row.id+'" value="0" id="cs'+row.id+'" name="status" type="checkbox"><label for="cs'+row.id+'"></label>';
                        }
                    }, name: 'status', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.showcase!=null){
                            return '<input class="chckbx2 checkChange" data-id="'+row.id+'" value="1" id="c'+row.id+'" name="home" checked type="checkbox"><label for="c'+row.id+'"></label>';
                        }else{
                            return '<input class="chckbx2 checkChange" data-id="'+row.id+'" value="0" id="c'+row.id+'" name="home" type="checkbox"><label for="c'+row.id+'"></label>';
                        }
                    }, name:'hsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.campaign_sort!=null){
                            return '<input class="chckbx3 checkChange" data-id="'+row.id+'" value="1" id="ck'+row.id+'" name="campaign" checked type="checkbox"><label for="ck'+row.id+'"></label>';
                        }else{
                            return '<input class="chckbx3 checkChange" data-id="'+row.id+'" value="0" id="ck'+row.id+'" name="campaign" type="checkbox"><label for="ck'+row.id+'"></label>';
                        }
                    }, name: 'campsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.category_sort!=""){
                            return '<input  class="chckbx4 checkChange" data-id="'+row.id+'" value="1" id="ckat'+row.id+'" name="category" checked type="checkbox"><label for="ckat'+row.id+'"></label>';
                        }else{
                            return '<input  class="chckbx4 checkChange" data-id="'+row.id+'" value="0" id="ckat'+row.id+'" name="category" type="checkbox"><label for="ckat'+row.id+'"></label>';
                        }
                    }, name: 'catsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.brand_sort!=null){
                            return '<input  class="chckbx5 checkChange" data-id="'+row.id+'" value="1" id="cm'+row.id+'" name="brand" checked type="checkbox"><label for="cm'+row.id+'"></label>';
                        }else{
                            return '<input  class="chckbx5 checkChange" data-id="'+row.id+'" value="0" id="cm'+row.id+'" name="brand" type="checkbox"><label for="cm'+row.id+'"></label>';
                        }
                    }, name: 'brsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.new_sort!=null){
                            return '<input  class="chckbx6 checkChange" data-id="'+row.id+'" value="1" id="cy'+row.id+'" name="new" checked type="checkbox"><label for="cy'+row.id+'">';
                        }else{
                            return '<input  class="chckbx6 checkChange" data-id="'+row.id+'" value="0" id="cy'+row.id+'" name="new" type="checkbox"><label for="cy'+row.id+'"></label>';
                        }
                    }, name: 'newsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.sponsor_sort!=null){
                            return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="1" id="csp'+row.id+'" name="sponsor" checked type="checkbox"><label for="csp'+row.id+'">';
                        }else{
                            return '<input  class="chckbx7 checkChange" data-id="'+row.id+'" value="0" id="csp'+row.id+'" name="sponsor" type="checkbox"><label for="csp'+row.id+'"></label>';
                        }
                    }, name: 'spsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        if (row.popular_sort!=null){
                            return '<input  class="chckbx8 checkChange" data-id="'+row.id+'" value="1" id="cpop'+row.id+'" name="popular" checked type="checkbox"><label for="cpop'+row.id+'">';
                        }else{
                            return '<input  class="chckbx8 checkChange" data-id="'+row.id+'" value="0" id="cpop'+row.id+'" name="popular" type="checkbox"><label for="cpop'+row.id+'"></label>';
                        }
                    }, name: 'popsort', className:'text-center noSortIcon'},
                    { "mRender": function ( data, type, row ) {
                        return '<a target="_blank" href="{{url('./')}}/admin/products/copy/'+row.id+'" data-toggle="tooltip" title="Kopyala" onclick="return confirm(\'Kopyalamak İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="fa fa-files-o"></i></a>';                    
                    },orderable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="" data-id="'+row.id+'" data-toggle="tooltip" title="Hızlı Düzenle" class="btn btn-xs btn-success btn-rounded shortEditBtn"><i class="fa fa-pencil"></i></a>';                    
                    },orderable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a target="_blank" href="{{url('./')}}/admin/products/edit/'+row.id+'" data-toggle="tooltip" title="Düzenle" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i></a>';                    
                    },orderable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/products/delete/'+row.id+'" data-toggle="tooltip" title="Sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i></a>';                    
                    },orderable: false, className:'text-center'}
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, 100 ],
                    [ '10 Adet', '25 Adet', '50 Adet', '100 Adet' ]
                ],
                buttons: [
                    'pageLength',
                    {
                        text: 'Kopyala',
                        action: function ( e, dt, node, config ) {
                            var total = $('.product_checkbox:checked').length;
                            if(total){
                                swal({
                                    title: "Kopyalamak istediğinize emin misiniz?",
                                    text: "Seçtiğiniz ürünlerin kopyalayarak çoğaltabilirsiniz.",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Onayla",
                                    closeOnConfirm: true,
                                    cancelButtonText: "İptal"
                                }, function(){
                                    var formData = new FormData();
                                    $.each($('.product_checkbox:checked'), function(index) {
                                        formData.append('products[]', $(this).val());
                                    });
                                    $.ajax({
                                        url: "admin/products/bulk/copy",
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
                                                message: "Kopyalanıyor..."
                                            });
                                        },
                                        complete: function () {
                                            oTable.draw();
                                            HoldOn.close();
                                        }
                                    });
                                });
                            }else {
                                swal("Hata", "Ürün kopyalamak için en az 1 ürün seçmeniz gerekiyor.");
                            }
                        }
                    },
                    {
                        text: 'Sil',
                        action: function ( e, dt, node, config ) {
                            var total = $('.product_checkbox:checked').length;
                            if(total){
                                swal({
                                    title: "Silmek istediğinize emin misiniz?",
                                    text: "Bu işlemi onayladıktan sonra geri alma şansınız yoktur.",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Onayla",
                                    closeOnConfirm: true,
                                    cancelButtonText: "İptal"
                                }, function(){
                                    var formData = new FormData();
                                    $.each($('.product_checkbox:checked'), function(index) {
                                        formData.append('products[]', $(this).val());
                                    });
                                    $.ajax({
                                        url: "admin/products/bulk/delete",
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
                                                message: "Siliniyor..."
                                            });
                                        },
                                        complete: function () {
                                            oTable.draw();
                                            HoldOn.close();
                                        }
                                    });
                                });
                            }else {
                                swal("Hata", "Ürün silmek için en az 1 ürün seçmeniz gerekiyor.");
                            }
                        }
                    },
                    {
                        text: 'Taşı',
                        action: function ( e, dt, node, config ) {
                            var total = $('.product_checkbox:checked').length;
                            if(total){
                                $("#productTransport-modal").modal('show');
                            }else{
                                swal("Hata", "Ürün taşımak için en az 1 ürün seçmeniz gerekiyor.");
                            }
                        }
                    },
                    {
                        text: 'Yenile',
                        action: function ( e, dt, node, config ) {
                            this.draw();
                        }
                    },
                    {
                        text: 'Stoğu Tükenen Ürünler',
                        action:function(e, dt, node, config){
                            $('#stock1').val('0');
                            $('#stock2').val('0');
                            this.draw();
                        }
                    }
                ],
            });

            $.productTransport = function(){
                var formData = new FormData();
                formData.append('_token',$('meta[name=_token]').attr("content"));
                //formData.append('categories', $('#categoriesJoin').val());
                //formData.append('categories', $("[rel=selected_cat_ids]").val());
                $.each($('[rel=selected_cat_ids]'), function(index) {
                    formData.append('categories[]', $(this).val());
                });
                //formData.append('cats[]',$('#categoriesJoin').val());
                $.each($('.product_checkbox:checked'), function(index) {
                    formData.append('products[]', $(this).val());
                });
                $.ajax({
                    url: "{{url('admin/products/bulk/transport')}}",
                    type:'POST',
                    contentType: false,
                    data: formData,
                    processData: false,
                    dataType: "json",
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
                $('input[type="checkbox"]', rows).not('.checkChange').prop('checked', this.checked);
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
                e.preventDefault();
                oTable.draw();
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
                $('#price1').val("");
                $('#price2').val("");
                $('#discount_1').val("");
                $('#discount_2').val("");
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
                    url: "{{url('admin/products/sortStatus/update')}}",
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
                        oTable.draw();
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


            $('body').tooltip({
                selector: '[data-toggle=tooltip]'
            });
        });
    </script>
@endsection

