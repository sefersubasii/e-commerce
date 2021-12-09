@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Marka Ekle</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <?php /*
                    <a href="#" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Buy Now
                    </a>
                    */ ?>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">Dashboard 1</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Marka Ekle</h3>

                        <h1>{{session('status')}}</h1>

                        <form method="post" action="{{url('admin/brands/create')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Başlık</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="code" class="col-sm-2 control-label">Kodu</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="code" id="code" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image" id="input-file-now" class="dropify">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="order" class="col-sm-2 control-label">Sıra</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sort" id="order" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="seo_title" class="col-sm-2 control-label">SEO Başlığı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="seo_title" id="seo_title" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="seo_description" class="col-sm-2 control-label">Meta Açıklama</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="seo_description" style="height: 140px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="seo_keywords" class="col-sm-2 control-label">Anahtar Kelimeler</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="filter_status" class="col-sm-2 control-label">Filtre Durumu</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="filter_status" value="1" id="filter_status" checked="" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">

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