@extends('admin.layout.master')

@section('styles')
@endsection

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
                        <h3 class="box-title m-b-15"> Pazaryeri Entegrasyonu</h3>
                       
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">N11</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="row">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="panel panel-default col-md-12 col-sm-6">
                                        <div class="panel-heading">Kategori Eşleştirme</div>
                                        <div class="panel-body">
                                            <span class="help-block">
                                                Ürünlerinizi N11 hesabınıza aktarabilmek için sitenizdeki kategoriler ile N11 sitesindeki kategorileri eşleştirmeniz gerekmektedir. Sadece eşleştirdiğiniz kategoriler içerisindeki ürünler N11 hesabınıza aktarılır.
                                            </span>
                                            <div class="text-center">
                                                <a class="btn btn-success" href="{{url('admin/n11/category/map')}}">Kategori Eşleştirme Sihirbazı</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default col-md-12 col-sm-6">
                                        <div class="panel-heading">N11 Şablonları</div>
                                        <div class="white-box">
                                                <div class="xcontent">
                                                    <div class="table-responsive">
                                                        <table id="n11Templates" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="sorting_disabled" rowspan="1" colspan="1">Şablon Adı</th>
                                                                <th class="sorting_disabled" rowspan="1" colspan="1"></th>
                                                                <th class="sorting_disabled" rowspan="1" colspan="1"></th>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="shortEditModal" class="modal fade" style="display: none;"></div>

                        <div style="display:none;" class="modal fade" id="addN11Temp">

                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">N11 Şablonu</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="POST" action="{{url('admin/n11/templates/create')}}" id="createN11temp" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                                   <div class="form-group">
                                                        <label for="templateName" class="col-sm-2 control-label">Şablon İsmi</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" id="templateName" class="form-control" name="templateName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="shipping" class="col-sm-2 control-label">Kargo Süresi</label>
                                                        <div class="col-sm-10">
                                                            <select name="shipping" id="shipping" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="delivery" class="col-sm-2 control-label">Teslimat Şablonu</label>
                                                        <div class="col-sm-10">
                                                            <select name="delivery" id="delivery" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option value="1">ozkoru</option>
                                                                <option value="2">ozkoru2</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="priceOpt" class="col-sm-2 control-label">Satış Fiyatı</label>
                                                        <div class="col-sm-5">
                                                            <select name="priceOpt" id="priceOpt" class="selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                                                                <option value="1">x</option>
                                                                <option value="2">+</option>
                                                                <option value="3">-</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input name="price" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="discount" class="col-sm-2 control-label">% İndirim Oranı</label>
                                                        <div class="col-sm-10">
                                                             <input name="discount" id="discount" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="start_date" class="col-sm-2 control-label">Başlangıç Tarihi</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="">
                                                        </div>
                                                        <label for="expire_date" class="col-sm-2 control-label">Bitiş Tarihi</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control datepicker" name="expire_date" id="expire_date" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subtitle" class="col-sm-2 control-label">Alt Başlık</label>
                                                        <div class="col-sm-10">
                                                             <input name="subtitle" id="subtitle" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onClick="$('#createN11temp').submit();" class="btn btn-default">Uygula</button>
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
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.tr.js')}}"></script>
    <script>

    $(function() {
        $('#n11Templates').DataTable({
            language: {
                "url": "{{ asset('vendor/datatables/turkish.json') }}"
            },
            processing: true,
            serverSide: true,
            ordering:false,
            ajax: "{{url('admin/n11/templates/datatable')}}",
            columns: [
                {data: 'name', name: 'name', orderable: false, searchable: true},
                { "mRender": function ( data, type, row ) {
                    return '<a href="" id="shortEdit" data-toggle="tooltip" data-id="'+row.id+'" title="Düzenle" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i></a>';                    
                },orderable: false, className:'text-center'},
                //{data: 'delete', name: 'delete', orderable: false, searchable: false, className:'text-center'}
                { "mRender": function ( data, type, row ) {
                    return '<a href="{{url('./')}}/admin/n11/templates/delete/'+row.id+'" data-toggle="tooltip" title="Sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i></a>';                    
                },orderable: false, className:'text-center'}
            ],
            "columnDefs": [
                { "width": "20", "targets": 1 },
                { "width": "20", "targets": 2 }
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, 100 ],
                [ '10 Adet', '25 Adet', '50 Adet', '100 Adet' ]
            ],
            buttons: [
            'pageLength',
            {
                text: 'Ekle',
                action: function ( e, dt, node, config ) {
                    $("#addN11Temp").modal('show');
                }
            }
            ]
        });
    });

    $( document ).ready(function() {

        $("body").on("click","#shortEdit",function(e){
            e.preventDefault();
            var formData = new FormData();
            formData.append('id',$(this).attr("data-id"));
            formData.append('_token',$('meta[name=_token]').attr("content"));
            $.ajax({
                url: "{{url('admin/n11/templates/edit')}}",
                type:'POST',
                contentType: false,
                data: formData,
                processData: false,
                dataType: "json",
                success: function(response){
                    $("#shortEditModal").html(response.message);
                    $("#shortEditModal").modal();
                    $('.selectpicker').selectpicker();
                    $('.datepicker').datepicker({
                        format: 'dd/mm/yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        language: 'tr',
                        toggleActive: true
                    });
                }
            });

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

