@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Müşteriler</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/customers/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Müşteri Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <a href="#" data-perform="panel-collapse">
                            <div class="panel-heading">Müşteri Filtreleme <div class="pull-right"><i class="ti-minus"></i></div></div>
                        </a>
                        <div class="panel-wrapper collapse" aria-expanded="true">
                            <div class="panel-body">
                                <form method="POST" id="search-form" class="form-horizontal" role="form">
                                    <div class="col-md-3">
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-5 control-label">Adı</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="surname" class="col-sm-5 control-label">Soyadı</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="surname" id="surname">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date-range2" class="col-sm-5 control-label">Doğum Tarihi</label>
                                            <div class="col-sm-7">
                                                <div class="input-daterange input-group" id="date-range2">
                                                    <input type="text" class="form-control" name="b_date1" placeholder="gg-aa-yyyy" id="b_date1">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input type="text" class="form-control" name="b_date2" placeholder="gg-aa-yyyy" id="b_date2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <div class="form-group">
                                            <label for="groups" class="col-sm-5 control-label">Gruplar</label>
                                            <div class="col-sm-7">
                                                <select name="groups" id="groups" class="selectpicker show-tick bs-select-hidden"  data-title="Seçiniz" data-style="form-control" data-width="100%">
                                                    <option value="1">Üyeler</option>
                                                    <option value="2">İlk 582 Üye</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-5 control-label">Firma Adı</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="company_name" id="company_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-5 control-label">E-Posta</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="email" id="email">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        
                                        <div class="form-group">
                                            <label for="order_no" class="col-sm-5 control-label">Sipariş No</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="order_no" id="order_no">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="register_date1" class="col-sm-5 control-label">Kayıt Tarihi</label>
                                            <div class="col-sm-7">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text" class="form-control" name="register_date1" placeholder="gg-aa-yyyy" id="register_date1">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input type="text" class="form-control" name="register_date2" placeholder="gg-aa-yyyy" id="register_date2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="form-actions" style="border-top:1px solid #f1f2f7; padding-top:10px;">
                                        <div class="row">
                                            <div class="col-md-12 text-left">
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
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Müşteriler</h3>
                        <div class="table-responsive">
                            <div id="clients_wrapper" class="dataTables_wrapper no-footer">
                                <table id="clients" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="clients_info">
                                    <thead>
                                    <tr role="row">
                                        <th width="2%" class="sorting_disabled dt-body-center" rowspan="1" colspan="1" style="width: 26px;">
                                            <div class="checkbox checkbox-inverse">
                                                <input id="select_all" value="1" type="checkbox">
                                                <label for="select_all"></label>
                                            </div>
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 175px;">Adı</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 175px;">Soyadı</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 313px;">E-Posta</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 91px;">Grubu</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 101px;">Elektronik İleti İzni</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 101px;">Durum</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 213px;">Kayıt Tarihi</th>
                                        <th width="6%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 58px;">Düzenle</th>
                                        <th width="6%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 42px;">Sil</th>
                                    </tr>
                                    </thead>
                                </table>
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
    <script>
        $(function() {

            $('[data-toggle="popover"]').popover();


            // $(".product_image").unveil(300);


            var oTable = $('#clients').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                ordering: false,
                displayLength: 20,
                ajax: {
                    url: '{{url("admin/customers/datatable")}}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.surname = $('#surname').val();
                        d.city = $('#city').val();
                        d.status = $('#status').val();
                        d.groups = $('#groups').val();
                        d.country = $('#country').val();
                        d.company_name = $('#company_name').val();
                        d.email = $('#email').val();
                        d.total_login1 = $('#total_login1').val();
                        d.total_login2 = $('#total_login2').val();
                        d.phone = $('#phone').val();
                        d.order_no = $('#order_no').val();
                        d.register_date1 = $('#register_date1').val();
                        d.register_date2 = $('#register_date2').val();
                        d.bday1 = $('#b_date1').val();
                        d.bday2 = $('#b_date2').val();
                    }
                },
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta){
                        return '<div class="checkbox checkbox-inverse"><input id="checkbox_'+data.id+'" type="checkbox" value="'+data.id+'" class="client_checkbox"><label for="checkbox_'+data.id+'"></label></div>';
                    }
                }],
                columns: [
                    {
                        "className": '',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {data: 'name', name: 'name'},
                    {data: 'surname', name: 'surname'},
                    {data: 'email', name: 'email'},
                    // {data: 'group_id', name: 'group_id', orderable: false, searchable: false},
                    { "mRender": function ( data, type, row ) {
                        if(row.hasOwnProperty('group') && row.group){
                            return '<span class="label label-info">'+ row.group.name+'</span>';
                        }
                        return '<span class="label" style="background-color: #999">Grubu Yok!</span>';
                    }, className:'text-center'}, 
                    { "mRender": function ( data, type, row ) {
                        if(row.allowed_to_mail == '1'){
                            return '<span class="label label-success">İzin Verildi</span>';
                        }
                        return '<span class="label label-danger">İzin Verilmedi</span>';
                    }, orderable: true, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        if(row.status == '1'){
                            return '<span class="label label-success">Aktif</span>';
                        }

                        return '<span class="label label-danger">Pasif</span>';
                    }, className:'text-center'},
                    // {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/customers/edit/'+row.id+'" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/customers/delete/'+row.id+'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, 100 ],
                    [ '10 Adet', '25 Adet', '50 Adet', '100 Adet' ]
                ],
                buttons: [
                    'pageLength',
                    {
                        text: 'Durum Değiştir',
                        action: function ( e, dt, node, config ) {
                            var total = $('.client_checkbox:checked').length;
                            if(total){
                                $("#clientStatus-modal").modal('show');
                            }else {
                                swal("Hata", "Lütfen müşteri seçiniz.");
                            }
                        }
                    },
                    {
                        text: 'İşaretle',
                        action: function ( e, dt, node, config ) {
                            var total = $('.client_checkbox:checked').length;
                            if(total){
                                $("#clientMark-modal").modal('show');
                            }else {
                                swal("Hata", "Lütfen müşteri seçiniz.");
                            }
                        }
                    },
                    {
                        text: 'Dışarı Aktar',
                        action: function ( e, dt, node, config ) {
                            var total = $('.client_checkbox:checked').length;
                            if(total){
                                $("#clientOutput-modal").modal('show');
                            }else {
                                swal("Hata", "Lütfen müşteri seçiniz.");
                            }
                        }
                    },
                    {
                        text: 'Şifre Değiştir',
                        action: function ( e, dt, node, config ) {
                            var total = $('.client_checkbox:checked').length;
                            if(total){

                            }else {
                                swal("Hata", "Lütfen müşteri seçiniz.");
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
                        text: 'Sil',
                        action: function ( e, dt, node, config ) {
                            var total = $('.client_checkbox:checked').length;
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
                                    $.each($('.client_checkbox:checked'), function(index) {
                                        formData.append('clients[]', $(this).val());
                                    });
                                    $.ajax({
                                        url: "clients/ajax/delete",
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
                                swal("Hata", "Lütfen müşteri seçiniz.");
                            }
                        }
                    }
                ]
            });

            setTimeout(function(){

                oTable.draw();

            }, 500);


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

          $('#exportExcel').on('click',function(e){

                e.preventDefault();

                var d={};
                d.name = $('#name').val();
                d.surname = $('#surname').val();
                d.city = $('#city').val();
                d.status = $('#status').val();
                d.groups = $('#groups').val();
                d.country = $('#country').val();
                d.company_name = $('#company_name').val();
                d.email = $('#email').val();
                d.total_login1 = $('#total_login1').val();
                d.total_login2 = $('#total_login2').val();
                d.phone = $('#phone').val();
                d.order_no = $('#order_no').val();
                d.register_date1 = $('#register_date1').val();
                d.register_date2 = $('#register_date2').val();
                d.bday1 = $('#b_date1').val();
                d.bday2 = $('#b_date2').val();
                    

                var data = $.param( d );

                window.open("{{url('admin/customers/outputCustomersExcel?')}}"+data);

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

