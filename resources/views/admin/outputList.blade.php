@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Kayıtlı Çıktılar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/output/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Çıktı Ekle</a>
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">Bilgi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Durum</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Kopyala</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Düzenle</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sil</th>
                                </tr>
                                </thead>
                            </table>
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
                ajax: "{{url('admin/output/datatable')}}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/output/copy/'+row.id+'" data-toggle="tooltip" data-oid="'+row.id+'" data-original-title="Kopyala" onclick="return confirm(\'Kopyalamak İstediğinize Emin Misiniz?\')" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-copy"></i></a>';
                    }, className:'text-center noSortIcon'},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}

                ],
                "columnDefs": [
                    { "width": "20", "targets": 3 },
                    { "width": "20", "targets": 4 },
                    { "width": "20", "targets": 5 }
                ]
            });
        });
    </script>

@endsection

