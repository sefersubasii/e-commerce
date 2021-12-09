@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Sayfa Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/pages')}}" class="btn btn-block btn-default btn-rounded">← Sayfalar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Sayfa Düzenle</h3>

                        <form method="post" action="{{url('admin/pages/update/'.$data->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">SEO</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{$data->status == 1 ? 'selected="selected"' : '' }} value="1">Aktif</option>
                                                <option {{$data->status == 0 ? 'selected="selected"' : '' }} value="0">Pasif</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Sayfa Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" id="title" value="{{$data->title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort" class="col-sm-2 control-label">Sıra</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="sort" id="sort" value="{{$data->sort}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ckeditor" class="col-sm-2 control-label">İçerik</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor"  name="content" style="height: 140px; visibility: hidden; display: none;">{{$data->content}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="slug" class="col-sm-2 control-label">Sayfa Adresi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="slug" id="slug" value="{{$data->slug}}">
                                            <span class="help-block">Kategori adresini kişileştirmek istiyorsanız özel url kullanımını aktif ederek yazdığınız değeri kullanabilirsiniz.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="custom_url" class="col-sm-2 control-label">Özel URL Kullan</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="custom_url" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_title" class="col-sm-2 control-label">SEO Başlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{json_decode($data->seo)->seo_title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_description" class="col-sm-2 control-label">Meta Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="seo_description" id="seo_description" style="height: 140px;">{{json_decode($data->seo)->seo_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_keywords" class="col-sm-2 control-label">Anahtar Kelimeler</label>
                                        <div class="col-sm-10">

                                            <input name="seo_keywords" value="{{json_decode($data->seo)->seo_keywords}}" id="seo_keywords" data-role="tagsinput" style="display: none;">
                                            <div class="input-group" style="margin-top:10px;">
                                                <div class="input-group-addon">Etiket Arama</div>

                                                <input type="text" class="form-control" name="seo_tags" id="seo_tags" style="display: none;">
                                            </div>
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
                            <input type="hidden" name="id" value="{{$data->id}}">
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

            function matchResults(results){
                var arr = [];
                for (x in results[1]) {
                    if(results[1][x][0].length<=50){
                        arr.push({id:results[1][x][0],name:results[1][x][0]});
                    }
                }
                return arr;
            }

            $("#seo_tags").tokenInput("https://www.google.com.tr/s?hl=tr&cp=1&gs_ri=psy-ab&xhr=t&pf=p&site=&source=hp", {
                hintText: "Etiket Giriniz..",
                noResultsText: "Sonuç Yok",
                searchTitle: "Etiket Ara",
                searchingText: "Aranıyor...",
                method: "GET",
                queryParam: "q",
                contentType: "jsonp",
                onResult: matchResults,
                tokenLimit: 10,
                tokenCount: 0,
                minChars: 2,
                unique: true,
                searchDelay: 250,
                onAdd: function (item) {
                    $('#seo_keywords').tagsinput('add', strip_tags(item.id));
                    $(".token-input-token").remove();
                }
            });

        });

    </script>
@endsection

