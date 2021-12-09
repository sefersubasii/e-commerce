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
                        <h3 class="box-title m-b-15">Slider Düzenle</h3>
                        <form method="post" action="{{url('admin/settings/slider/update/')."/".$slider->id}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Slide Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="description" id="description" value="{{$slider->description}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Durum</label>
                                    <div class="col-sm-2">
                                        <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-title="Durum Seçiniz" data-width="100%"><option class="bs-title-option" value="">Durum Seçiniz</option>
                                            <option {{$slider->status==1?"selected":""}} value="1">Aktif</option>
                                            <option {{$slider->status==0?"selected":""}} value="0">Pasif</option>
                                        </select>
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

        });

    </script>
@endsection