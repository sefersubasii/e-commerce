@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Kargo Firması Ekle</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <?php /*
                    <a href="#" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Buy Now
                    </a>
                    */ ?>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">Dashboard 1</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Kargo Firması Ekle</h3>

                        <form method="post" action="{{url('admin/shippingCompanies/create')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Durum</label>
                                <div class="col-sm-2">
                                    <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Pasif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pay_type" class="col-sm-2 control-label">Ödeme Tipi</label>
                                <div class="col-sm-2">
                                    <select name="pay_type" id="pay_type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="0">Gönderici Ödemeli</option>
                                        <option value="1">Alıcı Ödemeli</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="integration" class="col-sm-2 control-label">Entegrasyon</label>
                                <div class="col-sm-2">
                                    <select name="integration" id="integration" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                        <option value="1">Sürat Kargo</option>
                                        <option value="2">Aras Kargo</option>
                                        <option value="3">Yurtiçi Kargo</option>
                                        <option value="4">Ptt Kargo</option>
                                        <option value="0">Diğer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Firma Adı</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order" class="col-sm-2 control-label">Sıra</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="order" id="order" value="999">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-file-now" class="col-sm-2 control-label">Resim</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="input-file-now" class="dropify">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">Sabit Fiyat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="price" id="price" value="0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pd_status" class="col-sm-2 control-label">Kapıda Ödeme Durumu</label>
                                <div class="col-sm-2">
                                    <select name="pd_status" id="pd_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-title="Durum Seçiniz" data-width="100%"><option class="bs-title-option" value="">Durum Seçiniz</option>
                                        <option value="1">Aktif</option>
                                        <option value="0" selected="selected">Pasif</option>
                                    </select>
                                </div>
                            </div>
                            <div id="pd_active" style="display: none;">
                                <div class="form-group">
                                    <label for="pdCash_status" class="col-sm-2 control-label">Kapıda Nakit Ödeme</label>
                                    <div class="col-sm-2">
                                        <select name="pdCash_status" id="pdCash_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                            <option value="1" selected="selected">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pdCash_price" class="col-sm-2 control-label">Kapıda Nakit Ödeme Fiyatı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pdCash_price" id="pdCash_price" value="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pdCard_status" class="col-sm-2 control-label">Kapıda Kredi Kartı İle Ödeme</label>
                                    <div class="col-sm-2">
                                        <select name="pdCard_status" id="pdCard_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                            <option value="1" selected="selected">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pdCard_price" class="col-sm-2 control-label">Kapıda Kredi Kartı İle Ödeme Fiyatı</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pdCard_price" id="pdCard_price" value="0">
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

            $("#pd_status").on('change', function(){
                var val = $(this).val();
                if(val == 1){
                    $("#pd_active").show();
                }else {
                    $("#pd_active").hide();
                }
            });


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