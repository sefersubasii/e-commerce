@extends('admin.layout.master')
@section('styles')
    <style>
    .btn-file {
        overflow: hidden;
        position: relative;
        vertical-align: middle;
    }
    .btn-file > input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        font-size: 23px;
        height: 100%;
        width: 100%;
        direction: ltr;
        cursor: pointer;
        border-radius: 0px;
    }
    .fileinput {
    margin-bottom: 9px;
    display: inline-block;
    }
    .fileinput .form-control {
    padding-top: 7px;
    padding-bottom: 5px;
    display: inline-block;
    margin-bottom: 0px;
    vertical-align: middle;
    cursor: text;
    }
    .fileinput .thumbnail {
    overflow: hidden;
    display: inline-block;
    margin-bottom: 5px;
    vertical-align: middle;
    text-align: center;
    }
    .fileinput .thumbnail > img {
    max-height: 100%;
    }
    .fileinput .btn {
    vertical-align: middle;
    }
    .fileinput-exists .fileinput-new,
    .fileinput-new .fileinput-exists {
    display: none;
    }
    .fileinput-inline .fileinput-controls {
    display: inline;
    }
    .fileinput-filename {
    vertical-align: middle;
    display: inline-block;
    overflow: hidden;
    }
    .form-control .fileinput-filename {
    vertical-align: bottom;
    }
    .fileinput.input-group {
    display: table;
    }
    .fileinput.input-group > * {
    position: relative;
    z-index: 2;
    }
    .fileinput.input-group > .btn-file {
    z-index: 1;
    }
    </style>
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{$slider->description}}</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/settings/sliders')}}" class="btn btn-block btn-default btn-rounded">← Geri Dön</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15"><span class="pull-right">Slider Düzenle </span><a id="addNew" class="btn btn-success" href=""><i class="fa fa-plus"></i> Ekle</a></h3>
                        <hr>
                        <h1>{{session('status')}}</h1>

                        <form method="post" action="{{url('admin/settings/slider/update/'.$slider->id)}}" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-body">

                                <div class="col-sm-12">
                                    <div class="form-group col-md-1">
                                        <label for="sort" class="col-sm-2 control-label">Sıra</label>
                                        <div class="col-sm-10">
                                            <input style="width:40px;" type="text" class="form-control pull-right" name="slides[0][sort]" id="sort" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-sm-2 control-label">Resim</label>
                                        <div class="col-sm-10">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control form-control-line" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">Seç</span>
                                                    <span class="fileinput-exists">Değiştir</span>
                                                    <input type="file" name="slides[0][file]">
                                                </span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="name" class="col-sm-2 control-label">Başlık</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="slides[0][name]" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="link" class="col-sm-2 control-label">Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="slides[0][link]" id="link" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <div class="col-sm-10">
                                            <a class="btn btn-danger" href=""><i class="fa fa-remove"></i>Kaldır</a>
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
    <script src="{{asset('src/admin/js/jasny-bootstrap.js')}}"></script>
    <script>

        $( document ).ready(function() {

            $("#addNew").on("click",function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/settings/slider/addArea')}}",
                    success: function (response) {
                        $(".form-body").append(response);
                    }
                });
            });

            // Image Upload
            $('.dropify').dropify({
                messages: {
                    'default': 'Resim seçmek için sürükleyip bırakın veya tıklayın.',
                    'replace': 'Değiştirmek için tıklayın veya bir dosya sürükleyin.',
                    'remove':  'Kaldır',
                    'error':   'Bir hata oluştu.'
                }
            });

        });

    </script>
@endsection