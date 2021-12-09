@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{$banner->name}}</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/settings/banner')}}" class="btn btn-block btn-default btn-rounded">← Bannerlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Banner Düzenle</h3>

                        <form method="post" action="{{url('admin/settings/banner/update/'.$banner->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Başlık</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$banner->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alt" class="col-sm-2 control-label">Alt Etiketi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="alt" id="alt" value="{{$banner->alt}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link" class="col-sm-2 control-label">Link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="link" id="link" value="{{$banner->link}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image" data-default-file="{{asset('src/uploads/banner/'.$banner->image)}}" id="input-file-now" class="dropify">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newTab" class="col-sm-2 control-label">Yeni Sekme</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="newTab" value="{{$banner->newTab}}" {{$banner->newTab == 1 ? "checked" : "" }} id="newTab"  class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
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
    <script>

        $( document ).ready(function() {
            // Image Upload
            var drp = $('.dropify').dropify({
                messages: {
                    'default': 'Resim seçmek için sürükleyip bırakın veya tıklayın.',
                    'replace': 'Değiştirmek için tıklayın veya bir dosya sürükleyin.',
                    'remove':  'Kaldır',
                    'error':   'Bir hata oluştu.'
                }
            });
            drp.on('dropify.beforeClear', function(event, element){
                console.log(element);
                return confirm("Resmi silmek istediğinize emin misiniz ? ");

            });
            drp.on('dropify.afterClear', function(event, element){
                var formData = new FormData();
                formData.append('_token', '{{csrf_token()}}');
                formData.append('id', '{{$banner->id}}');
                $.ajax({
                    url: "{{url('admin/settings/banner/imageRemove')}}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response){
                        console.log("ok");
                    }
                });
            });
        });

    </script>
@endsection