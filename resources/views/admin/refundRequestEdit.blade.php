@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">{{@$data->name}}</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <form method="post" id="frm" action="{{url('admin/'.$data->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Sipariş Detayları</div>

                            <div class="panel-wrapper">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Ref No / Sipariş No</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->order_no}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Müşteri Adı Soyadı</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->customer->name." ".$data->order->customer->surname}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Ödeme Türü</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->payment}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Müşteri Mail Adresi</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->customer->email}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Kargo Firması</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->shippingCompany->name}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Müşteri Telefon</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->customer->phone}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Kargo No</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->shipping_no}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Müşteri Adresi</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">teslimat adresi</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>Sipariş Tarihi</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->created_at}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>İade ve İptal Durumu</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$data->order->status==0?"Onay Bekliyor":"Onaylandı"}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4"><b>IP Adresi</b></div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">1211212121212</div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="col-md-4">Sepetim</div>
                                <div class="col-md-3 text-center">İade Edilmek İstenen Miktar</div>
                                <div class="col-md-1 text-center">Miktar</div>
                                <div class="col-md-2 text-center">Stok Kodu</div>
                                <div class="col-md-2 text-center">Fiyat</div>
                            </div>

                            <div class="panel-wrapper">

                                @foreach($data->order->items as $item )

                                    <div class="panel-body">
                                        <div class="col-md-1">
                                            @if(in_array($item->product_id,$data->ids))
                                                <input type="hidden" value="{{$item->product_id}}" name="products[{{$item->product_id}}][id]">
                                                <div class="checkbox checkbox-inverse">
                                                    <input name="products[{{$item->product_id}}][status]" id="checkbox_1" type="checkbox" {{@$data->reqQty($item->product_id)->status == 0 ? "" : "checked" }}  value="1" class="order_checkbox" {{$data->status == 0 ? "":"disabled" }}>
                                                    <label for="checkbox_1"></label>
                                                </div>
                                            @else
                                                <i data-toggle="tooltip" data-original-title="Bu ürün için iptal veya iade talebi bulunmuyor." style="font-size: 25px;color: red" class="fa fa-times-circle"></i>
                                            @endif
                                        </div>
                                        <div class="col-md-3">{{$item->name}}</div>
                                        <div class="col-md-3">
                                            @if(in_array($item->product_id,$data->ids))
                                            <input class="vertical-spin" data-max="{{$item->qty}}" type="text" data-bts-button-down-class="btn btn-default btn-outline"   data-bts-button-up-class="btn btn-default btn-outline" value="{{@$data->reqQty($item->product_id)->qty}}" name="products[{{$item->product_id}}][qty]">
                                            @endif
                                        </div>
                                        <div class="col-md-1 text-center">x {{$item->qty}}</div>
                                        <div class="col-md-2 text-center">{{$item->stock_code}}</div>
                                        <div class="col-md-2 text-center">{{$item->price}}</div>
                                    </div>

                                @endforeach
                                    <hr>
                                <div class="panel-body">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="col-sm-4 text-right"><b>Ara Toplam</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->subtotal}} TL</div>
                                        <div class="col-sm-4 text-right"><b>KDV</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->tax_amount}} TL</div>
                                        <div class="col-sm-4 text-right"><b>KDV Dahil</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->subtotal+$data->order->tax_amount}} TL</div>
                                        <div class="col-sm-4 text-right"><b>Kargo Ücreti</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->shipping_amount}} TL</div>
                                        <div class="col-sm-4 text-right"><b>Genel Toplam</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->grand_total}} TL</div>
                                        <div class="col-sm-4 text-right"><b>Taksitli Fiyatı</b></div>
                                        <div class="col-sm-2 text-center"><b> : </b></div>
                                        <div class="col-sm-4 text-left">{{$data->order->grand_total}} TL</div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">İade & İptal Sebebi</div>

                            <div class="panel-wrapper">
                                <div class="panel-body">

                                    <div style="background-color: #fee007" class="col-md-12 p-10 m-b-20">
                                        
                                        {{$data->description}}
                                        
                                        @foreach($data->products as $k => $v)

                                            <span>{{ $v->product->name." - ".$v["description"] }}</span><br>

                                        @endforeach
                                    </div>


                                    @if($data->status==0)
                                    <div class="form-group">
                                        <label for="price" class="col-sm-4 control-label">Lütfen iade edilecek sipariş tutarını giriniz. Kdv Dahil</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="price"  id="price" class="form-control"  data-size="medium" data-color="#4F5467">
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" data-status="2" class="btn btn-danger pull-left sendBtn"> <i class="fa fa-check"></i> İade Talebini İptal Et</button>
                                                        <button type="button" data-status="1" class="btn btn-success pull-right sendBtn"> <i class="fa fa-check"></i> İade Talebini Onayla</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="orderId" value="{{$data->order->id}}">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    @else
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-4">İade Edilen Sipariş Tutarı Kdv Dahil : {{$data->refundAmount}} TL</div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a href="{{url("admin/refundRequests")}}" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i> Geri Dön</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script>
        $(".vertical-spin").TouchSpin({
            min: 0,
            max: $(this).attr('data-max'),
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        vspinTrue.on("touchspin.on.startspin", function(e) {
            $(this).attr("value",e.target.value);
        });

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

            $(".sendBtn").on("click",function (e) {
                e.preventDefault();
                var formData = new FormData();
                var other_data = $('#frm').serializeArray();
                $.each(other_data,function(key,input){
                    formData.append(input.name,input.value);
                });
                formData.append('status',$(this).attr("data-status"));
                $.ajax({
                    url: "{{url('admin/refundRequests/update')}}",
                    type:'POST',
                    contentType: false,
                    data: formData,
                    processData: false,
                    dataType: "json",
                    success: function(response){
                        location.reload();
                        //$(".shortEditModal").html(response.message);
                        //$("#add_brand").trigger("click");

                    }
                });
            })

        });



    </script>
@endsection