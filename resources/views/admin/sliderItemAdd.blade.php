@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Slider Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/settings/sliders')}}" class="btn btn-block btn-default btn-rounded">← Sliderlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Slide Ekle</h3>
                        <form method="post" action="{{url('admin/settings/sliderItem/create/')."/".$id}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Slide Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Durum</label>
                                    <div class="col-sm-2">
                                        <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-title="Durum Seçiniz" data-width="100%"><option class="bs-title-option" value="">Durum Seçiniz</option>
                                            <option value="1" selected="selected">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">Sıra</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sort" id="sort" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image" id="input-file-now" class="dropify" data-default-file="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-file-now" class="col-sm-2 control-label">Logo</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="imageCover" id="input-file-now" class="dropify" data-default-file="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">İçerik</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="content" id="content" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link" class="col-sm-2 control-label">Link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="link" id="link" value="">
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