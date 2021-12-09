@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
    <link href="{{asset('src/admin/plugins/bower_components/multiselect/css/multi-select.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Hatalı Ödeme Siparişleri</h4>
                </div>


                <!-- /.col-lg-12 -->
            </div>
                        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <a href="#" data-perform="panel-collapse">
                            <div class="panel-heading">Sipariş Filtreleme <div class="pull-right"><i class="ti-minus"></i></div></div>
                        </a>
                        <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form method="POST" id="search-form" class="form-horizontal" role="form">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id" class="col-sm-5 control-label">ID</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="id" id="id">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="payment_type" class="col-sm-5 control-label">Ödeme Türü</label>
                                            <div class="col-sm-7">
                                                <select name="payment_type" id="payment_type" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    <option value="1">Havale / Eft</option>
                                                    <option value="2">Kapıda Ödeme (Nakit)</option>
                                                    <option value="3">Kredi Kartı</option>
                                                    <option value="4">Kapıda Ödeme (Kredi Kartı)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shipping" class="col-sm-5 control-label">Kargo Firması</label>
                                            <div class="col-sm-7">
                                                <select name="shipping" id="shipping" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    @foreach($shippingCompanies as $company)
                                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price1" class="col-sm-5 control-label">Toplam Tutar</label>
                                            <div class="col-sm-7">
                                                <div class="input-daterange input-group">
                                                    <input type="text" class="form-control" name="price1" id="price1" value="">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input type="text" class="form-control" name="price2" id="price2" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date1" class="col-sm-5 control-label">Sipariş Tarihi</label>
                                            <div class="col-sm-7">
                                                <div class="input-daterange input-group">
                                                    <input placeholder="yıl-ay-gün" type="text" class="form-control" name="date1" id="date1" value="">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input placeholder="yıl-ay-gün" type="text" class="form-control" name="date2" id="date2" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="orderNo" class="col-sm-5 control-label">Ref No / Sipariş No</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="orderNo" id="orderNo" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="billingName" class="col-sm-5 control-label">Faturadaki İsim</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="billingName" id="billingName" value="">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-4">
                                
                                        
                                        
                                        <div class="form-group">
                                            <label for="city" class="col-sm-5 control-label">Faturadaki Şehir</label>
                                            <div class="col-sm-7">
                                                <select name="city" id="city" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->name}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="phone" class="col-sm-5 control-label">Telefon Numarası</label>
                                            <div class="col-sm-7">
                                                <input placeholder="+90 (999) 999 99 99" type="text" class="form-control" name="phone" id="phone" value="">
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
                
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <div id="products_wrapper" class="dataTables_wrapper no-footer">

                                <table id="products" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="products_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled dt-body-center" rowspan="1" colspan="1" style="width:26px!important;">
                                            <div class="checkbox checkbox-inverse">
                                                <input id="select_all" value="1" type="checkbox">
                                                <label for="select_all"></label>
                                            </div>
                                        </th>
                                        <th width="2%"  class="sorting_disabled text-center" rowspan="1" colspan="1">ID</th>
                                        <th width="15%" class="sorting_disabled" rowspan="1" colspan="1">Müşteri</th>
                                        <th width="10%"  class="sorting_disabled" rowspan="1" colspan="1">Durum</th>
                                        <th width="50%"  class="sorting_disabled" rowspan="1" colspan="1">Hata Mesajı</th>
                                        <th width="8%"  class="sorting_disabled text-center" rowspan="1" colspan="1">Ödeme Tipi</th>
                                        <th width="15%" class="sorting_disabled text-center" rowspan="1" colspan="1">Sipariş Tarihi</th>
                                        <th width="8%" class="sorting_disabled text-center" rowspan="1" colspan="1">Tutar</th>
                                        <th width="8%" class="sorting_disabled text-center" rowspan="1" colspan="1">Sipariş İli</th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                        <th width="2%" class="sorting_disabled text-center" rowspan="1" colspan="1"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <a style="display: none;!important;" id="openUpdateShippingModal" data-toggle="modal" data-target="#shippingUpdate-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
                        <div class="updateShippingModal">

                        </div>
                        <div id="brand-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="editform" onsubmit="return false" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Sipariş Detayı</h4>
                                        </div>
                                        <div id="ModalIcerik" class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Başlık</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="order" class="col-sm-2 control-label">Sıra</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="order" id="order" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="statusChange-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="status_change" onsubmit="return false;" class="form-horizontal">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Sipariş Durum Değişikliği</h4>
                            </div>
                            <div class="modal-body">
                                <label for="status_select" class="col-sm-3 control-label">Durum</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status_select" class="selectpicker show-tick" data-title="Seçiniz" data-style="form-control" data-width="100%">
                                        <option value="0">Onay Bekliyor</option>
                                        <option value="1">Onaylandı</option>
                                        <option value="3">İptal Edildi</option>
                                        <option value="4">Teslim Edildi</option>
                                        <option value="5">Tedarik Sürecinde</option>
                                        <option value="6">Ödeme Bekleniyor</option>
                                        <option value="7">Hazırlanıyor</option>
                                        <option value="8">İade Edildi</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="$.updateOrderStatus()">Gönder</button>
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a style="display: none;!important;" id="show_noteModal" data-toggle="modal" data-target="#note-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
            <div class="showNoteModal"></div>
            <div id="orderOutput-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="orderOutputLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" id="order_output_form" action="" class="form-horizontal form-bordered">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="clientOutputLabel">Dışarı Aktar</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin-bottom:10px!important;">
                                    <label for="output_type" class="col-sm-2 control-label">Çıktı Türü</label>
                                    <div class="col-sm-4">
                                        <select name="output_type" id="output_type" class="selectpicker show-tick" data-style="form-control" data-width="100%">
                                            <option value="xls" selected="selected">Excel5 (xls)</option>
                                            <option value="xlsx">Excel2007 (xlsx)</option>
                                            <option value="csv">CSV</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="help-block" style="margin-top:0;">Aşağıdaki kutunun sağına aldığınız kolonlar çıktıya dahil edilecektir.</span>
                                <select id="output_fields" name="output_fields[]" multiple='multiple'>
                                    <option value="name" selected>Ad</option>
                                    <option value="surname" selected>Soyad</option>
                                    <option value="email" selected>E-Posta</option>
                                    <option value="company_name" selected>Firma Adı</option>
                                    <option value="sex" selected>Cinsiyet</option>
                                    <option value="group_id" selected>Üye Grubu</option>
                                    <option value="status" selected>Durum</option>
                                    <option value="tax_office" selected>Vergi Dairesi</option>
                                    <option value="tax_no" selected>Vergi No</option>
                                    <option value="identity_number" selected>TC Kimlik No</option>
                                    <option value="phone" selected>Cep Telefonu</option>
                                    <option value="phone_work" selected>İş Telefonu</option>
                                    <option value="phone_home" selected>Ev Telefonu</option>
                                    <option value="address" selected>Adres</option>
                                    <option value="country_id" selected>Ülke</option>
                                    <option value="city_id" selected>Şehir</option>
                                    <option value="district_id" selected>İlçe</option>
                                    <option value="zip_code" selected>Posta Kodu</option>
                                    <option value="discount_type">İndirim Tipi</option>
                                    <option value="discount">İndirim</option>
                                    <option value="cargo_free">Kargo Ücretsiz</option>
                                    <option value="ko_status">Kapıda Ödeme Onaylı</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light" onclick="$.orderOutput('order_output_form')">Dışarı Aktar</button>
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </div>
            </div>

            <div id="orderBillNo-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" id="createShipmentForm" class="form-horizontal form-bordered">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="clientOutputLabel">Fatura Numarası</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                     <label for="billingNo" class="col-sm-2 control-label">Fatura No</label>
                                     <div class="col-sm-10">
                                        <input type="text" class="form-control" name="orderBillingNo" id="orderBillingNo" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Ekle</button>
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" id="billNoOrderId" name="order_id" value="">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <iframe id="orderFrame" name="orderFrame"  src="" style="visibility:hidden;width:0px;height:0px;"></iframe>

