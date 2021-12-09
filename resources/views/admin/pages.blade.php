@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Sayfalar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/pages/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Sayfa Ekle</a>
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">Başlık</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">Sayfa Adresi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 10%;">Sayfaya Git</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 20%;">Sayfa Tipi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 5%;">Sıra No</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 5%;">Düzenle</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 5%;">Sil</th></tr>
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
                ajax: "{{url('admin/pages/datatable')}}",
                columns: [
                    {data: 'title', name: 'title', orderable: false, searchable: true},
                    {data: 'slug', name: 'slug', orderable: false, searchable: false},
                    {
                        "mRender": function ( data, type, row ) {
                            return '<a href="' + row.slug + '" target="_blank">Sayfaya Git</a>';
                        },
                        orderable: false, searchable: false, class: 'text-center'
                    }, 
                    {
                        "mRender": function ( data, type, row ) {
                            return (row.isStatic == 1 ? 'Sabit Sayfa' : 'Dinamik Sayfa');
                        },
                        orderable: false, searchable: false, class: 'text-center'
                    },
                    {data: 'sort', name: 'sort', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 3 },
                    { "width": "20", "targets": 4 }
                ]
            });
        });
    </script>

@endsection

