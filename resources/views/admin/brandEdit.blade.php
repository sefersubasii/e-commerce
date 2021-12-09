@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{$data->name}}</h4>
            </div>
            <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                <a href="{{url('admin/brands')}}" class="btn btn-block btn-default btn-rounded">← Markalar</a>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-15">Marka Düzenle</h3>
                    <form method="post" action="{{url('admin/brands/update/'.$data->id)}}" enctype="multipart/form-data"
                        class="form-horizontal form-bordered">
                        <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="ti-home"></i></span>
                                    <span class="hidden-xs">Marka Bilgileri</span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs">
                                    <i class="ti-user"></i></span> 
                                    <span class="hidden-xs">Marka & Kategori</span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs">
                                    <i class="ti-user"></i></span> 
                                    <span class="hidden-xs">Ek Bilgiler</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Başlık</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{$data->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="code" class="col-sm-2 control-label">Kodu</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="code" id="code"
                                                value="{{$data->code}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="image"
                                                data-default-file="{{asset('src/uploads/brands/'.$data->image)}}"
                                                id="input-file-now" class="dropify">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="order" class="col-sm-2 control-label">Sıra</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="sort" id="order"
                                                value="{{$data->sort}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_title" class="col-sm-2 control-label">SEO Başlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="seo_title" id="seo_title"
                                                value="{{$data->seo_title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_description" class="col-sm-2 control-label">Meta
                                            Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="seo_description"
                                                style="height: 140px;">{{$data->seo_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_keywords" class="col-sm-2 control-label">Anahtar
                                            Kelimeler</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="seo_keywords"
                                                id="seo_keywords" value="{{$data->seo_keywords}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="filter_status" class="col-sm-2 control-label">Filtre Durumu</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" name="filter_status" value="{{$data->filter_status}}"
                                                {{$data->filter_status == 1 ? "checked" : "" }} id="filter_status"
                                                class="js-switch" data-size="medium" data-color="#4F5467"
                                                data-switchery="true" style="display: none;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab2">

                                <div class="form-group">
                                    <label for="" class="col-sm-1 control-label">Ekle</label>
                                    <button id="addSlot" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                </div>


                                @foreach(@$data->category as $k => $v)
                                <div class="form-group">
                                    <label for="" class="col-sm-1 control-label">Kategori ID</label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control" name="brandCatId[]"
                                            value="{{$v->category_id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brandCatTitle" class="col-sm-1 control-label">Title</label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control" name="brandCatTitle[]"
                                            value="{{$v->title}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bcdescription" class="col-sm-1 control-label">Description</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control" name="bcdescription[]"
                                            style="height: 140px;">{{$v->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-file-now" class="col-sm-1 control-label">Resim</label>
                                    <div class="col-sm-11">
                                        <input type="file" name="imageCat[]"
                                            data-default-file="{{asset('src/uploads/brands-category/'.$v->image)}}"
                                            id="input-file-now" class="dropify">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea class="form-control editor" name="content[]"
                                            style="height: 140px; visibility: hidden; display: none;">{{$v->content}}</textarea>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea id="extra_content" name="extra_content" class="form-control" style="height: 140px;">{{ $data->extra_content }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a onclick="return confirm('Yaptığınız değişikleri kaydetmeden çıkmak istediğinize emin misiniz?')"
                                                href="{{url('admin/brands')}}" class="btn btn-warning"> <i
                                                    class="fa fa-check"></i> Geri Dön</a>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>
                                                Gönder</button>
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
    $(document).ready(function () {

        var options = {
            filebrowserImageBrowseUrl: '{{ url("filemanager?type=Images") }}',
            filebrowserImageUploadUrl: '{{ url("filemanager/upload?type=Images&_token=") }}',
            filebrowserBrowseUrl: '{{ url("filemanager?type=Files") }}',
            filebrowserUploadUrl: '{{ url("filemanager/upload?type=Files&_token") }}'
        };

        $('#addSlot').on('click', function (e) {
            var random = Math.random();
            e.preventDefault();
            $('#tab2').append(
                '<div class="form-group"><label for="" class="col-sm-1 control-label">Kategori ID</label><div class="col-sm-11"><input type="text" class="form-control" name="brandCatId[]" id="" value=""></div></div><div class="form-group"><label for="" class="col-sm-1 control-label">Title</label><div class="col-sm-11"><input type="text" class="form-control" name="brandCatTitle[]" id="" value=""></div></div><div class="form-group"><label for="bcdescription" class="col-sm-1 control-label">Description</label><div class="col-sm-11"><textarea class="form-control" name="bcdescription[]" style="height: 140px;"></textarea></div></div><div class="form-group"><label for="input-file-now" class="col-sm-1 control-label">Resim</label><div class="col-sm-11"><input type="file" name="imageCat[]" data-default-file="" id="input-file-now" class="dropify"></div></div><div class="form-group"><div class="col-sm-12"><textarea class="form-control editor" id="ckeditor' +
                random +
                '" name="content[]" style="height: 140px; visibility: hidden; display: none;"></textarea></div></div>'
            );
            CKEDITOR.replace('ckeditor' + random, options);
            $('.dropify').dropify({
                messages: {
                    'default': 'Resim seçmek için sürükleyip bırakın veya tıklayın.',
                    'replace': 'Değiştirmek için tıklayın veya bir dosya sürükleyin.',
                    'remove': 'Kaldır',
                    'error': 'Bir hata oluştu.'
                }
            });

        });

        // Image Upload
        $('.dropify').dropify({
            messages: {
                'default': 'Resim seçmek için sürükleyip bırakın veya tıklayın.',
                'replace': 'Değiştirmek için tıklayın veya bir dosya sürükleyin.',
                'remove': 'Kaldır',
                'error': 'Bir hata oluştu.'
            }
        });

        CKEDITOR.replace('extra_content', options);
    });
</script>
@endsection