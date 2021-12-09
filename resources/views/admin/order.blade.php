@extends('admin.layout.master')
@section('subNav')
    <div class="container-fluid subNav col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-2 col-sm-2"><a href="{{url('admin/order')}}"><i class="fa fa-shopping-basket clrgreen"></i><br>Siparişler</a></div>
        <div class="col-md-2 col-sm-2"><a href="{{url('admin/shipment')}}"><i class="fa fa-truck clrblack"></i><br>Kargo</a></div>
    </div>
@endsection


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title pull-left mrt10 mrb10">
                <div class="descriptions">
                    <span class="pdl-5"><a class="btn btn-success btn-sm" href="Yeni Ekle"><i class="fa fa-plus"></i> Yeni Ekle</a></span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_title pull-right mrt10 mrb10">
                <div class="descriptions">
                    <div class="circle green"></div>
                    <span class="pdl-5">Yeni</span>
                </div>
                <div class="descriptions">
                    <div class="circle purple"></div>
                    <span class="pdl-5">Yeni</span>
                </div>
                <div class="descriptions">
                    <div class="circle skyblue"></div>
                    <span class="pdl-5">İndirim</span>
                </div>
                <div class="descriptions">
                    <div class="circle yellow"></div>
                    <span class="pdl-5">Gün.Fırsatı</span>
                </div>
                <div class="descriptions">
                    <div class="circle orange"></div>
                    <span class="pdl-5">Popüler Ürün</span>
                </div>


                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="dt-body-center sorting_disable"><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                        <th>Şirket Adı</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Fax</th>
                        <th><div class="circle green"></div></th>
                        <th><div class="circle purple"></div></th>
                        <th><div class="circle skyblue"></div></th>
                        <th><div class="circle yellow"></div></th>
                        <th><div class="circle orange"></div></th>
                        <th>İşlem</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="dt-body-center"><input type="checkbox" name="id[]" value="1"></td>
                        <td>a</td>
                        <td>a</td>
                        <td>a</td>
                        <td>a</td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td class="text-center">
                            <button  id="editCustomer" class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit"></i></button>
                            <button  id="removeCustomer" class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Sil"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="dt-body-center"><input type="checkbox" name="id[]" value="2"></td>
                        <td>b</td>
                        <td>b</td>
                        <td>b</td>
                        <td>b</td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td><input type="checkbox" name="opt[]" value="1"></td>
                        <td class="text-center">
                            <button  id="editCustomer" class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit"></i></button>
                            <button  id="removeCustomer" class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Sil"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>


                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var table = $('#datatable-responsive').DataTable({
            responsive: true,
            "order": [[ 1, "asc" ]],
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            },{
                'targets': 5,
                'width':10,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            },{
                'targets': 6,
                'width':10,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            },{
                'targets': 7,
                'width':10,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            },{
                'targets': 8,
                'width':10,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            },{
                'targets': 9,
                'width':10,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center'
            }],
            "language": {
                "url": "{{ asset('vendor/datatables/turkish.json') }}"
            }

        });

        $('#select-all').on('click', function(){
            // Get all rows with search applied
            var rows = table.rows({ 'search': 'applied' }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    </script>

@endsection
