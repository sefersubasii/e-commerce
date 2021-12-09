@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Gruplar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a data-toggle="modal" data-target="#add_mailGroup" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Grup Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="brands" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Kişi Sayısı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Düzenle</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sil</th></tr>
                                </thead>
                            </table>
                        </div>

                        <div id="add_mailGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div style="max-width:600px" class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_brand" method="post" action="{{url('admin/mail/mailGroupCreate')}}" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Yeni Grup Ekle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Adı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Ekle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    </form>
                                </div>
                            </div>
                        </div>


                        <a style="display: none;!important;" id="edit_mailGroupOpen" data-toggle="modal" data-target="#edit_mailGroup"><i class="fa fa-plus-circle fa-2x"></i></a>
                        <div class="shortEditModal">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $("body").on("click",".shortEditBtn",function(e){
                e.preventDefault();
                var formData = new FormData();
                formData.append('id',$(this).attr("data-id"));
                formData.append('_token',$('meta[name=_token]').attr("content"));
                $.ajax({
                    url: "{{url('admin/mail/mailGroupShortEdit')}}",
                    type:'POST',
                    contentType: false,
                    data: formData,
                    processData: false,
                    dataType: "json",
                    success: function(response){
                        $(".shortEditModal").html(response.message);
                        $("#edit_mailGroupOpen").trigger("click");
                    }
                });

            });
            $('#brands').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                ordering:false,
                ajax: "{{url('admin/mail/groupList/datatable')}}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 2 },
                    { "width": "20", "targets": 3 }
                ]
            });
        });
    </script>

@endsection
