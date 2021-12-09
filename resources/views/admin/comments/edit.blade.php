@extends('admin.layout.master')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yorum Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-block btn-default btn-rounded">← Tüm Yorumlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <form method="post" action="{{ route('admin.comments.update', $comment->id) }}" class="form-horizontal form-bordered">
                            {{ method_field('PUT') }}
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Ad Soyad</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $comment->name) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Yorum</label>
                                    <div class="col-sm-10">
                                        <textarea name="message" class="form-control" rows="8" cols="80">{{ old('message', $comment->message) }}</textarea>
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
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
