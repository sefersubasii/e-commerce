@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Kategoriler</h4>
                </div>

                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="" data-toggle="modal" data-target="#addN11Cat" class="btn btn-block btn-success btn-rounded"><i class="fa fa-plus"></i> Yeni Ekle</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">

                    <div class="xcontent">
                        <div class="table-responsive">
                            <table id="banks" class="display table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="brands_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">ID</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30%;">Lokal Kategori</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Kategori Adı</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Eşleştirilmiş Kategori</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1">Sil</th></tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div style="display:none;" class="modal fade" id="addN11Cat">

                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Kategori Eşleştir</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="POST" action="{{url('admin/output/catMap/create')}}" id="createOutputCatmap" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                                
                                                <div class="localCats">
                                                    <div class="form-group">
                                                        <label for="templateName" class="col-sm-2 control-label">Yerel Kategori</label>
                                                        <div class="col-sm-10">
                                                            <select onchange="showCategories(this.value,0)" name="" id="" rel="local-category" title="Seçiniz" data-style="form-control" class="selectpicker show-tick bs-select-hidden">
                                                                @foreach($localCat as $k => $v)
                                                                    <option value="{{$v->id}}">{{$v->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="sub-category-0"></div>
                                                    <input type="hidden" value="" name="categoryId" id="categoryId">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="remote_cat_id" class="col-sm-2 control-label">Eşleştirilecek Kategori ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="remote_cat_id" id="remote_cat_id" value="">
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="output_id" value="{{app('request')->segment(4)}}">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onClick="$('#createOutputCatmap').submit();" class="btn btn-default">Uygula</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                                </div>
                          </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>


        function showCategories(data,parent)
        {
            if (data=='') {
               $('#sub-category-'+parent).html('');
               $('#categoryId').val(""); 
               return;
            }

            var formData = new FormData();
                formData.append('id',data);
                formData.append('_token',$('meta[name=_token]').attr("content"));
            $.ajax({
                url: "{{url('admin/categories/getCategories')}}",
                type:'POST',
                contentType: false,
                data: formData,
                processData: false,
                dataType: "json",
                success: function(response){

                    if (response.status==200) {

                        if (response.data.length <= 0) {
                            $('#sub-category-'+parent).html('');
                            return;
                        }
                        $('#sub-category-'+parent).html('<div class="form-group"><label for="templateName" class="col-sm-2 control-label"></label><div class="col-sm-10"><select rel="local-category" onchange="showCategories(this.value,'+response.parent+')" name="" id="'+response.parent+'" title="Seçiniz" data-style="form-control" class="selectpicker show-tick bs-select-hidden"></select></div></div><div id="sub-category-'+response.parent+'"><div>');
                        $.each(response.data, function (i,e){
                            $('#'+response.parent).append('<option value="'+e.id+'">'+e.title+'</option>');
                        });

                        $('.selectpicker').selectpicker();
                    }

                }
            });

            $('#categoryId').val(data);
    

        }

        function showN11Categories(data,parent)
        {
            if (data=='') {
               $('#n11-sub-category-'+parent).html('');
               $('#n11CategoryId').val(""); 
               return;
            }

            var formData = new FormData();
                formData.append('id',data);
                formData.append('_token',$('meta[name=_token]').attr("content"));
            $.ajax({
                url: "{{url('admin/n11/getCategories')}}",
                type:'POST',
                contentType: false,
                data: formData,
                processData: false,
                dataType: "json",
                success: function(response){

                    if (response.result.status=="success") {

                        if ( typeof response.category.subCategoryList == "undefined") {
                            $('#n11-sub-category-'+response.category.id).html('');
                            return;
                        }

                        $('#n11-sub-category-'+parent).html('<div class="form-group"><label for="templateName" class="col-sm-2 control-label"></label><div class="col-sm-10"><select rel="n11-category" onchange="showN11Categories(this.value,'+response.category.id+')" name="" id="'+response.category.id+'" title="Seçiniz" data-style="form-control" class="selectpicker show-tick bs-select-hidden"></select></div></div><div id="n11-sub-category-'+response.category.id+'"><div>');
                        $.each(response.category.subCategoryList.subCategory, function (i,e){
                            $('#'+response.category.id).append('<option value="'+e.id+'">'+e.name+'</option>');
                        });

                        $('.selectpicker').selectpicker();
                    }else{
                        console.log("2");
                    }

                }
            });

            $('#n11CategoryId').val(data);
        }



        $(function() {
            
        });

        $(document).ready(function(){

            var oTable = $('#banks').DataTable({
                language: {
                    "url": "{{ asset('vendor/datatables/turkish.json') }}",
                    buttons: {
                        pageLength: '%d Kayıt Göster'
                    }
                },
                processing: true,
                serverSide: true,
                ordering:false,
                ajax: "{{url('admin/output/catMap/datatable/'.app('request')->segment(4))}}",
                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: true},
                    {data: 'local_cat_id', name: 'local_cat_id', orderable: false, searchable: false},
                    {data: 'cat.title', name: 'cat.title', orderable: false, searchable: false},
                    {data: 'remote_cat_id', name: 'remote_cat_id', orderable: false, searchable: false},
                    { "mRender": function ( data, type, row ) {
                        return '<a href="{{url('./')}}/admin/output/catMap/delete/'+row.id+'" data-toggle="tooltip" title="Sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i></a>';                    
                    },orderable: false, className:'text-center'}
                ],
                "columnDefs": [
                    { "width": "20", "targets": 4 },
                    { "width": "70", "targets": 0 }
                ]
            });
            
            $("#createN11temp").on('submit',function (e) {
                e.preventDefault();
                
                var n11CategoryList = [];
                var localCategoryList = [];

                $('[rel=n11-category] option:selected').each(function(){
                    n11CategoryList.push($(this).text());
                });
                $('[rel=local-category] option:selected').each(function(){
                    if ($(this).text()!="Seçiniz" && $(this).text()!="" ) {
                        localCategoryList.push($(this).text());
                    }
                });

                $('#n11CategoryPath').val(n11CategoryList.join(' > ', n11CategoryList));
                $('#localCategoryPath').val(localCategoryList.join(' > ', localCategoryList));

                $.ajax({
                url: $('#createN11temp').attr('action'),
                type:'POST',
                data: $('#createN11temp').serialize(),
                dataType: "json",
                success: function(response){

                    if (response.status==200) {
                        document.getElementById("createN11temp").reset();
                        $('#addN11Cat').modal('toggle');
                        oTable.draw();
                    }else{
                        document.getElementById("createN11temp").reset();
                        $('#addN11Cat').modal('toggle');
                        alert(response.message);
                    }

                }
            });


            });       
        });

    </script>

@endsection

