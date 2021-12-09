@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/fancytree/fancytree.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">

@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Ürün Ekle </h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/products')}}" class="btn btn-block btn-default btn-rounded">← Ürünler</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">

                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="box-title m-b-15">Ürün Ekle</h3>
                            </div>
                            <div class="col-md-9 text-right">
                                <button type="button" onclick="$.formSubmit('product_form');" class="btn btn-success"> <i class="fa fa-check"></i> Ürünü Ekle</button>
                            </div>
                        </div>

                        <form method="post" id="product_form" action="{{url('admin/products/create')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Genel</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Açıklama</span></a></li>
                                <li role="presentation" class=""><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">SEO</span></a></li>
                                <li role="presentation" class=""><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Veri</span></a></li>
                                <li role="presentation" class=""><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Bağlantı</span></a></li>
                                <li role="presentation" class="tab-disable"><a href="#tab6" aria-controls="tab6" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">İlgili Ürünler</span></a></li>
                                <li role="presentation" class="tab-disable"><a href="#tab7" aria-controls="tab7" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Resimler</span></a></li>
                                <li role="presentation" class="tab-disable"><a href="#tab8" aria-controls="tab8" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Varyasyonlar</span></a></li>
                                <li role="presentation" class="tab-disable"><a href="#tab9" aria-controls="tab9" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Özellikler</span></a></li>
                                <li role="presentation" class="tab-disable"><a href="#tab10" aria-controls="tab10" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Filtreler</span></a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1" selected="selected">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="name" class="col-sm-2 control-label">Ürün Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_code" class="col-sm-2 control-label">Stok Kodu</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="stock_code" id="stock_code" value="">
                                            <span class="help-block">Ürün stok kodlarını genel ayarlar üzerinden otomatik veya manuel olarak girilmesi için ayarlayabilirsiniz.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="barcode" class="col-sm-2 control-label">Barkod</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="barcode" id="barcode" value="">
                                            <span class="help-block">Ürüne ait bir barkod kodu mevcut değilse boş bırakınız</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_id" class="col-sm-2 control-label">Marka</label>
                                        <div class="col-sm-3">
                                            <select name="brand_id" id="brand_id" class="brand-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                        <div class="col-sm-1 add_attr">
                                            <a id="add_brand" data-toggle="modal" data-target="#brand-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-2 control-label">Tedarikçi</label>
                                        <div class="col-sm-3">
                                            <select name="supplier_id" class="supplier-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="short_desc" class="col-sm-2 control-label">Kısa Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="short_desc" style="height: 140px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea class="form-control editor"  name="description" style="height: 140px; visibility: hidden; display: none;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab3">
                                    <div class="form-group " id="slug_form_group">
                                        <label for="slug" class="col-sm-2 control-label">Ürün Adresi</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control slug" name="slug" id="slug" value="">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button" onclick="$.slugControl()"><i class="glyphicon glyphicon-search"></i> KONTROL ET</button>
                                                </div>
                                            </div>
                                            <span class="help-block">Ürün adresini kişileştirmek istiyorsanız özel url kullanımını aktif ederek yazdığınız değeri kullanabilirsiniz.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="custom_url" class="col-sm-2 control-label">Özel URL Kullan</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="custom_url" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_title" class="col-sm-2 control-label">SEO Başlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_description" class="col-sm-2 control-label">Meta Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="seo_description" id="seo_description" style="height: 140px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_keywords" class="col-sm-2 control-label">Anahtar Kelimeler</label>
                                        <div class="col-sm-10">

                                            <input name="seo_keywords" id="seo_keywords" data-role="tagsinput" style="display:none;">
                                            <div class="input-group" style="margin-top:10px;">
                                                <div class="input-group-addon">Etiket Arama</div>

                                                <input type="text" class="form-control" name="seo_tags" id="seo_tags" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab4">
                                    <h3 class="box-title">Fiyat Bilgisi</h3>
                                    <div class="form-group ">
                                        <label for="price" class="col-sm-2 control-label">Fiyat</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="price" id="price" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="currency1" class="currency-ajax select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option value="1" selected="selected">Türk Lirası</option>
                                            </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-currency1-oj-container"><span class="select2-selection__rendered" id="select2-currency1-oj-container" title="Türk Lirası">Türk Lirası</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="price" class="col-sm-2 control-label">Maliyet</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="costprice" id="costprice" value="">
                                        </div>
                                    </div>
                                    <h3 class="box-title">İndirim Detayları</h3>
                                    <div class="form-group">
                                            <label for="date1" class="col-sm-2 control-label">İndirim Tarihleri</label>
                                            <div class="col-sm-6">
                                                <div class="input-daterange input-group">
                                                    <input placeholder="gün-ay-yıl" type="text" class="form-control datepickerstart" name="discountstartdate" id="discountstartdate" value="">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input placeholder="gün-ay-yıl" type="text" class="form-control datepickerfinish" name="discountfinishdate" id="discountfinishdate" value="">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="discount_type" class="col-sm-2 control-label">İndirim Türü</label>
                                        <div class="col-sm-2">
                                            <select name="discount_type" id="discount_type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="0" selected="selected">İndirim Yok</option>
                                                <option value="1">Yüzdeli İndirim (%)</option>
                                                <option value="2">İndirimli Fiyat</option>
                                                <?php /*<option value="3">İndirim Oranı</option>*/?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="discount" class="col-sm-2 control-label">İndirim</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="discount" id="discount" value="">
                                        </div>
                                    </div>

                                    <h3 class="box-title">Vergi Bilgisi</h3>
                                    <div class="form-group">
                                        <label for="tax_id" class="col-sm-2 control-label">KDV Oranı</label>
                                        <div class="col-sm-10">
                                            <select name="tax_id" id="tax_id" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-live-search="true" data-style="form-control" data-width="100%">
                                                <option class="bs-title-option" value="0">Seçiniz</option>
                                                <option value="18">KDV TR 18%</option>
                                                <option value="8">KDV TR 8%</option>
                                                <option value="1">KDV TR 1%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="vat_inclusive" class="col-sm-2 control-label">KDV Dahil</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="vat_inclusive" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Kargo Detayları</h3>
                                    <div class="form-group">
                                        <label for="cargo_weight" class="col-sm-2 control-label">Kargo Ağırlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="cargo_weight" id="cargo_weight" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="use_system" class="col-sm-2 control-label">Sistem</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="use_system" checked value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_price" class="col-sm-2 control-label">Kargo Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" disabled name="shipping_price" id="shipping_price" value="">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Stok Detayları</h3>
                                    <div class="form-group">
                                        <label for="stock" class="col-sm-2 control-label">Stok</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="stock" id="stock" value="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <select name="stock_type" id="stock_type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1" selected="selected">Adet</option>
                                                <option value="2">Cm</option>
                                                <option value="3">Düzine</option>
                                                <option value="4">Gram</option>
                                                <option value="5">Kg</option>
                                                <option value="6">Kişi</option>
                                                <option value="7">Paket</option>
                                                <option value="8">Metre</option>
                                                <option value="9">m2</option>
                                                <option value="10">Çift</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h3 class="box-title">Diğer</h3>

                                    <div class="form-group">
                                        <label for="package" class="col-sm-2 control-label">Paket Ürün (Fiyat/Adet)</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="package" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div id="packageCount" class="form-group"  style="display:none">
                                        <label for="packageCount" class="col-sm-2 control-label">Paket Adeti</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="packageCount" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="maximum" class="col-sm-2 control-label">Maksimum sipariş adeti</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="maximum" id="guarantee_term" value="">
                                        </div>
                                    </div>
                                    <?php /*
                                    <div class="form-group">
                                        <label for="guarantee_term" class="col-sm-2 control-label">Garanti Süresi</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="guarantee_term" id="guarantee_term" value="2">
                                        </div>
                                    </div>
                                    */ ?>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab5">
                                    <div class="form-group ">
                                        <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="categories" name="categories" value="">
                                            <div id="tree">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="s_new" class="col-sm-2 control-label">Yeni Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" checked="" name="s_new" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_showcase" class="col-sm-2 control-label">Vitrin Ürünü</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_showcase" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_category" class="col-sm-2 control-label">Kategori Vitrini</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_category" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_brand" class="col-sm-2 control-label">Marka Vitrini</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_brand" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_campaign" class="col-sm-2 control-label">Kampanyalı Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_campaign" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_sell" class="col-sm-2 control-label">Çok Satan Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_sell" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_sponsor" class="col-sm-2 control-label">Sponsor Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_sponsor" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_popular" class="col-sm-2 control-label">Popüler Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="s_popular" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>


                        <div id="brand-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_brand" name="addBrand" method="POST" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Marka Ekle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="brand_name" class="col-sm-2 control-label">Başlık</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="brand_name" id="brand_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="code" class="col-sm-2 control-label">Kodu</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="code" id="code" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="brand_order" class="col-sm-2 control-label">Sıra</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="brand_order" id="brand_order" value="999">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="$.addBrand()">Ekle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="pmodel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_model" onsubmit="return false" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Model Ekle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Başlık</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="order" class="col-sm-2 control-label">Sıra</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="order" id="order" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="$.addModel()">Ekle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="ptag-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_tag" onsubmit="return false" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Etiket Ekle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Başlık</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="$.addTag()">Ekle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php /*
            <div class="col-lg-12 col-sm-6 col-xs-12">
                <div class="white-box">
                    <!-- Nav tabs -->
                    <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Home</span></a></li>
                        <li role="presentation" class=""><a href="#profile1" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Profile</span></a></li>
                        <li role="presentation" class=""><a href="#messages1" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Messages</span></a></li>
                        <li role="presentation" class=""><a href="#settings1" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Settings</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="home1">
                            <div class="col-md-6">
                                <h3>Best Clean Tab ever</h3>
                                <h4>you can use it with the small code</h4>
                            </div>
                            <div class="col-md-5 pull-right">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="profile1">
                            <div class="col-md-6">
                                <h3>Lets check profile</h3>
                                <h4>you can use it with the small code</h4>
                            </div>
                            <div class="col-md-5 pull-right">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="messages1">
                            <div class="col-md-6">
                                <h3>Come on you have a lot message</h3>
                                <h4>you can use it with the small code</h4>
                            </div>
                            <div class="col-md-5 pull-right">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="settings1">
                            <div class="col-md-6">
                                <h3>Just do Settings</h3>
                                <h4>you can use it with the small code</h4>
                            </div>
                            <div class="col-md-5 pull-right">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/jquery/dist/jquery-ui.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/fancytree/fancytree-all.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/tr.js"></script>

    <script>
        $(document).ready(function () {
         

            $('.datepickerstart').datetimepicker({
                format: "DD-MM-YYYY HH:mm:ss",
                  useSeconds: true,
                  autoclose: true,
                  language: 'tr',
            });
            $('.datepickerstart').val(moment('2020-01-10 00:00:00').format('DD-MM-YYYY HH:mm:ss'))

            $('.datepickerfinish').datetimepicker({
                format: "DD-MM-YYYY HH:mm:ss",
                  useSeconds: true,
                  autoclose: true,
                  language: 'tr',
            });
            $('.datepickerfinish').val(moment('2022-12-31 00:00:00').format('DD-MM-YYYY HH:mm:ss'))
            
        });

        $("input[name=use_system]").on("change",function () {
            if($(this).is(':checked')){
                $("#shipping_price").prop('disabled',true);
            }else{
                $("#shipping_price").prop('disabled', false);
            }
        });

        $("input[name=package]").on("change",function () {
            if($(this).is(':checked')){
                $("#packageCount").slideDown();
            }else{
                $("#packageCount").slideUp();
            }
        });

        function matchResults(results){
            var arr = [];
            for (x in results[1]) {
                if(results[1][x][0].length<=50){
                    arr.push({id:results[1][x][0],name:results[1][x][0]});
                }
            }
            return arr;
        }

        $.formSubmit = function(form_id) {
            $("#categories").appendTo("#product_form");
            document.getElementById(form_id).submit();
        };

        // Brand Ajax
        $(".brand-ajax").select2({
            language: "tr",
            ajax: {
                url: "{{url('admin/brands/ajax/list')}}",
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return { id: item.id, text: item.name };
                        }),
                        pagination: {
                            more: (params.page * 15) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Marka Seçiniz',
        });

        // Supplier Ajax
        $(".supplier-ajax").select2({
            language: "tr",
            ajax: {
                url: "admin/suppliers/ajax/list",
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return { id: item.id, text: item.s_name };
                        }),
                        pagination: {
                            more: (params.page * 15) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Tedarikçi Seçiniz',
        });

        $("#tree").fancytree({
            source: {
                url: "{{url('admin/categories/nestable')}}"
            },
            checkbox: true,
            selectMode: 2,
            clickFolderMode: 2,
            minExpandLevel : 1,
            select: function(event, data) {
                var node = data.node;
                //console.log(node.getSelectedNodes());
                if (node.isSelected()==false){
                    console.log();
                    $.map(node.getSelectedNodes(), function(selNode){
                        selNode.setSelected(false);
                        console.log(selNode);
                    });
                    node.setSelected(false);
                }
                /*node.visit(function (childNode) {
                    console.log(childNode);
                });*/
                var selKeys = $.map(data.tree.getSelectedNodes(), function(node){
                    return node.data.id;
                });

                $('#categories').val(selKeys.join(","));
                if (node.parent!=null) {
                    node.parent.setSelected(true);
                }

            },
            dblclick: function(event, data) {
                data.node.toggleSelected();
            },
            childcounter: {
                deep: true,
                hideZeros: true,
                hideExpanded: true
            }
        });

        $.addBrand = function(){

            $.ajax({
                url: "{{url('admin/brands/createshort')}}",
                type:'POST',
                data: 'name='+$('#brand_name').val()+'&code='+$('#code').val()+'&sort='+$('#brand_order').val()+'&_token='+$('meta[name=_token]').attr("content"),
                dataType: "json",
                success: function(response){
                    if (response.status==200) {
                        $('#brand-modal').modal('toggle');
                    }else{
                        alert(response.message);
                    }

                }
            });

        }




        $("#seo_tags").tokenInput("https://www.google.com.tr/s?hl=tr&cp=1&gs_ri=psy-ab&xhr=t&pf=p&site=&source=hp", {
            hintText: "Etiket Giriniz..",
            noResultsText: "Sonuç Yok",
            searchTitle: "Etiket Ara",
            searchingText: "Aranıyor...",
            method: "GET",
            queryParam: "q",
            contentType: "jsonp",
            onResult: matchResults,
            tokenLimit: 10,
            tokenCount: 0,
            minChars: 2,
            unique: true,
            searchDelay: 250,
            onAdd: function (item) {
                $('#seo_keywords').tagsinput('add', strip_tags(item.id));
                $(".token-input-token").remove();
            }
        });
    </script>
@endsection
