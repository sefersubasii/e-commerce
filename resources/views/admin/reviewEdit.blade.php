@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{$data->name}}</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/reviews')}}" class="btn btn-block btn-default btn-rounded">← Yorumlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Yorum Düzenle</h3>

                        <h1>{{session('status')}}</h1>

                        <form method="post" action="{{url('admin/review/update/'.$data->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Durum</label>
                                    <div class="col-sm-2">
                                        <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                            <option value="1" {{$data->status== 1 ? 'selected="selected"' : ""}} >Aktif</option>
                                            <option value="0" {{$data->status== 0 ? 'selected="selected"' : ""}} >Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="author" class="col-sm-2 control-label">Yorum Başlığı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="author" id="author" value="{{$data->author}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="col-sm-2 control-label">Yorum</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="text" style="height: 140px;">{{$data->text}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="rating" class="col-sm-2 control-label">Puan</label>
                                    <div class="col-sm-2">
                                        <select name="rating" id="rating" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                            <option value="1" {{$data->rating == "1" ? 'selected="selected"' : ''}} >1</option>
                                            <option value="2" {{$data->rating == "2" ? 'selected="selected"' : ''}} >2</option>
                                            <option value="3" {{$data->rating == "3" ? 'selected="selected"' : ''}} >3</option>
                                            <option value="4" {{$data->rating == "4" ? 'selected="selected"' : ''}} >4</option>
                                            <option value="5" {{$data->rating == "5" ? 'selected="selected"' : ''}} >5</option>
                                        </select>
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