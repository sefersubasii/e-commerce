@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{$data->name}}</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/redirection')}}" class="btn btn-block btn-default btn-rounded">← Yönlendirmeler</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Yönlendirme Düzenle</h3>

                        <h1>{{session('status')}}</h1>

                        <form method="post" action="{{url('admin/redirection/update/'.$data->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="oldUrl" class="col-sm-2 control-label">Eski Url</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="oldUrl" id="oldUrl" value="{{$data->oldUrl}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newUrl" class="col-sm-2 control-label">Yeni Url</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="newUrl" id="newUrl" value="{{$data->newUrl}}">
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
                            <input type="hidden" name="id" value="{{$data->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $( document ).ready(function() {

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