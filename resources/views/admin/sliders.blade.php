@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Sliderlar</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <?php /*
                    <a href="{{url('admin/slider/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Slider Ekle</a>
                    */ ?>
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1">ID</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Başlık</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Oluşturma Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Resimler</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Düzenle</th>
                                    <?php /*<th class="sorting_disabled" rowspan="1" colspan="1">Sil</th></tr>*/ ?>
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
                ajax: "{{url('admin/settings/sliders/datatable')}}",
                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: true},
                    {data: 'description', name: 'description', orderable: false, searchable: true},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'itemsLink', name: 'itemsLink', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false}
                    //{data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    //{ "width": "20", "targets": 2 },
                    { "width": "50", "targets": 3 },
                    { "width": "50", "targets": 4 }
                ]
            });
        });
    </script>
@endsection

