@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Kullanıcı Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/user')}}" class="btn btn-block btn-default btn-rounded">← Kullanıcılar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Kullanıcı Düzenle</h3>

                        <form method="post" action="{{route('admin.user.update',$user->id)}}" class="form-horizontal form-bordered">
                            {{ method_field('PATCH') }}
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label text-danger">API Token</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $user->api_token }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Ad Soyad</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Mail</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email" disabled id="email" value="{{$user->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Şifre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="password" id="password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="roles" class="col-sm-2 control-label">Roller</label>
                                <div class="col-sm-10">
                                    <select name="roles[]" id="roles" multiple=""  class="role-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        @foreach($user->roles as $role)
                                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
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

        $(document).ready(function () {

            // Categories
            $(".role-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/role/ajaxList')}}",
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
                                return { id: item.id, text: item.name};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Rol Seçiniz'
            });

        });

    </script>
@endsection