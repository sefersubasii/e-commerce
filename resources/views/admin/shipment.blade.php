@extends('admin.layout.master')
@section('subNav')
    <div class="container-fluid subNav col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-2 col-sm-2"><a href="{{url('admin/order')}}"><i class="fa fa-shopping-basket clrgreen"></i><br>Siparişler</a></div>
        <div class="col-md-2 col-sm-2 subActive"><a href="{{url('admin/shipment')}}"><i class="fa fa-truck clrblack"></i><br>Kargo</a></div>
    </div>
@endsection


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title pull-left mrt10 mrb10">
                <div class="descriptions">
                    <span class="pdl-5"><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Yeni Ekle</button></span>
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
                        <th>İsim</th>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Yeni Ekle</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Firma:</label>
                            <div class="col-sm-8">
                                <input name="title" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Sıra No:</label>
                            <div class="col-sm-8">
                                <input name="sort" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Ödeme Tipi:</label>
                            <div class="col-sm-8">
                                <select name="paymentType" class="form-control" id="sel1">
                                    <option value="1">Alıcı Ödemeli</option>
                                    <option value="2">Gönderici Ödemeli</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Sabit Ücret:</label>
                            <div class="col-sm-8">
                                <input name="staticPrice" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Ücretsiz Kargo:</label>
                            <div class="col-sm-8">
                                <input name="freeLimit" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label col-sm-4 checkbox fs12">Ücretsiz Desi:</label>
                            <div class="col-sm-8">
                                <input name="freeDesi" type="text" class="form-control" id="recipient-name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label col-sm-4 checkbox fs12">Kapıda Ödeme:</label>
                            <div class="radio col-sm-4">
                                <label><input type="radio" id="openDoor" name="doorStatus">Evet</label>
                                <label><input type="radio" id="closeDoor" name="doorStatus">Hayır</label>
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <div style="display: none" id="collapseOne">
                            <hr>
                            <div class="form-group">
                                <label for="doorMin" class="form-control-label col-sm-4 checkbox fs12">Minimum Kullanım:</label>
                                <div class="col-sm-8">
                                    <input name="doorMin" type="text" class="form-control" id="doorMin">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="doorMax" class="form-control-label col-sm-4 checkbox fs12">Maksimum Kullanım:</label>
                                <div class="col-sm-8">
                                    <input name="doorMax" type="text" class="form-control" id="doorMax">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="form-group">
                                <label for="doorChashSt" class="form-control-label col-sm-4 checkbox fs12">Nakit Ödeme Kullanımı:</label>
                                <div class="col-sm-8">
                                    <div class="checkbox">
                                        <label><input name="doorChashSt" type="checkbox" value="1" id="doorChashSt"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="doorCashType" class="form-control-label col-sm-4 checkbox fs12">Nakit Ücretlendirme Şekli:</label>
                                <div class="col-sm-8">
                                    <select name="doorCashType" class="form-control" id="doorCashType">
                                        <option value="1">Sabit Ücret</option>
                                        <option value="2">Oran</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="doorCashPrice" class="form-control-label col-sm-4 checkbox fs12">Nakit Ücreti / Oranı:</label>
                                <div class="col-sm-8">
                                    <input name="doorCashPrice" type="text" class="form-control" id="doorCashPrice">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="form-group">
                                <label for="doorCardSt" class="form-control-label col-sm-4 checkbox fs12">K.K Ödeme Kullanımı:</label>
                                <div class="col-sm-8">
                                    <div class="checkbox">
                                        <label><input name="doorCardSt" type="checkbox" value="1" id="doorCardSt"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="doorCardType" class="form-control-label col-sm-4 checkbox fs12">K.K Ücretlendirme Şekli:</label>
                                <div class="col-sm-8">
                                    <select name="doorCardType" class="form-control" id="doorCardType">
                                        <option value="1">Sabit Ücret</option>
                                        <option value="2">Oran</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="doorCardPrice" class="form-control-label col-sm-4 checkbox fs12">K.K Ücreti / Oranı:</label>
                                <div class="col-sm-8">
                                    <input name="doorCardPrice" type="text" class="form-control" id="doorCardPrice">
                                </div>
                            </div>

                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Kaydet</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
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
