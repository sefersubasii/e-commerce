@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">İşlem Kayıtları</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="brands" class="display table dataTable no-footer" style="width: 100%" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1">ID</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Kullanıcı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Email</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">İşlem</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30px">Url</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Tarih</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">İp</th></tr>
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
                ajax: "{{url('admin/processLog/datatable')}}",
                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: true, sWidth: '5%'},
                    {data: 'user.name', name: 'user.name', orderable: false, searchable: false, sWidth: '10%'},
                    {data: 'user.email', name: 'user.email', orderable: false, searchable: false, sWidth: '15%'},
                    {data: 'subject', name: 'subject', orderable: false, searchable: false, sWidth: '10%'},
                    {data: 'url', name: 'url', orderable: false, searchable: false, sWidth: '40%'},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false, sWidth: '10%'},
                    {data: 'ip', name: 'ip', orderable: false, searchable: false, sWidth: '10%'}
                ]
                
            });
        });
    </script>

@endsection

