@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tüm Promosyonlar</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/campaigns/promotion/add')}}" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Promosyon Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="coupons" class="display table dataTable no-footer" style="width: 100%; font-size: 12px" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Promosyon Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Başlangıç Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Bitiş Tarihi</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Tarih Durumu</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Max Kullanım Sayısı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Toplam Kullanım</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Promosyon Tipi</th>
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
                ajax: "{{url('admin/campaigns/promotion/datatable')}}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'startDate', name: 'startDate', orderable: false, searchable: false},
                    {data: 'stopDate', name: 'stopDate', orderable: false, searchable: false},
                    { "mRender": function ( data, type, row ) {
                        if (row.selectedDate==0){
                            return 'Pasif';
                        }else if(row.selectedDate==1){
                            return 'Aktif';
                        }
                    }, className:'text-center noSortIcon'},
                    {data: 'maxUsage', name: 'maxUsage', orderable: false, searchable: false},
                    {data: 'totalUsage', name: 'totalUsage', orderable: false, searchable: false},
                    { "mRender": function ( data, type, row ) {
                        if (row.type==0){
                            return 'Sepet Bazlı Promosyon';
                        }else if(row.type==1){
                            return 'Ürün Bazlı Promosyon';
                        }else if(row.type==2){
                            return 'Kategori veya Marka Bazlı Promosyon';
                        }
                    }, className:'text-center noSortIcon'},
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
