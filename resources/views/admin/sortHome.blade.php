@extends('admin.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('src/admin/plugins/bower_components/jquery/dist/jquery-ui.min.css')}}">
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
<style>
    tr > td{
        height: 40px;
    }
</style>
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{$data->title}}</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="brands" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sıra</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Başlık</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Stok Kodu</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Stok</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Fiyat</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $item)
                                    <tr style="cursor: move;" id="item_{{$item->id}}">
                                        <td>{{$item->sort}}</td>
                                        <td>{{$item->product->name}}</td>
                                        <td>{{$item->product->stock_code}}</td>
                                        <td>{{$item->product->stock}}</td>
                                        <td>{{$item->product->price}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/jquery/dist/jquery-ui.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>
        $(function() {

            $('tbody').sortable({
                update:function (event,ui) {
                    var postData = $(this).sortable('serialize');
                    $.ajax({
                        url: "{{url('admin/'.$data->postUrl)}}",
                        type:"post",
                        //dataType:'json',
                        data: {_token:'{{csrf_token()}}',data:postData},
                        success: function(response){

                        },beforeSend: function () {
                            HoldOn.open({
                                theme:"sk-bounce",
                                message: "YÜkleniyor..."
                            });
                        },
                        complete: function () {
                            HoldOn.close();
                        }
                    });
                }/*,
                stop:function () {
                    $.map($(this).find('tr'),function (el) {
                        var itemId=el.id;
                        var itemIndex=$(el).index();

                        $.ajax({
                            url: "{{url('admin/sortHome')}}",
                            type:"post",
                            dataType:'json',
                            data: {_token:'{{csrf_token()}}',itemId:itemId, itemIndex:itemIndex},
                            success: function(response){

                            }
                        });
                    });
                } */
            });
            $('tbody').disableSelection();
        });
    </script>

@endsection

