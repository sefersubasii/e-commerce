@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">İade ve İptal Talepleri</h4>
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Üye Adı Soyadı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Ödeme Tipi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sipariş No</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Talep Durumu</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Şipariş Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Toplam Tutar</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">İade Tutar</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Düzenle</th>
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
                ajax: "{{url('admin/refundRequests/datatable')}}",
                columns: [
                    //{data: 'order.customer.name', name: 'name', orderable: false, searchable: true},
                    { "mRender": function (data, type, row) {
                        return row.order.customer.name + " " + row.order.customer.surname;
                    }},
                    {data: 'order.payment', name: 'payment', orderable: false, searchable: false},
                    {data: 'order.order_no', name: 'orderNo', orderable: false, searchable: false},
                    { "mRender": function (data, type, row) {
                        if(row.status==0)
                        {
                            return "Onay Bekliyor.";
                        }else if(row.status==1){
                            return "Onaylandı."
                        }else{
                            return "";
                        }
                    }},
                    {data: 'order.created_at', name: 'orderDate', orderable: false, searchable: false},
                    {data: 'order.grand_total', name: 'orderTotal', orderable: false, searchable: false},
                    {data: 'refundAmount', name: 'refundAmount', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 7 },
                    { "width": "20", "targets": 8 }
                ]
            });
        });
    </script>

@endsection
