@extends('admin.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('src/admin/plugins/bower_components/morrisjs/morris.css')}}">
    <style>
        .infoOrders, .infoRevenues, .info{
            text-align: center;
            margin-top: 10px; 
        }
    </style>
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    
                    <div class="white-box" style="">
                        
                        <h3 class="box-title m-b-15"> Tarih</h3>
                        <form autocomplete="off" method="post" action="" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-group"> 
                                <div class="col-sm-2">
                                    <select name="dateOpt" id="dateOpt" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="0">Özel</option>
                                        <option value="1">Son 7 Gün</option>
                                        <option selected="" value="2">Son 30 Gün</option>
                                        <option value="3">Son 1 Yıl</option>
                                    </select>
                                </div>
                                
                                <label for="start_date" class="col-sm-1 control-label"><i class="fa fa-calendar"></i></label>
                                <div class="col-sm-3">
                                    <input type="text" disabled="" class="form-control datepicker" name="start_date" id="start_date" value="">
                                </div>
                                <label for="expire_date" class="col-sm-1 control-label"><i class="fa fa-calendar"></i></label>
                                <div class="col-sm-3">
                                    <input type="text" disabled="" class="form-control datepicker" name="expire_date" id="expire_date" value="">
                                </div>
                                <div class="col-sm-2"><a href="javascript:;" onclick="getChart();" class="btn btn-primary" type="button" name="Sorgula" id="reCall">Sorgula</a></div>
                            </div>
                        </form>
                        
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Zaman Aralığı için Detaylı İstatistikler  (Sipariş)</h4>
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
                                </ul>
                                <div class="dynamicChartArea" id="morris-area-chart2" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                    
                                </div>

                                <div class="infoOrders"></div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Zaman Aralığı için Detaylı İstatistikler  (Kazanç)</h4>
                                <div id="morris-bar-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </div>
                                <div class="infoRevenues"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Zaman Aralığı için Sepet Ortalama İstatistikleri</h4>
                                <div id="morris-bar-chart-average" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Yıllık Sipariş İstatistikleri</h4>
                                <div id="morris-bar-chart2" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Yıllık Gelir İstatistikleri</h4>
                                <div id="morris-bar-chart3" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ödeme İstatistikleri</h4>
                                <div id="morris-donut-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.tr.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/morrisjs/morris.js')}}"></script>
    <script>

    $( document ).ready(function() {


        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'tr',
            toggleActive: true
        });


        $('#dateOpt').on('change',function(){

            if ($(this).val()==0) {
                $('#start_date, #expire_date').prop('disabled',false);
            }else{
                $('#start_date, #expire_date').prop('disabled',true);
            }

        });

    });   

    var currency_symbol = "TL"
    var formattedOutput = new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY',
        minimumFractionDigits: 2,
    });

    getChart();

    function getChart()
    {
        $('.dynamicChartArea, #morris-bar-chart, #morris-bar-chart2, #morris-bar-chart3, #morris-donut-chart, #morris-bar-chart-average').html('');
        $.ajax({
            type: 'GET',
            url: "{{url('admin/orders/stats')}}",
            data: '_token='+$('meta[name=_token]').attr("content")+'&dateOpt='+$('#dateOpt').val()+'&start_date='+$('#start_date').val()+'&expire_date='+$('#expire_date').val(),
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
                        return content+"</div><div class='morris-hover-point' style='color: #fb9678'>Total: "+formattedOutput.format(row.total).replace(currency_symbol, '')+"</div>";
                        //console.log(content+"</div><div class='morris-hover-point' style='color: #fb9678'>Total:"+row.total+"</div>");
                    }
                });
                // Morris bar chart
                Morris.Bar({
                    element: 'morris-bar-chart',
                    data: response.chart,
                    xkey: 'dateformt',
                    ykeys: ['total'],
                    labels: ['Toplam'],
                    barColors:['#55ce63'],
                    hideHover: 'auto',
                    gridLineColor: '#eef0f2',
                    xLabelAngle:90,
                    resize: true
                });

                Morris.Bar({
                    element: 'morris-bar-chart-average',
                    data: response.average,
                    xkey: 'dateformt',
                    ykeys: ['value'],
                    labels: ['Ortalama'],
                    barColors:['#ffa500'],
                    hideHover: 'auto',
                    gridLineColor: '#eef0f2',
                    xLabelAngle:90,
                    resize: true/*,
                    hoverCallback: function (index, options, content, row) {
                        console.log(content);
                        return content.replace('<div class="morris-hover-point" style="color: #ffa500">Ortalama: '+row.value+' </div>','<div class="morris-hover-point" style="color: #ffa500">Ortalama:'+formattedOutput.format(row.value).replace(currency_symbol, '')+'</div>');
                    }*/
                });
                //$('svg').css('height','400px');
                
                Morris.Bar({
                    element: 'morris-bar-chart2',
                    data: response.chart2,
                    xkey: 'monthText',
                    ykeys: ['onay','tum'],
                    labels: ['Onaylanan Siparişler','Toplam Sipariş'],
                    barColors:['#55ce63', '#2f3d4a'],
                    hideHover: 'auto',
                    gridLineColor: '#eef0f2',
                    xLabelAngle:45,
                    resize: true
                });

                Morris.Bar({
                    element: 'morris-bar-chart3',
                    data: response.chart2,
                    xkey: 'monthText',
                    ykeys: ['total'],
                    labels: ['Gelir'],
                    barColors:['#e46a76'],
                    hideHover: 'auto',
                    gridLineColor: '#eef0f2',
                    xLabelAngle:45,
                    resize: true
                });

                Morris.Donut({
                    element: 'morris-donut-chart',
                    data: response.donut,
                    resize: true,
                    colors:['#009efb', '#55ce63', '#e46a76','#2f3d4a']
                });

            }
            $('#morris-bar-chart2').append("<div class='info'><strong>Yıllık Toplam Sipariş Miktarı : </strong>"+response.yearlyOrderSumTum+" Adet </br> <strong>Yıllık Gerçekleşen Sipariş Miktarı : </strong>"+response.yearlyOrderSumOnay+" Adet</div>");
            $('#morris-bar-chart3').append("<div class='info'></br><strong>Yıllk Gelir Toplamı : </strong>"+response.yearlyRevenueSum+" TL </div>");
            $('.infoOrders').html("<strong>Toplam : </strong>"+response.total+" Adet<br><strong>Onay : </strong>"+response.success+" Adet<br><strong>İptal : </strong>"+response.fail+" Adet");
            $('.infoRevenues').html("<strong>Kazanç : </strong>"+response.revenue+" TL");
        }); 

    }

    $('#reCall').on('change',function(){

        getChart();

    });



    

    </script>
@endsection

