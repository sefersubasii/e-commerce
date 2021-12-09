@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Kuponlar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/campaigns/coupons/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Kupon Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="coupons" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Kodu</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Değer</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Maksimum Kullanım</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Başlangıç Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Bitiş Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Oluşturma Tarihi</th>
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
            $('#coupons').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                ordering:false,
                ajax: "{{url('admin/campaigns/coupons/datatable')}}",
                columns: [
                    {data: 'code', name: 'code', orderable: false, searchable: true},
                    {data: 'value', name: 'value', orderable: false, searchable: false},
                    {data: 'maxUse', name: 'maxUse', orderable: false, searchable: false},
                    {data: 'startDate', name: 'startDate', orderable: false, searchable: false},
                    {data: 'stopDate', name: 'stopDate', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 6 },
                    { "width": "20", "targets": 7 }
                ]
            });
        });
    </script>

@endsection
