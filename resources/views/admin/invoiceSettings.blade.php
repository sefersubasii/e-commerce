@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Fatura Çıktısı</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/orders')}}" class="btn btn-block btn-default btn-rounded">← Geri</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15"> {{Request::segment(4)}} ID'li Sipariş için Faturayı Oluşturabilirsiniz.</h3>
                        <form id="outputInvoice" method="post" action="{{url('admin/create')}}" class="form-horizontal form-bordered">



                            <div class="form-group">
                                <label for="billingDate" class="col-sm-2 control-label">Fatura Tarihi:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Örn: 01.01.2018 12:00:00" name="billingDate" id="billingDate"><br>
                                    <div class="alert-default" role="alert"> <span class="glyphicon glyphicon-exclamation-sign"></span> Fatura Tarihini Elle Girme Seçeneği : Örn: 12.01.2012 12:00:00 gibi.Girilmez ise fatura tarihi sipariş tarihi olacaktır.</div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="irsaliyeDate" class="col-sm-2 control-label">İrsaliye Tarihi:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Örn: 01.01.2018 12:00:00" name="irsaliyeDate" id="irsaliyeDate"><br>
                                    <div class="alert-default" role="alert"> <span class="glyphicon glyphicon-exclamation-sign"></span> İrsaliye Tarihini Elle Girme Seçeneği : Örn: 12.01.2012 12:00:00 gibi.Girilmez ise sipariş tarihi irsaliye tarihi olacaktır.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label">İrsaliye Numarası:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="number" id="number" value=""><br>
                                    <div class="alert-default" role="alert"> <span class="glyphicon glyphicon-exclamation-sign"></span>  İrsaliyeli fatura kesmiyorsanız, İrsaliye numarasını elle belirleyebilirsiniz.</div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Gönder</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                        <iframe name="invoiceFrame" style="visibility:hidden;width:0px;height:0px;" src="" id="invoiceFrame"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>

        $( document ).ready(function() {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'tr',
                toggleActive: true
            });

            $("#outputInvoice").on("submit",function (e) {
                e.preventDefault();
                var extra = $("#outputInvoice").serialize();
                var addUrl="";
                addUrl="?id="+"{{Request::segment(4)}}";
                var src="{{url('admin/orders/invoiceCreator')}}"+addUrl+"&"+extra;
                console.log(src);

                $('#invoiceFrame').attr('src',src);

                //window.open(src,'_blank','width=777,height=1036,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');

                /* var win=window.open('about:blank','_blank','width=777,height=1036,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');
                with(win.document)
                {
                    open();
                    write("sss");
                    close();
                }
                */
            });



        });

    </script>
@endsection

