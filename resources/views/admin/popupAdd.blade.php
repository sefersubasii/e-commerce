@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Popup Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/settings/popup')}}" class="btn btn-block btn-default btn-rounded">← Popuplar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Popup Düzenle</h3>
                        <form method="post" action="{{url('admin/settings/popup/create/')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Popup Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ckeditor" class="col-sm-2 control-label">İçerik</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control editor"  name="content" style="height: 140px; visibility: hidden; display: none;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Durum</label>
                                    <div class="col-sm-2">
                                        <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-title="Durum Seçiniz" data-width="100%"><option class="bs-title-option" value="">Durum Seçiniz</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="frequency" class="col-sm-2 control-label">Gösterim Sıklığı (dk.)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="frequency" id="frequency" value="5">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="homeStatus" class="col-sm-2 control-label">Anasayfa</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="homeStatus" id="homeStatus"  class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category" class="col-sm-2 control-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="category" id="category"  class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                    </div>
                                </div>

                                <div id="usage_4" style="display: none">
                                    <div class="form-group">
                                        <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                        <div class="col-sm-10">
                                            <select name="categories[]" id="categories" multiple="" class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
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

            $("input[name=category]").on("change",function () {

                if($(this).is(":checked")){
                    $("#usage_4").slideDown();
                }else{
                    $("#usage_4").slideUp();
                }


            });

            // Categories
            $(".categories-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/categories/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.title};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Kategori Seçiniz'
            });

        });

    </script>
@endsection