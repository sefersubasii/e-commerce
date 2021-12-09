@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Banka Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/settings/banks')}}" class="btn btn-block btn-default btn-rounded">← Bankalar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Banka Ekle</h3>

                        <form method="post" action="{{url('admin/settings/bank/create/')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="image" id="input-file-now" class="dropify">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Banka Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency" class="col-sm-2 control-label">Hesap Türü</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="currency" id="currency" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="owner" class="col-sm-2 control-label">Hesap Sahibi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="owner" id="owner" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="iban" class="col-sm-2 control-label">IBAN</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="iban" id="iban" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort" class="col-sm-2 control-label">Sıra</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="sort" id="sort" value="">
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

