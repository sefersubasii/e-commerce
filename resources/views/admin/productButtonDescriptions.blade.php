@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h4 class="page-title">Ürün ve stok butonlarının tanımlamaları</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <form method="post" action="{{url('admin/productButton/descriptions/update')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">

                            @foreach($data as $key => $val)

                                <div class="form-group">
                                    <label for="title_c{{$key+1}}" class="col-sm-2 control-label">Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title[]" id="title_c{{$key+1}}" value="{{$val->title}}">
                                    </div>
                                    <label for="input-file-now" class="col-sm-2 control-label">Logo {{$key+1}}</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="c[]" id="input-file-now" class="dropify" data-default-file="{{asset('src/uploads/productButton/descriptions/'.$val->image)}}">
                                    </div>
                                </div>
                                
                            @endforeach

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