@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/multiselect/js/jquery.multi-select.js')}}"></script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $("body").on("click",".showNote",function(e){
                e.preventDefault();
                var formData = new FormData();
                formData.append('id',$(this).attr("data-id"));
                formData.append('_token',$('meta[name=_token]').attr("content"));
                $.ajax({
                    url: "{{url('admin/orders/showNote')}}",
                    type:'POST',
                    contentType: false,
                    data: formData,
                    processData: false,
                    dataType: "json",
                    success: function(response){
                        $(".showNoteModal").html(response.message);
                        $("#show_noteModal").trigger("click");
                    }
                });

            });

            $('#createShipmentForm').on('submit',function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/orders/createShipment')}}",
                    type:'POST',
                    data: $('#createShipmentForm').serialize(),
                    dataType: "json",
                    success: function(response){
                        console.log(response);
                        HoldOn.close();
                        $('#orderBillNo-modal').modal('toggle');
                    },beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Güncelleniyor..."
                        });
                    }
                });
            });

        });



        function myFunction(val,id) {
            //console.log(val+"-"+id);
            $.ajax({
                url: 'orders/bulk/status',
                method: 'post',
                dataType: "json",
                data:{orders:id,status:val},
                success : function(response) {
                    HoldOn.close();
                    var oTable = $('#products').DataTable();
                    oTable.draw();
                },beforeSend: function () {
                    HoldOn.open({
                        theme:"sk-bounce",
                        message: "Güncelleniyor..."
                    });
                },complete: function (response) {
                    var resp = response.responseJSON;
                    //HoldOn.close();
                    console.log(response.responseJSON);
                    if (resp.stataus==200 && resp.billingNo=="required") {
                        $('#billNoOrderId').val(resp.orderId);    
                        $('#orderBillNo-modal').modal('show');
                    }
                }
            });
        }

        function printShipping(id){
            var printUrl = '/admin/orders/print-shipping/'+id;
            if(navigator.userAgent.indexOf('rv:')!=-1 || navigator.userAgent.indexOf('MSIE')!=-1){
                if(!window.open(printUrl)){
                    alert('Tarayıcınız açılır pencerelere izin vermemektedir.Lütfen tarayıcınızın açılır pencerelere izin verecek şekilde ayarlayınız.')
                }
            }else{
                $('#orderFrame').attr('src', printUrl);
            }
                    
            
        }

        function updateShippingNum(id){
            var formData = new FormData();
            formData.append('id',id);
            formData.append('_token',$('meta[name=_token]').attr("content"));
            $.ajax({
                url: "{{url('admin/orders/updateShippingNum')}}",
                type:'POST',
                contentType: false,
                data: formData,
                processData: false,
                dataType: "json",
                success: function(response){
                    $(".updateShippingModal").html(response.message);
                    $("#openUpdateShippingModal").trigger("click");
                }
            });

        }



        $(function() {

            $('body').tooltip({
                selector: '[data-toggle=tooltip]'
            });

            var $modal = $("#brand-modal");

            $('body').on('click','.detailBtn', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    url: 'orders/test/'+ id,
                    method: 'GET'
                }).done(function(response) {
                    $('#ModalIcerik').html(response);
                    $modal.modal('show');
                });
            });


            $('[data-toggle="popover"]').popover();


            $('#output_fields').multiSelect();

            function IsJsonString(str) {
                try {
                    var json = JSON.parse(str);
                    return (typeof json === 'object');
                } catch (e) {
                    return false;
                }
            }


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
                    url: '{{url('admin/orders/datatable')}}',
                    data: function (d) {
                        d.id = $('#id').val();
                        d.payment_type = $('#payment_type').val();
                        d.status = 9;
                        d.shipping = $('#shipping').val();
                        d.price1 = $('#price1').val();
                        d.price2 = $('#price2').val();
                        d.date1 = $('#date1').val();
                        d.date2 = $('#date2').val();
                        d.orderNo = $('#orderNo').val();
                        d.billingName = $('#billingName').val();
                        d.city = $('#city').val();
                        d.phone = $('#phone').val();
                    }
                },
                //order: [[1, 'desc']],
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'width':"5%",
                    'className': 'dt-body-center noSortIcon',
                    'render': function (data, type, full, meta){
                        return '<div class="checkbox checkbox-inverse"><input id="checkbox_'+data.id+'" type="checkbox" value="'+data.id+'" class="order_checkbox"><label for="checkbox_'+data.id+'"></label></div>';
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
                    {data: 'id', name: 'id', className:'text-center'},
                    {
                        data: 'customer.fullname',
                        name: 'customer.fullname',
                        defaultContent: 'Bilinmiyor..'
                    },
                    { "mRender": function ( data, type, row ) {  
                        return 'Hatalı Ödeme';
                    }, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        if(typeof(row.statusMessage) === 'string'){
                            if (IsJsonString(row.statusMessage)) {
                                let statusMessageJson = JSON.parse(row.statusMessage);
                                
                                return (statusMessageJson.error_message + " / " + statusMessageJson.md_error_message);
                            }else{
                                return row.statusMessage;
                            }
                        }
                    }, name: 'statusMessage', className:'text-center', defaultContent: 'Hata mesajı bulunamadı!'},
                    // {data: 'statusMessage', name: 'statusMessage', className:'text-center'},
                    {data: 'payment', name: 'payment', className:'text-center', defaultContent: ""},
                    {data: 'created_at', name: 'created_at', className:'text-center'},
                    {data: 'grand_total', name: 'grand_total', className:'text-center'},
                    {data: 'shipping_address.city', name: 'shipping_address', orderable: false, searchable: false, className:'text-center', defaultContent: 'Bilinmiyor...'},
                    { "mRender": function ( data, type, row ) {
                        return '<a target="_blank" href="{{url('./')}}/admin/orders/print/'+row.id+'" data-toggle="tooltip" title="Sipariş Detaylarını Yazdır" class="btn btn-xs btn-primary btn-rounded"><i class="glyphicon glyphicon-print"></i></a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a target="_blank" href="{{url('./')}}/admin/orders/invoiceSettings/'+row.id+'" data-toggle="tooltip" title="'+row.billOutput+' fatura çıktısı alındı" class="btn btn-xs btn-primary btn-rounded"><i class="fa fa-file-text-o"></i></a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/orders/detail/'+row.id+'" data-id="'+row.id+'" data-toggle="tooltip" title="Sipariş Detayı" class="btn btn-xs btn-success btn-rounded detailBtn"><i class="fa fa-search"></i></a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a onclick="return printShipping('+row.id+');" data-toggle="tooltip" title="Kargo Bilgisi" class="btn btn-xs btn-primary btn-rounded"><i class="fa fa-truck"></i></a>';                    
                    }, orderable: false, searchable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="" data-id="'+row.id+'" data-toggle="tooltip" title="Not" class="btn btn-xs btn-primary btn-rounded showNote"><i class="fa fa-list"></i></a>';                    
                    },orderable: false, className:'text-center'},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/orders/delete/'+row.id+'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" data-toggle="tooltip" title="Sil" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i></a>';                    
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
                        text: 'Sipariş Durumunu Değiştir',
                        action: function ( e, dt, node, config ) {
                            var total = $('.order_checkbox:checked').length;
                            if(total){
                                $("#statusChange-modal").modal('show');
                            }else{
                                swal("Uyarı!", "En az bir tane sipariş seçmeniz gerekmektedir.","error");
                            }
                        }
                    },/*
                    {
                        text: 'Kargo Hazır',
                        action: function ( e, dt, node, config ) {
                            var total = $('.order_checkbox:checked').length;
                            if(total){
                                swal({
                                    title: "Gönderi oluşturmak istediğinize emin misiniz?",
                                    text: "Bu işlemi yaptıktan sonra dilerseniz gönderiler altından silebilirsiniz.",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Onayla",
                                    closeOnConfirm: true,
                                    cancelButtonText: "İptal"
                                }, function(){
                                    var formData = new FormData();
                                    $.each($('.order_checkbox:checked'), function(index) {
                                        formData.append('orders[]', $(this).val());
                                    });
                                    $.ajax({
                                        url: "{{url('admin/orders/bulk/shipping')}}",
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
                                                message: "Oluşturuluyor..."
                                            });
                                        },
                                        complete: function () {
                                            oTable.draw();
                                            $('#select_all').prop('checked', false);
                                            HoldOn.close();
                                        }
                                    });
                                });
                            }else {
                                swal("Hata", "En az bir tane sipariş seçmeniz gerekmektedir.");
                            }
                        }
                    },
                    {
                        text: 'Dışarı Aktar',
                        action: function ( e, dt, node, config ) {
                            var total = $('.order_checkbox:checked').length;
                            if(total){
                                $("#orderOutput-modal").modal('show');
                            }else{
                                swal("Hata", "En az bir tane sipariş seçmeniz gerekmektedir.");
                            }
                        }
                    },*/
                    {
                        text: 'Yenile',

                        action: function ( e, dt, node, config ) {
                            this.draw();
                        }
                    },
                    {
                        text: 'Sil',

                        action: function ( e, dt, node, config ) {
                            var total = $('.order_checkbox:checked').length;
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
                                    $.each($('.order_checkbox:checked'), function(index) {
                                        formData.append('orders[]', $(this).val());
                                    });
                                    $.ajax({
                                        url: "orders/bulk/delete",
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
                                            $('#select_all').prop('checked', false);
                                            HoldOn.close();
                                        }
                                    });
                                });
                            }else {
                                swal("Hata", "En az bir tane sipariş seçmeniz gerekmektedir.");
                            }
                        }
                    }
                ]
            });

            setTimeout(function(){
                oTable.draw();
            }, 1000);

            $.orderOutput = function(id){
                $(".order_checkbox:checked").each(function (index, value) {
                    $('<input type="hidden" name="orders[]" />').attr("value", $(this).val()).appendTo('#'+id);
                });
            };

            $.updateOrderStatus = function(){
                var formData = new FormData();
                formData.append('status', $('#status_select').val());

                $.each($('.order_checkbox:checked'), function() {
                    formData.append('orders[]', $(this).val());
                });

                $.ajax({
                    url: "{{url('admin/orders/bulk/updateOrderStatus')}}",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    success: function(response){
                        if(response.success == true){
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
                        $('#status_select').selectpicker('val', '');
                        $("#statusChange-modal").modal('hide');
                        oTable.draw();
                        $('#select_all').prop('checked', false);
                        HoldOn.close();
                    }
                });
            }



            $.statusChange = function(){
                var formData = new FormData();
                formData.append('status', $('#status_select').val());

                $.each($('.order_checkbox:checked'), function() {
                    formData.append('orders[]', $(this).val());
                });

                $.ajax({
                    url: "{{url('admin/orders/bulk/status')}}",
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
                        $('#status_select').selectpicker('val', '');
                        $("#statusChange-modal").modal('hide');
                        oTable.draw();
                        $('#select_all').prop('checked', false);
                        HoldOn.close();
                    }
                });
            };

            $('#exportExcel').on('click',function(e){

                e.preventDefault();

                var d={};
                d.id = $('#id').val();
                d.payment_type = $('#payment_type').val();
                d.status = $('#status').val();
                d.shipping = $('#shipping').val();
                d.price1 = $('#price1').val();
                d.price2 = $('#price2').val();
                d.date1 = $('#date1').val();
                d.date2 = $('#date2').val();
                d.orderNo = $('#orderNo').val();
                d.billingName = $('#billingName').val();
                d.city = $('#city').val();
                d.phone = $('#phone').val();

                var data = $.param( d );

                window.open("{{url('admin/orders/outputOrdersExcell?')}}"+data);

            });

            $(document).on("click",".reSend",function(e){
                e.preventDefault();
                var formData = new FormData();
                formData.append('id', $(this).attr("data-oid"));
                $.ajax({
                    url: "{{url('admin/orders/resendMail')}}",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    success: function(response){
                        if(response.status == 200){
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
                            message: "Mail Gönderiliyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });

            });


            $('#select_all').on('click', function(){
                var rows = oTable.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#orders tbody').on('change', 'input[type="checkbox"]', function(){
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

            $('#orderStatusUpdate').on('click', function(){

            });

            $('#clear_btn').on('click', function(e){
                $('#id').val("");
                $('#status').selectpicker('val', '');
                $('#payment_type').selectpicker('val', '');
                $('#payment_type').selectpicker('val', '');
                $('#shipping').selectpicker('val', '');
                $('#date1').val("");
                $('#date2').val("");
                $('#price1').val("");
                $('#price2').val("");
                $('#orderNo').val("");
                $('#billingName').val("");
                $('#city').val("");
                $('#phone').val("");
                oTable.draw();
                e.preventDefault();
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

