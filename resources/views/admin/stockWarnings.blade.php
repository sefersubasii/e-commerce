@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Ürün Haber Listesi</h4>
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Adı Soyadı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Email</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Ürün Stok Kodu</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Ürün Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sil</th></tr>
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
                ajax: "{{url('admin/stockWarnings/datatable')}}",
                columns: [
                    {data: 'customer.fullname', name: 'name', orderable: false, searchable: true},
                    {data: 'customer.email', name: 'mail', orderable: false, searchable: false},
                    {data: 'product.stock_code', name: 'status', orderable: false, searchable: false},
                    {data: 'product.name', name: 'status', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],"columnDefs": [
                    { "width": "20", "targets": 4 }
                ]
            });
        });
    </script>

@endsection
