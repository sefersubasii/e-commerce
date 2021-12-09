@extends('admin.layout.master')

@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/HoldOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Özellik Grubu Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/attributeGroups')}}" class="btn btn-block btn-default btn-rounded">← Gruplar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Özellik Ekle</h3>

                        <form method="post" action="{{url('admin/attribute/update/'.$data["attr"]->id)}}" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="group_id" class="col-sm-2 control-label">Özellik Grubu</label>
                                    <div class="col-sm-3">
                                        <select name="group_id" class="attributeGroups-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            <option selected="selected" value="{{@$data["attr"]->gid}}">{{@$data["group"]}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Özellik Adı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$data["attr"]->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Özellik Değerleri</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info" id="addValue">Değer Ekle</button>
                                        </div>
                                        <div id="degerler">
                                            @foreach($data["value"] as $valAtt)
                                                <div id="{{$valAtt->id}}" style="margin-bottom:10px;">
                                                    <label class="col-sm-1 control-label">Değer Adı</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" value="{{$valAtt->value}}" name="degerler[]">
                                                    </div>
                                                    <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="$.deleteDivFromId('{{$valAtt->id}}')"><i class="fa fa-close"></i> Sil</button></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            @endforeach
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
                            <input type="hidden" name="id" value="{{$data["attr"]->id}}">
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

            // Attribute Group Ajax
            $(".attributeGroups-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/attributeGroups/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            class_id: $("#attributeClasses").val(),
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Özellik Grubu Seçiniz',
            });

            $("#addValue").on('click', function(){
                $.ajax({
                    url: "{{url('admin/attribute/addAttributeArea')}}",
                    success: function(response){
                        $("#degerler").append(response);
                    },
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Ekleniyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });
            });

            $.deleteDivFromId = function(div){
                $("#"+div).remove();
            }

        });

    </script>
@endsection