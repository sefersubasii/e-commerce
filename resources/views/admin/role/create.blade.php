@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Rol Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/role')}}" class="btn btn-block btn-default btn-rounded">← Roller</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row">
                            <h3 class="box-title m-b-15">Kullanıcı Rolleri Düzenle</h3>

                            <form method="post" action="{{route('admin.role.store')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">

                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Role</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="display_name" class="col-sm-2 control-label">Görünen Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="display_name" id="display_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Açıklama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="description" id="description">
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <h3 class="box-title m-b-0">&nbsp;</h3>
                                    <label class="form-control" for="">Kullanıcı Yönetimi</label>
                                    <label class="form-control" for="">Üye/Bayi Yönetimi</label>
                                    <label class="form-control" for="">Ürün Yönetimi</label>
                                    <label class="form-control" for="">Kategori Yönetimi</label>
                                    <label class="form-control" for="">Sipariş Yönetimi</label>
                                    <label class="form-control" for="">Kargo Yönetimi</label>
                                    <label class="form-control" for="">Kampanya Yönetimi</label>
                                    <label class="form-control" for="">İçerik Yönetim</label>
                                    <label class="form-control" for="">Entegrasyon Yönetimi</label>
                                    <label class="form-control" for="">Site Ayarları</label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                    <h3 class="box-title text-center m-b-0">Görüntüleme Yetkisi</h3>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="1" id="checkbox1" type="checkbox">
                                        <label for="checkbox1"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="5" id="checkbox5" type="checkbox">
                                        <label for="checkbox5"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="9" id="checkbox9" type="checkbox">
                                        <label for="checkbox9"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="13" id="checkbox13" type="checkbox">
                                        <label for="checkbox13"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="17" id="checkbox17" type="checkbox">
                                        <label for="checkbox17"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="21" id="checkbox21" type="checkbox">
                                        <label for="checkbox21"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="25" id="checkbox25" type="checkbox">
                                        <label for="checkbox25"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="29" id="checkbox29" type="checkbox">
                                        <label for="checkbox29"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">
                                        <input name="permissions[]" value="33" id="checkbox33" type="checkbox">
                                        <label for="checkbox33"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-warning">

                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                    <h3 class="box-title text-center m-b-0">Ekleme Yetkisi</h3>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="2" id="checkbox2" type="checkbox">
                                        <label for="checkbox2"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="6" id="checkbox6" type="checkbox">
                                        <label for="checkbox6"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="10" id="checkbox10" type="checkbox">
                                        <label for="checkbox10"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="14" id="checkbox14" type="checkbox">
                                        <label for="checkbox14"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="18" id="checkbox18" type="checkbox">
                                        <label for="checkbox18"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="22" id="checkbox22" type="checkbox">
                                        <label for="checkbox22"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="26" id="checkbox26" type="checkbox">
                                        <label for="checkbox26"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="30" id="checkbox30" type="checkbox">
                                        <label for="checkbox30"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                        <input name="permissions[]" value="34" id="checkbox34" type="checkbox">
                                        <label for="checkbox34"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-success">
                                    
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                    <h3 class="box-title text-center m-b-0">Düzenleme Yetkisi</h3>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="3" id="checkbox3" type="checkbox">
                                        <label for="checkbox3"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="7" id="checkbox7" type="checkbox">
                                        <label for="checkbox7"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="11" id="checkbox11" type="checkbox">
                                        <label for="checkbox11"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="15" id="checkbox15" type="checkbox">
                                        <label for="checkbox15"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="19" id="checkbox19" type="checkbox">
                                        <label for="checkbox19"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="23" id="checkbox23" type="checkbox">
                                        <label for="checkbox23"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="27" id="checkbox27" type="checkbox">
                                        <label for="checkbox27"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="31" id="checkbox31" type="checkbox">
                                        <label for="checkbox31"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="35" id="checkbox35" type="checkbox">
                                        <label for="checkbox35"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-info">
                                        <input name="permissions[]" value="39" id="checkbox39" type="checkbox">
                                        <label for="checkbox39"> Yetki </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                    <h3 class="box-title text-center m-b-0">Silme Yetkisi</h3>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="4" id="checkbox4" type="checkbox">
                                        <label for="checkbox4"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="8" id="checkbox8" type="checkbox">
                                        <label for="checkbox8"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="12" id="checkbox12" type="checkbox">
                                        <label for="checkbox12"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="16" id="checkbox16" type="checkbox">
                                        <label for="checkbox16"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="20" id="checkbox20" type="checkbox">
                                        <label for="checkbox20"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="24" id="checkbox24" type="checkbox">
                                        <label for="checkbox24"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="28" id="checkbox28" type="checkbox">
                                        <label for="checkbox28"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="32" id="checkbox32" type="checkbox">
                                        <label for="checkbox32"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                        <input name="permissions[]" value="36" id="checkbox36" type="checkbox">
                                        <label for="checkbox36"> Yetki </label>
                                    </div>
                                    <div class="form-control m-b-5 text-center checkbox checkbox-danger">
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                            </form>

                        </div>
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