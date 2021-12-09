@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Kategoriler</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/blog-categories/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Kategori Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="categories" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 161px;">Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 122px;">Sıra No</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 526px;">URL</th>
                                    <th width="6%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 60px;">Alt Kategorileri</th>
                                    <th width="6%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 60px;">Düzenle</th>
                                    <th width="6%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 42px;">Sil</th></tr>
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
                ajax: "{{url('admin/blog-categories/datatable?parent='.$parent)}}",
                columns: [
                    {data: 'title', name: 'title', orderable: false, searchable: true},
                    {data: 'sort', name: 'sort', orderable: false, searchable: false},
                    {data: 'slug', name: 'slug', orderable: false, searchable: false},
                    {data: 'sub', name: 'sub', orderable: false, searchable: false},
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

@endsection
