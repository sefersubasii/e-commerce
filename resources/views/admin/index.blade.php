@extends('admin.layout.master')

@section('styles')

    <link rel="stylesheet" href="{{asset('src/admin/plugins/bower_components/morrisjs/morris.css')}}">
@endsection

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Günlük İstatistikler</h4>
                    
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <?php /*
                    <a href="{{url('downloadRemoteXml')}}" target="_blank" onclick="return confirm('Stok ve Fiyat Güncellemesi yapmak istediğinize emin misiniz?')" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Fiyat ve Stok aktarımı
                    </a>
                    */ ?>
                    <a href="{{url('admin/cache/clear')}}" onclick="return confirm('Önbelleği (Cache) temizlemek istediğinize emin misiniz?')" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Önbellek Temizle
                    </a>
                    
                    <ol class="breadcrumb">
                        
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="row row-in">
                            <div class="col-lg-3 col-sm-6 row-in-br">
                                <a href="{{url('admin/orders')}}">
                                <div class="col-in row">
                                    @if(Session::has('newOrder') && Session::get('newOrder') > 0 )
                                        <span class="orderNotification">{{Session::get('newOrder')}}</span>
                                    @endif
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i  class="icon-basket" ></i>
                                        <h5 class="text-muted vb">Toplam Sipariş</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-dark">{{$daily['todayOrder']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-dark" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                <a href="{{url('admin/orders?status=1')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="b" class="linea-icon linea-ecommerce"></i>
                                        <h5 class="text-muted vb">Kargoya Hazır</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-megna">{{$daily['ready']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-megna" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">20% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6 row-in-br">
                                <a href="{{url('admin/orders?status=1')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i class="ti-truck"></i>
                                        <h5 class="text-muted vb">Kargolanan</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-primary">{{$daily['cargo']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6  b-0">
                                <a href="{{url('admin/orders?status=4')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i class="icon-check"></i>
                                        <h5 class="text-muted vb">Teslim edilen</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-success">{{$daily['delivered']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="row row-in">
                            <div class="col-lg-3 col-sm-6 row-in-br">
                                <a href="{{url('admin/customers')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i  class="icon-user" ></i>
                                        <h5 class="text-muted vb">Yeni Üye</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-info">{{$daily['todayMember']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                <a href="{{url('admin/orders?status=0')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-spinner"></i>
                                        <h5 class="text-muted vb">Onay Bekleyen</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-warning">{{$daily["waitConfirm"]}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">20% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6 row-in-br">
                                <a href="{{url('admin/refundRequests')}}">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i class="ti-reload"></i>
                                        <h5 class="text-muted vb">İptal İade</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-danger">{{$daily['refund']}}</h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6  b-0">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i class="icon-wallet"></i>
                                        <h5 class="text-muted vb">Toplam Satış</h5>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="text-right m-t-15 text-success" style="font-size:28px;">{{$myPrice->currencyFormat($daily['orderSum'])}} <span><i style="font-size:20px;" class="fa fa-try"></i></span></h3>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <div class="xcontent">
                            <div class="table-responsive">
                                <table id="brands" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" rowspan="1" colspan="1">Stoğu tükenen ürünler</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1">Stok</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Oturum İstatistikleri</h3>
                        <ul class="list-inline text-right">
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>Ziyaretçi</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #fdc006;"></i>Sayfa Görüntüleme</h5>
                            </li>
                        </ul>
                        <div id="morris-area-chart">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sipariş İstatistikleri</h4>
                                <ul class="list-inline text-right">
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-inverse" style="color: #009efb;"></i>Toplam</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-info" style="color: #55ce63;"></i>Onay</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-info" style="color: #fb9678;"></i>İptal</h5>
                                    </li>
                                    <?php /*
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-success"></i>3</h5>
                                    </li>
                                    */ ?>
                                </ul>
                                <div id="morris-area-chart2" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bugün</h4>
                                <div class="text-right"> <span class="text-muted">Toplam Gelir</span>
                                    <h1 class="font-light"><sup><i class="ti-arrow-up text-success"></i></sup> {{$myPrice->currencyFormat($daily['orderSum'])}} <i class="fa fa-try"></i></h1>
                                </div>
                                <?php /*
                                <span class="text-success">20%</span>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                */ ?>
                            </div>
                            <hr>
                            <div class="card-body">
                                <h4 class="card-title">Bu Hafta</h4>
                                <div class="text-right"> <span class="text-muted">Toplam Gelir</span>
                                    <h1 class="font-light"><sup><i class="ti-arrow-up text-success"></i></sup> {{$myPrice->currencyFormat($daily['weekSum'])}} <i class="fa fa-try"></i></h1>
                                </div>
                                <?php /*
                                <span class="text-success">20%</span>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                */ ?>
                            </div>
                            <hr>
                            <div class="card-body">
                                <h4 class="card-title">Bu Ay</h4>
                                <div class="text-right"> <span class="text-muted">Toplam Gelir</span>
                                    <h1 class="font-light"><sup><i class="ti-arrow-up text-success"></i></sup> {{$myPrice->currencyFormat($daily['monthSum'])}} <i class="fa fa-try"></i></h1>
                                </div>
                                <?php /*
                                <span class="text-success">20%</span>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">
            2017 &copy; Marketpaketi Yönetim Paneli
        </footer>
    </div>
    <!-- /#page-wrapper -->


@endsection


@section('scripts')
    
    <script src="{{asset('src/admin/plugins/bower_components/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/morrisjs/morris.js')}}"></script>
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
                ajax: "{{url('admin/products/criticalStock/datatable')}}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'stock', name: 'stock', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 1 }
                ]
            });
        });

        $.ajax({
            type: 'GET',
            url: "{{url('admin/analytics')}}",
            data: '_token='+$('meta[name=_token]').attr("content")
        }).done(function (response) {

            if (response!="" && response!=undefined && response!=null) {
                Morris.Area({
                element: 'morris-area-chart',
                    data: response,
                    xkey: 'date',
                    ykeys: ['visitors', 'pageViews'],
                    labels: ['Ziyaretçi', 'Sayfa Görüntüleme'],
                    pointSize: 2,
                    fillOpacity: 0,
                    pointStrokeColors:['#00bfc7', '#fdc006'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 3,
                    hideHover: 'auto',
                    lineColors: ['#00bfc7', '#fdc006'],
                    resize: false,
                    parseTime:false,
                    xLabelAngle:90,
                    ymin:'auto',
                    xmin:'auto'
                });

                //$('svg').css('height','400px');
            }
        });

        var currency_symbol = "TL"
         
        var formattedOutput = new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency: 'TRY',
            minimumFractionDigits: 2,
        });
     
    
        $.ajax({
            type: 'GET',
            url: "{{url('admin/orders/stats')}}",
            data: '_token='+$('meta[name=_token]').attr("content")
        }).done(function (response) {

            if (response!="" && response!=undefined && response!=null) {
                Morris.Area({
                element: 'morris-area-chart2',
                    data: response.chart,
                    parseTime: false,
                    //xkeys: ['date','total'],
                    xkey: 'dateformt',
                    ykeys: ['count','onay','iptal'],
                    labels: ['Toplam','Onay','İptal'],
                    pointSize: 3,
                    fillOpacity: 0,
                    pointStrokeColors:['#009efb', '#55ce63','#fb9678'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 3,
                    hideHover: 'auto',
                    lineColors: ['#009efb', '#55ce63','#fb9678'],
                    resize: true,
                    hoverCallback: function (index, options, content, row) {
                        //console.log(index);
                        //console.log(options);
                        return content+"</div><div class='morris-hover-point' style='color: #fb9678'>Total: "+formattedOutput.format(row.total).replace(currency_symbol, '')+"</div>";
                        //console.log(row);
                        //console.log(content+"</div><div class='morris-hover-point' style='color: #fb9678'>Total:"+row.total+"</div>");
                      //return "ss"+row.x+row.y;
                    }
                });

                //$('svg').css('height','400px');
            }
        });
/*

        Morris.Area({
        element: 'morris-area-chart2',
        data: [{
            period: '2010',
            iphone: 50,
            ipad: 80,
            itouch: 20
        }, {
            period: '2011',
            iphone: 130,
            ipad: 100,
            itouch: 80
        }, {
            period: '2012',
            iphone: 80,
            ipad: 60,
            itouch: 70
        }, {
            period: '2013',
            iphone: 70,
            ipad: 200,
            itouch: 140
        }, {
            period: '2014',
            iphone: 180,
            ipad: 150,
            itouch: 140
        }, {
            period: '2015',
            iphone: 105,
            ipad: 100,
            itouch: 80
        },
         {
            period: '2016',
            iphone: 250,
            ipad: 150,
            itouch: 200
        }],
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: 3,
        fillOpacity: 0,
        pointStrokeColors:['#55ce63', '#009efb', '#2f3d4a'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 3,
        hideHover: 'auto',
        lineColors: ['#55ce63', '#009efb', '#2f3d4a'],
        resize: true
        
    });
        */
    </script>
@endsection