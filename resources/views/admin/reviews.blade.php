@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Markalar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Yorum Başlığı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Puanı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Ürün Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Email</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Tarih</th>
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
                ajax: "{{url('admin/reviews/datatable')}}",
                columns: [
                    {data: 'author', name: 'author', orderable: false, searchable: true},
                    {data: 'rating', name: 'rating', orderable: false, searchable: false},
                    {data: 'product.name', name: 'product', orderable: false, searchable: false},
                    {data: 'email', name: 'email', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 5 },
                    { "width": "20", "targets": 6 }
                ]
            });
        });
    </script>

@endsection
