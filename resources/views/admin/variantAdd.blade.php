@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Varyant Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/variants')}}" class="btn btn-block btn-default btn-rounded">← Varyantlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Varyant Ekle</h3>

                        <form method="post" action="{{url('admin/variants/create')}}" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Varyant Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                </div>


                               <?php /*
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">Varyant Türü</label>
                                    <div class="col-sm-2">
                                        <select name="type" id="type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                            <option value="1" selected="selected">Açılır Liste</option>
                                            <option value="2">Seçmeli Liste</option>
                                        </select><div class="btn-group bootstrap-select show-tick" style="width: 100%;"><button type="button" class="btn dropdown-toggle form-control" data-toggle="dropdown" data-id="type" title="Açılır Liste"><span class="filter-option pull-left">Açılır Liste</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li data-original-index="0" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Açılır Liste</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Seçmeli Liste</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>
                                    </div>
                                </div>
                                */ ?>



                                <div class="form-group">
                                    <label for="add_filter" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="add_filter" value="1" id="add_filter" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                         Eklenen verileri filtre olarakta eklemek istiyorsanız işaretleyiniz.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Varyant Değerleri</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info" id="degerEkle">Değer Ekle</button>
                                        </div>
                                        <div id="degerler">

                                        </div>
                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>

        $( document ).ready(function() {

            $("#degerEkle").on('click', function(){
                $.ajax({
                    url: "{{url('admin/variants/ajax/add-area')}}",
                    success: function(response){
                        $("#degerler").append(response);
                    },
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Ekleniyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });
            });
            $.deleteDivFromId = function(div){
                $("#"+div).remove();
            }

        });

    </script>
@endsection