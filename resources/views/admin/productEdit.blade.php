
@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/fancytree/fancytree.min.css')}}" rel="stylesheet">
    <link href="{{asset('src/admin/plugins/bower_components/dropzone-master/dist/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
    <link href="{{asset('src/admin/plugins/bower_components/multiple-select/multiple-select.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">


@endsection
@section('content')
@inject('helpersnew', 'App\Helpers\HelpersNew')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Ürün Düzenle</h4>
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
                                <h3 class="box-title m-b-15">Ürün Düzenle</h3>
                            </div>
                            <div class="col-md-9 text-right">
                                <button type="button" onclick="$.formSubmit('product_form');" class="btn btn-success"> <i class="fa fa-check"></i> Ürünü Güncelle</button>
                            </div>
                        </div>

                        <form method="post" id="product_form" action="{{url('admin/products/update/'.$data->id)}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Genel</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Açıklama</span></a></li>
                                <li role="presentation" class=""><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">SEO</span></a></li>
                                <li role="presentation" class=""><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Veri</span></a></li>
                                <li role="presentation" class=""><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Bağlantı</span></a></li>
                                <li role="presentation" class=""><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">İlgili Ürünler</span></a></li>
                                <li role="presentation" class=""><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Resimler</span></a></li>
                                <li role="presentation" class=""><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Varyasyonlar</span></a></li>
                                <li role="presentation" class=""><a href="#tab9" aria-controls="tab9" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Özellikler</span></a></li>
                                <?php /* <li role="presentation" class=""><a href="#tab10" aria-controls="tab10" role="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Filtreler</span></a></li> */ ?>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="status" id="status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1" {{$data->status== 1 ? 'selected="selected"' : ""}} >Aktif</option>
                                                <option value="0" {{$data->status== 0 ? 'selected="selected"' : ""}} >Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="name" class="col-sm-2 control-label">Ürün Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_code" class="col-sm-2 control-label">Stok Kodu</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"  @if($helpersnew->codeControl($data->stock_code) == true ) style="color:red!important;font-weight:bold;" @else  @endif name="stock_code" id="stock_code" value="{{$data->stock_code}}">
                                            <span class="help-block">Ürün stok kodlarını genel ayarlar üzerinden otomatik veya manuel olarak girilmesi için ayarlayabilirsiniz.</span>
                                            @if($helpersnew->codeControl($data->stock_code) == true ) <span  style="color:red!important;font-weight:bold;"   class="help-block">Bu Stok kodu başka üründe kullanılıyor lütfen kontrol ediniz.</span>@else @endif 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="barcode" class="col-sm-2 control-label">Barkod</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="barcode" id="barcode" value="{{$data->barcode}}">
                                            <span class="help-block">Ürüne ait bir barkod kodu mevcut değilse boş bırakınız</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_id" class="col-sm-2 control-label">Marka</label>
                                        <div class="col-sm-3">
                                            <select name="brand_id" id="brand_id" class="brand-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                                <option selected="selected" value="{{@$data->brand_name->id}}">{{@$data->brand_name->name}}</option>
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
                                        <div class="col-sm-1 add_attr">
                                            <a id="add_supplier" data-toggle="modal" data-target="#supplier-modal"><i class="fa fa-plus-circle fa-2x"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_desc" class="col-sm-2 control-label">Kısa Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor" name="short_desc" style="height: 140px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea class="form-control editor"  name="description" style="height: 140px; visibility: hidden; display: none;">{{$data->content}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab3">
                                    <div class="form-group " id="slug_form_group">
                                        <label for="slug" class="col-sm-2 control-label">Ürün Adresi</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control slug" name="slug" id="slug" value="{{$data->slug}}">
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
                                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{@json_decode(@$data->seo)->seo_title}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="seo_description" class="col-sm-2 control-label">Meta Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="seo_description" id="seo_description" style="height: 140px;">{{@json_decode(@$data->seo)->seo_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_keywords" class="col-sm-2 control-label">Anahtar Kelimeler</label>
                                        <div class="col-sm-10">

                                            <input name="seo_keywords" id="seo_keywords" data-role="tagsinput" value="{{@json_decode(@$data->seo)->seo_keywords}}" style="display:none;">
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
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="price" id="price" value="{{$data->price}}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="price" class="col-sm-2 control-label">Maliyet</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="costprice" id="costprice" value="{{$data->costprice}}">
                                        </div>
                                    </div>

                                    <h3 class="box-title">İndirim Detayları</h3>
                                    <div class="form-group">
                                            <label for="date1" class="col-sm-2 control-label">İndirim Tarihleri</label>
                                            <div class="col-sm-6">
                                                <div class="input-daterange input-group">
                                                    <input placeholder="gün-ay-yıl" type="text" class="form-control datepickerstart" name="discountstartdate" id="discountstartdate">
                                                    <span class="input-group-addon bg-default b-0">ve</span>
                                                    <input placeholder="gün-ay-yıl" type="text" class="form-control datepickerfinish" name="discountfinishdate" id="discountfinishdate">
                                                </div>
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="discount_type" class="col-sm-2 control-label">İndirim Türü</label>
                                        <div class="col-sm-2">
                                            <select name="discount_type" id="discount_type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="0" {{$data->discount_type == "0" ? 'selected="selected"' : ''}} >İndirim Yok</option>
                                                <option value="1" {{$data->discount_type == "1" ? 'selected="selected"' : ''}} >Yüzdeli İndirim (%)</option>
                                                <option value="2" {{$data->discount_type == "2" ? 'selected="selected"' : ''}} >İndirimli Fiyat</option>
                                                <?php /*<option value="3" {{$data->discount_type == "3" ? 'selected="selected"' : ''}} >İndirim Oranı</option>*/ ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="discount" class="col-sm-2 control-label">İndirim</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" @if($helpersnew->discountControl($data->discount_start_date,$data->discount_finish_date,$data->discount_type) == true ) style="color:red!important;font-weight:bold;" @else  @endif name="discount" id="discount" value="{{$data->discount}}">
                                        </div>
                                    </div>

                                    <h3 class="box-title">Vergi Bilgisi</h3>
                                    <div class="form-group">
                                        <label for="tax_id" class="col-sm-2 control-label">KDV Oranı</label>
                                        <div class="col-sm-10">
                                            <select name="tax_id" id="tax_id" class="selectpicker show-tick bs-select-hidden" title="Seçiniz" data-live-search="true" data-style="form-control" data-width="100%">
                                                <option class="bs-title-option" value="0">Seçiniz</option>
                                                <option {{$data->tax == 18 ? 'selected="selected"' : "" }} value="18">KDV TR 18%</option>
                                                <option {{$data->tax == 8  ? 'selected="selected"' : "" }} value="8">KDV TR 8%</option>
                                                <option {{$data->tax == 1  ? 'selected="selected"' : "" }} value="1">KDV TR 1%</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="vat_inclusive" class="col-sm-2 control-label">KDV Dahil</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->tax_status == 1 ? 'checked' : '' }} name="vat_inclusive" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Kargo Detayları</h3>
                                    <div class="form-group">
                                        <label for="cargo_weight" class="col-sm-2 control-label">Kargo Ağırlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="cargo_weight" id="cargo_weight" value="{{@$data->shippings->desi}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="use_system" class="col-sm-2 control-label">Sistem</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{@$data->shippings->use_system == 1 ? 'checked' : ''}} name="use_system" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_price" class="col-sm-2 control-label">Kargo Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input type="text" {{@$data->shippings->use_system == 1 ? 'disabled' : '' }} class="form-control" name="shipping_price" id="shipping_price" value="{{@$data->shippings->shipping_price}}">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Stok Detayları</h3>
                                    <div class="form-group">
                                        <label for="stock" class="col-sm-2 control-label">Stok</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="stock" id="stock" value="{{$data->stock}}">
                                        </div>

                                        <div class="col-sm-2">
                                            <select name="stock_type" id="stock_type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{$data->stock_type == 1  ? 'selected="selected"' : '' }} value="1">Adet</option>
                                                <option {{$data->stock_type == 2  ? 'selected="selected"' : '' }} value="2">Cm</option>
                                                <option {{$data->stock_type == 3  ? 'selected="selected"' : '' }} value="3">Düzine</option>
                                                <option {{$data->stock_type == 4  ? 'selected="selected"' : '' }} value="4">Gram</option>
                                                <option {{$data->stock_type == 5  ? 'selected="selected"' : '' }} value="5">Kg</option>
                                                <option {{$data->stock_type == 6  ? 'selected="selected"' : '' }} value="6">Kişi</option>
                                                <option {{$data->stock_type == 7  ? 'selected="selected"' : '' }} value="7">Paket</option>
                                                <option {{$data->stock_type == 8  ? 'selected="selected"' : '' }} value="8">Metre</option>
                                                <option {{$data->stock_type == 9  ? 'selected="selected"' : '' }} value="9">m2</option>
                                                <option {{$data->stock_type == 10 ? 'selected="selected"' : '' }} value="10">Çift</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h3 class="box-title">Diğer</h3>

                                    <div class="form-group">
                                        <label for="package" class="col-sm-2 control-label">Paket Ürün (Fiyat/Adet)</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{@$data->package > 0 ? 'checked' : ''}} name="package" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div id="packageCount" class="form-group" {{$data->package <= 0 ? 'style=display:none;' : '' }}>
                                        <label for="packageCount" class="col-sm-2 control-label">Paket Adeti</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="packageCount" value="{{$data->package}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="maximum" class="col-sm-2 control-label">Maksimum sipariş adeti</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="maximum" id="guarantee_term" value="{{$data->maximum == null ? '': $data->maximum}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="package" class="col-sm-2 control-label">Toptan Fiyat İste Formu</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{@$data->wholesale > 0 ? 'checked' : ''}} name="wholesale" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <?php /*
                                    <div class="form-group">
                                        <label for="guarantee_term" class="col-sm-2 control-label">Garanti Süresi</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="guarantee_term" id="guarantee_term" value="">
                                        </div>
                                    </div>
                                    */ ?>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab5">
                                    <div class="form-group ">
                                        <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="categories" name="categories" value="{{ $selectedCategoryIds }}">
                                            <div id="tree">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="s_new" class="col-sm-2 control-label">Yeni Ürün</label>
                                        <div class="col-sm-2">

                                            <input type="checkbox" {{$data->newSort ? 'checked=""' : ''}} name="s_new" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_showcase" class="col-sm-2 control-label">Vitrin Ürünü</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->showcase ? 'checked=""' : ''}} name="s_showcase" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_category" class="col-sm-2 control-label">Kategori Vitrini</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{count($data->categorySort) > 0 ? 'checked=""' : ''}} name="s_category" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_brand" class="col-sm-2 control-label">Marka Vitrini</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->brandSort ? 'checked=""' : ''}} name="s_brand" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_campaign" class="col-sm-2 control-label">Kampanyalı Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->campaignSort ? 'checked=""' : ''}} name="s_campaign" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_sell" class="col-sm-2 control-label">Çok Satan Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->sellSort ? 'checked=""' : ''}} name="s_sell" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_sponsor" class="col-sm-2 control-label">Sponsor Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->sponsorSort ? 'checked=""' : ''}} name="s_sponsor" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_popular" class="col-sm-2 control-label">Popüler Ürün</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" {{$data->popularSort ? 'checked=""' : ''}} name="s_popular" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select name="relatedProductAjax" id="relatedProductAjax" class="relatedProducts-ajax" tabindex="-1" style="display: none; width: 100%">
                                            </select>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th width="30%">Ürün</th>
                                            <?php /*<th>Kategori</th>*/ ?>
                                            <th>Marka</th>
                                            <th>Satış Fiyatı</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody id="relatedProductsDiv">

                                            @foreach($data->relateds as $related)
                                                <tr id="relatedp_{{$related->id}}">
                                                    <td><input type="hidden" name="relateds[]" value="{{$related->id}}"><a href="#">{{$related->id}}</a></td>
                                                    <td>{{@$related->name}}</td>
                                                    <?php /* <td>En Yeniler</td> */ ?>
                                                    <td>{{@$related->brand->name}}</td>
                                                    <td>{{$related->final_price}}</td>
                                                    <td><button type='button' class='btn btn-danger waves-effect waves-light' onclick="$.deleteDivFromId('relatedp_{{$related->id}}')"><i class='fa fa-close'></i> Sil</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab7">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="dropzone dz-clickable" id="myDropzone">
                                                <div class="dz-default dz-message" data-dz-message="">
                                                    <span>Resim yüklemek için sürükleyin veya seçin.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                    <ul id="productImages">
                                        @if(!empty($data->image))
                                            @foreach($data->image as $key => $value)
                                                <li class="sortableLi ui-state-default" id="pimage_{{$key}}">
                                                    <a class="btn btn-danger btn-sm imageDeleteBtn" onclick="$.pImageDelete({{$key}})">KALDIR</a>
                                                    <a>
                                                        <img id="" src="{{ getCdnMinImage($data->id, $value) }}">
                                                    </a>
                                                    <div class="sira">
                                                        <span class="label label-info">{{$key}}. Resim</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab8">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select name="variantGroupAjax" id="variantGroupAjax" class="variantGroups-ajax select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%;" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div id="vGroupAjax">
                                        <?php $say=0; ?>

                                        @if(isset($data->variantGroup))
                                            @foreach($data->variantGroup as $group)
                                                <div class="col-md-3" id="vgroup-{{$group->id}}">
                                                    <div class="variant-list">
                                                        <div class="variant-box">
                                                            <div class="form-group">
                                                                <input type="hidden" name="variantGroups[]" value="{{$group->id}}">
                                                                <label for="s_brand" class="col-sm-5 control-label text-center">{{$group->name}}</label>
                                                                <div class="col-sm-7">
                                                                    <select id="variant-1" data-group-id="1" class="variantMultiple" multiple="multiple" style="display: none;">
                                                                        <?php $say2=0; ?>
                                                                        @foreach($data->variantValues[$say] as $valu)
                                                                            {{$data->variantValues[$say][0]}}
                                                                            <?php if(in_array($valu->id, $data->selectedVar)){
                                                                                $selected="selected='selected'";
                                                                            }else{
                                                                                $selected="";
                                                                            } ?>
                                                                            <option value="{{$valu->id}}" {{$selected}}>{{$valu->value}}</option>
                                                                            <?php $say2++; ?>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="variant-options">
                                                                <div class="option-list-1">

                                                                    @foreach($data->variantValues[$say] as $allValue)
                                                                        @if(in_array($allValue->id, $data->selectedVar))
                                                                        <div class="variantListRow mB5 clearfix" data-variant-id="{{$allValue->id}}" data-group-id="{{$say}}">
                                                                            <input type="hidden" name="variant_values[]" value="1">
                                                                            <input type="hidden" class="varyant_id" value="{{$allValue->id}}">
                                                                            <div class="col-md-10 text-left">{{$allValue->value}}</div>
                                                                            <div class="col-md-2 text-right">
                                                                                <a href="javascript:;" data-toggle="modal" data-target="#Image1-modal"><i class="fa fa-image"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-default" style="width:100px" data-toggle="modal" data-target="#1-modal"><i class="fa fa-wrench"></i> Ayarlar</button>
                                                            <button type="button" class="btn btn-danger" style="width:100px" onclick="$.deleteDivFromId('vgroup-{{$group->id}}')"><i class="fa fa-close"></i> Sil</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $say++; ?>
                                            @endforeach
                                        @endif

                                        <div id="1-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Varyasyon Grubu Ayarları</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="radio_1'" class="col-sm-4 control-label">Ana Varyant Grubu</label>
                                                            <div class="col-sm-8">
                                                                <div class="radio radio-custom">
                                                                    <input type="radio" name="main_variant" class="main_variant" id="radio_1'" value="1'">
                                                                    <label for="radio_1'">Seç</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:10px;">
                                                                Eğer bu seçeneği işaretlerseniz, ürün parçalara bölünürken bu varyant grubu baz alınarak bölünür. Bu grupla eşleşmiş olan varyantlar tekli varyant olarak eklenir.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="Image1-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Varyasyon Resimleri</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="margin-bottom:10px; margin-top:20px;">
                                        <button type="button" id="create-variants" class="btn btn-default"><i class="fa fa-refresh"></i> Varyasyon Güncelle</button>
                                        <button type="button" id="variants-options" class="btn btn-default" data-toggle="modal" data-target="#variant-options-modal"><i class="fa fa-cogs"></i> Varyasyon Ayarları</button>
                                        <div id="variant-options-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Varyasyon Ayarları</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="variant_stock_update" class="col-sm-4 control-label" style="text-align:left!important;">Ana Stok Güncelleme</label>
                                                            <div class="col-sm-8">
                                                                <input type="checkbox" checked="" name="variant_stock_update" id="variant_stock_update" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:10px;">
                                                                Ana stok güncelleme işaretlendiği zaman eklenen varyasyon stoklarına göre ana ürün stoğu sistem tarafından otomatik olarak güncellenir.
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="variant_product_cut" class="col-sm-4 control-label" style="text-align:left!important;">Ürün Parçalama İşlemi</label>
                                                            <div class="col-sm-8">
                                                                <input type="checkbox" name="variant_product_cut" id="variant_product_cut" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:10px;">
                                                                Ana varyasyona göre ürünü parçalamak istiyorsanız önce bu kısımdan ürün parçalama seçeneği aktif edip, varyasyon ayarından ana varyasyonu seçiniz.
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="variant_main_product" class="col-sm-4 control-label" style="text-align:left!important;">Ana Ürün Kaldırma</label>
                                                            <div class="col-sm-8">
                                                                <input type="checkbox" name="variant_main_product" id="variant_main_product" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:10px;">
                                                                Ürün parçalama işlemi yapmadan önce, ana ürün kaldırmayı aktifleştirirseniz mevcut ürün kaldırılarak varyasyonlara göre ürünler oluşturulur. Eğer aktif değilse, ana ürün silinmez varyasyonlar alt ürün olarak eklenir ve birbirleriyle ilişkilendirilir.
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="variant_combination" class="col-sm-4 control-label" style="text-align:left!important;">Kombinasyon İşlemi</label>
                                                            <div class="col-sm-8">
                                                                <input type="checkbox" checked="" name="variant_combination" id="variant_combination" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;"><span class="switchery switchery-default" style="background-color: rgb(79, 84, 103); border-color: rgb(79, 84, 103); box-shadow: rgb(79, 84, 103) 0px 0px 0px 0px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;"><small style="left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s, left 0.2s;"></small></span>
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:10px;">
                                                                Varyasyonları kendi aralarında kombinasyonlamak istiyorsanız aktifleştirin.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="variant-table">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="%40">Varyant Adı</th>
                                                <th width="%5">Stok</th>
                                                <th width="%15">Fiyat</th>
                                                <th width="%5">Fiyat Değeri</th>
                                                <th width="%5">Ağırlık</th>
                                                <th width="%5">Ağırlık Türü</th>
                                                <th width="%5">Ağırlık Değeri</th>
                                            </tr>
                                            </thead>
                                            <tbody id="variant-table-list">
                                            @if(isset($data->variants))
                                            @foreach($data->variants as $qq)
                                                <tr id="{{$qq->id}}">
                                                    <input type="hidden" name="variants[{{$qq->id}}][name]" value="{{$qq->name}}">
                                                    <input type="hidden" name="variants[{{$qq->id}}][values]" value="{{$qq->vals}}">
                                                    <input type="hidden" name="variants[{{$qq->id}}][stock_code]" value="">
                                                    <td>{{$qq->name}}</td>
                                                    <td><input type="text" name="variants[{{$qq->id}}][stock]" class="form-control" value="{{$qq->stock}}"></td>
                                                    <td><input type="text" name="variants[{{$qq->id}}][price]" class="form-control" value="0.0000"></td>
                                                    <td>
                                                        <select name="variants[{{$qq->id}}][price_value]" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                            <option value="1" selected="selected">Artı</option>
                                                            <option value="2">Eksi</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="variants[{{$qq->id}}][weight]" class="form-control" value="0"></td>
                                                    <td>
                                                        <select class="selectpicker show-tick bs-select-hidden" name="variants[{{$qq->id}}][weight_type]" data-style="form-control" data-width="100%">
                                                            <option value="1" selected="selected">Artı</option>
                                                            <option value="2">Eksi</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="selectpicker show-tick bs-select-hidden" name="variants[{{$qq->id}}][weight_value]" data-style="form-control" data-width="100%">
                                                            <option value="1" selected="selected">Kg</option>
                                                            <option value="2">Gr</option>
                                                            <option value="3">Desi</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab9">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select name="attributeGroupAjax" id="attributeGroupAjax" class="attributeGroups-ajax" tabindex="-1" style="display: none; width: 100%">
                                            </select>
                                        </div>
                                    </div>
                                    <div id="ajaxGroups">
                                        @if(!empty($data->attrGroups))
                                            @foreach($data->attrGroups as $grp)
                                                <div class="col-md-3"  id="group-{{$grp->id}}">
                                                    <div class="group-list">
                                                        <div class="group-box">
                                                            <div class="form-group">
                                                                <label for="s_brand" class="col-sm-5 control-label text-center">{{$grp->name}}</label>

                                                                <div class="col-sm-7">
                                                                    <select id="atgroup-{{$grp->id}}" multiple="multiple" class="attributeMultiple" data-group-id="{{$grp->id}}" style="display: none;">

                                                                        @foreach($grp->attributes as $att)
                                                                            <?php
                                                                            if(in_array($att->id,$data->attr)){
                                                                                $selectedd="selected='selected'";
                                                                            }else{
                                                                                $selectedd="";
                                                                            } ?>

                                                                            <option value="{{$att->id}}" {{$selectedd}}>{{$att->name}}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="group-options">
                                                                <div class="aoption-list-{{$grp->id}}">

                                                                    @foreach($grp->attributes as $att)

                                                                        @if(in_array($att->id, $data->attr ))
                                                                            <div class="attributeListRow clearfix" data-attribute-id="{{$att->id}}" data-group-id="">
                                                                                <input type="hidden" name="attributes[{{$att->id}}][group_id]" value="{{$grp->id}}">
                                                                                <input type="hidden" name="attributes[{{$att->id}}][id]" value="{{$att->id}}">
                                                                                <div class="col-md-6 text-left">{{$att->name}}</div>
                                                                                <div class="col-md-6 text-right">
                                                                                    <select name="attributes[{{$att->id}}][value_id]" class="selectpicker show-tick" data-style="form-control" data-width="100%">
                                                                                        @foreach($att->values as $valu)
                                                                                            <?php if(in_array($valu->id, $data->selectedVal )){
                                                                                                $selectedVal="selected";
                                                                                            }else{
                                                                                                $selectedVal="";
                                                                                            } ?>
                                                                                            <option {{$selectedVal}} value="{{$valu->id}}">{{$valu->value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                            <button type='button' class='btn btn-danger' style='width:100px' onclick="$.deleteDivFromId('group-{{$grp->id}}')"><i class='fa fa-close'></i> Sil</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>

                        <div id="supplier-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="supplierLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_supplier" onsubmit="return false" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Tedarikçi Ekle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="s_name" class="col-sm-3 control-label">Tedarikçi Adı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="s_name" id="s_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Yetkili Kişi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="col-sm-3 control-label">Telefon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="phone" id="phone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-3 control-label">E-Posta</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email" id="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="$.addSupplier()">Ekle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="brand-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_brand" onsubmit="return false" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Marka Ekle</h4>
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
                                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="$.addBrand()">Ekle</button>
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
    <script src="{{asset('src/admin/plugins/bower_components/dropzone-master/dist/dropzone.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script src="{{asset('src/admin/plugins/bower_components/multiple-select/multiple-select.js')}}"></script>
    
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
            $('.datepickerstart').val(moment('{{$data->discount_start_date}}').format('DD-MM-YYYY HH:mm:ss'))

            $('.datepickerfinish').datetimepicker({
                format: "DD-MM-YYYY HH:mm:ss",
                  useSeconds: true,
                  autoclose: true,
                  language: 'tr',
            });
            $('.datepickerfinish').val(moment('{{$data->discount_finish_date}}').format('DD-MM-YYYY HH:mm:ss'))
            
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

        $("#productImages").sortable({
            axis: "x",
            start: function(event, ui) {
                start = ui.item.prevAll().length + 1;
            },
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                data=data+"&id={{$data->id}}";
                console.log(data);
                $.ajax({
                    data: data,
                    type: 'GET',
                    url: '{{url("admin/products/imageSorting")}}'
                });
            },
            stop: function( event, ui ) {
                sirala();
            }
        });

        $('#productImages').disableSelection();

        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("div#myDropzone", {
            url: "{{url('admin/products/imageUpload?id='.$data->id.'')}}",
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        },previewsContainer: '#productImages',
        params:{
                "name": "{{$data->slug}}"
            }
        });

        myDropzone.previewsContainer = null;

        myDropzone.on("success", function(file, response) {
            //response='{"success":200,"filename":"http:\/\/185.22.186.112\/upload\/product\/cicekli-abiye-elbise-0164-murdum-58906cce1d980.png","type":"5. Resim","id":15835}';
            obj = JSON.parse(response);
            $("#productImages").append('<li class="sortableLi ui-state-default" id="pimage_'+obj.id+'"><a class="btn btn-danger btn-sm imageDeleteBtn" onclick="$.pImageDelete('+obj.id+')">KALDIR</a><a><img src="'+obj.filename+'"></a><div class="sira"><span class="label label-info">'+obj.type+'</span></div></li>');
        });
        myDropzone.on("processing", function(file, xhr, formData) {
            HoldOn.open({
                theme:"sk-bounce",
                message: "Yükleniyor..."
            });
        });
        myDropzone.on("complete", function(){
            HoldOn.close();
        });
        myDropzone.on("error", function (data, errorMessage, xhr) {
            $.toast({
                heading: 'Hata',
                text: errorMessage,
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 3500
            });
        });

        $.pImageDelete = function(id){
            var pId = '{{$data->id}}';
            $.ajax({
                url: "{{url('admin/products/imageRemove')}}",
                data: {id:id, pId:pId},
                success: function(response){
                    $("#pimage_" + id).remove();
                    sirala();
                },
                beforeSend: function () {
                    HoldOn.open({
                        theme:"sk-bounce",
                        message: "Siliniyor..."
                    });
                },
                complete: function () {
                    HoldOn.close();
                }
            });
        };

        function sirala(){
            $('.sortableLi').each(function(index){
                if(index == 0){
                    sayi = '<span class="label label-info">Ana Resim</span>';
                    $(this).attr("id","pimage_1");
                }else{
                    var total_s = index + 1;
                    sayi = '<span class="label label-info">' + total_s + '. Resim</span>';
                    $(this).attr("id","pimage_"+total_s);
                }
                $('.sira').eq(index).remove();
                $('.sortableLi').eq(index).append('<div class="sira">' + sayi + '</div>');
            });
        }

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
                url: "{{url('admin/categories/selectNestableCategory/'.$data->id)}}"
            },
            checkbox: true,
            selectMode: 2,
            clickFolderMode: 2,
            minExpandLevel : 1,
            loadChildren: function(e, data){
                // Seçili olan kategoriler
                let activeCategories = ('{{ $selectedCategoryIds }}').split(',');
                
                $(this).fancytree('getTree').getRootNode().visit(function(node){
                    if(activeCategories.includes((node.data.id).toString())){
                        node.parent.setExpanded(true);
                        node.setSelected(true);
                    }
                });
            },
            select: function(event, data) {
                var node = data.node;
                // console.log(node.getSelectedNodes());
                // if (node.isSelected()==false){
                //     $.map(node.getSelectedNodes(), function(selNode){
                //         selNode.setSelected(false);
                //     });
                //     node.setSelected(false);
                // }
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

        $(".relatedProducts-ajax").select2({
            language: "tr",
            ajax: {
                url: "{{url('admin/products/ajax/relateds/'.$data->id)}}",
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
                            more: (params.page * 30) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: 'İlgili Ürün Seçiniz'
        });

        $(".relatedProducts-ajax").on("select2:select", function (e) {

            var val = $(this).val();
            var kontrol = $("#relatedp_" + val).length;
            if(kontrol){
                swal("Hata", "Bu ürünü daha önceden eklemişsiniz.");
            }else{
                $.ajax({
                    url: "{{url('admin/products/relatedProducts')}}",
                    data: {id:val},
                    success: function(response){
                        $("#relatedProductsDiv").append(response);
                    },
                    beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "Ürün Ekleniyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });
            }

            // remove div
            $(this).val('').change();
        });

        $(".variantGroups-ajax").select2({
            ajax: {
                language: "tr",
                url: "{{url('admin/variants/ajax/list')}}",
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
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
            placeholder: 'Varyant Grubu Seçiniz',
        });


        $(".variantMultiple").multipleSelect({
            countSelected:false,
            selectAll:false,
            placeholder:"Seçiniz",
            selectAllText:"Tümünü Seç",
            noMatchesFound:"Aradığınız varyant bulunamadı.",
            allSelected:false,
            filter:true,
            multipleInline: false,
            onClick: function(view) {
                if(view.checked != false){
                    var t = $(this);
                    var g_id = t[0].groupId;
                    var variantItemTemplate = '<div class="variantListRow mB5 clearfix" data-variant-id="'+ view.value +'" data-group-id="'+g_id+'"><input type="hidden" name="variant_values[]" value="'+ view.value +'"><input type="hidden" class="varyant_id" value="'+ view.value +'"><div class="col-md-10 text-left">'+ view.label +'</div></div>';
                    $(".option-list-" + g_id).append(variantItemTemplate);
                }else{
                    $('.variantListRow[data-variant-id=' + view.value + ']').remove();
                }
            }
        });

        $(".attributeMultiple").multipleSelect({
            countSelected:'# özellik seçildi.',
            selectAll:false,
            placeholder:"Seçiniz",
            selectAllText:"Tümünü Seç",
            noMatchesFound:"Aradığınız özellik bulunamadı.",
            allSelected:"Tümü Seçildi",
            filter:true,
            multipleInline: false,
            onClick: function(view) {
                if(view.checked != false){
                    var t = $(this);
                    var g_id = t[0].groupId;
                    $.attributeAjax(view.value, g_id);
                }else{
                    $('.attributeListRow[data-attribute-id=' + view.value + ']').remove();
                }
            }
        });

        $(".variantGroups-ajax").on("select2:select", function (e) {
            var gId = $("#variantGroupAjax").val();

            if(!gId){
                swal("Hata", "Lütfen varyant grubu seçiniz.");
            }else{
                var kontrol = $("#vgroup-" + gId).length;

                if(kontrol){
                    swal("Hata", "Bu varyant grubunu daha önceden eklemişsiniz.");
                }else{
                    $.ajax({
                        url: "{{url('admin/variants/ajax/group')}}",
                        data: {id:gId},
                        success: function(response){
                            var gTemp = '#variant-' + gId;
                            $("#vGroupAjax").append(response);
                            $(gTemp).multipleSelect({
                                countSelected:false,
                                selectAll:false,
                                placeholder:"Seçiniz",
                                selectAllText:"Tümünü Seç",
                                noMatchesFound:"Aradığınız varyant bulunamadı.",
                                allSelected:false,
                                filter:true,
                                multipleInline: false,
                                onClick: function(view) {
                                    if(view.checked != false){
                                        var variantItemTemplate = '<div class="variantListRow mB5 clearfix" data-variant-id="'+ view.value +'" data-group-id="'+gId+'"><input type="hidden" name="variant_values[]" value="'+ view.value +'"><input type="hidden" class="varyant_id" value="'+ view.value +'"><div class="col-md-10 text-left">'+ view.label +'</div><div class="col-md-2 text-right"><button type="button" class="btn btn-default variantOptionBox" onclick="$.variantOptionBox('+ view.value +')"><i class="fa fa-cogs"></i></button></div><div class="clearfix"></div></div>';
                                        $(".option-list-" + gId).append(variantItemTemplate);
                                    }else{
                                        $('.variantListRow[data-variant-id=' + view.value + ']').remove();
                                    }
                                }
                            });
                            $(gTemp).multipleSelect('uncheckAll');
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
                }
            }

            // remove div
            $(this).val('').change();
        });

        $.deleteDivFromId = function(group){
            $("#"+group).remove();
        };

        $('#create-variants').on('click', function(){
            var total = $(".varyant_id").length;
            var countOldvariant=$("#variant-table-list tr").length;
            if(!total && !countOldvariant){
                swal("Hata", "Lütfen varyasyon seçiniz.");
            }else if(!total && countOldvariant){
                $("#variant-table-list").html("");
            }else{
                var total2 = $('#variant-table-list tr').length;
                if(total2){
                    swal({
                        title: "Varyasyonları güncellemek istediğinize emin misiniz?",
                        text: "Eğer güncelleme yaparsanız mevcut değerleriniz kaybolacaktır.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Güncelle",
                        cancelButtonText: "İptal Et",
                        closeOnConfirm: true
                    }, function(){
                        var formData = new FormData();
                        $(".varyant_id").each(function (index, value) {
                            formData.append('variants[]', $(this).val());
                        });
                        formData.append('stock_code', $('#stock_code').val());
                        formData.append('variant_combination', $('#variant_combination').val());
                        formData.append('main_variant', $('input[name=main_variant]:checked').val());
                        formData.append('variant_product_cut', $('#variant_product_cut').val());
                        formData.append('_token', '{{csrf_token()}}');
                        $.ajax({
                            url: "{{url('admin/variants/ajax/table')}}",
                            data:formData,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(html){
                                $("#variant-table-list").html("");
                                $("#variant-table-list").append(html);
                                $(".selectpicker").selectpicker("refresh");
                            },
                            beforeSend: function () {
                                HoldOn.open({
                                    theme:"sk-bounce",
                                    message: "YÜkleniyor..."
                                });
                            },
                            complete: function () {
                                HoldOn.close();
                            }
                        });
                    });
                }else{
                    var formData = new FormData();
                    $(".varyant_id").each(function (index, value) {
                        formData.append('variants[]', $(this).val());
                    });
                    formData.append('stock_code', $('#stock_code').val());
                    formData.append('_token', '{{csrf_token()}}');
                    $.ajax({
                        url: "{{url('admin/variants/ajax/table')}}",
                        data:formData,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(html){
                            $("#variant-table-list").html("");
                            $("#variant-table-list").append(html);
                            $(".selectpicker").selectpicker("refresh");
                        },
                        beforeSend: function () {
                            HoldOn.open({
                                theme:"sk-bounce",
                                message: "YÜkleniyor..."
                            });
                        },
                        complete: function () {
                            HoldOn.close();
                        }
                    });
                }
            }
        });

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

        $(".attributeGroups-ajax").on("select2:select", function (e) {
            var ozellikGrubu = $(this).val();

            if(!ozellikGrubu){
                swal("Hata", "Lütfen özellik grubu seçiniz.");
            }else{
                var kontrol = $("#group-" + ozellikGrubu).length;

                if(kontrol){
                    swal("Hata", "Bu özellik grubunu daha önceden eklemişsiniz.");
                }else{
                    $.ajax({
                        url: "{{url('admin/attributeGroups/ajax/getGroup')}}",
                        data: {id:ozellikGrubu},
                        success: function(response){
                            var aTemp = '#atgroup-' + ozellikGrubu;
                            $("#ajaxGroups").append(response);
                            $(aTemp).multipleSelect({
                                countSelected:'# özellik seçildi.',
                                selectAll:false,
                                placeholder:"Seçiniz",
                                selectAllText:"Tümünü Seç",
                                noMatchesFound:"Aradığınız özellik bulunamadı.",
                                allSelected:"Tümü Seçildi",
                                filter:true,
                                multipleInline: false,
                                onClick: function(view) {
                                    if(view.checked != false){
                                        $.attributeAjax(view.value, ozellikGrubu);
                                    }else{
                                        $('.attributeListRow[data-attribute-id=' + view.value + ']').remove();
                                    }
                                }
                            });
                            $(aTemp).multipleSelect('uncheckAll');
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
                }
            }
            // remove div
            $(this).val('').change();
        });

        $.attributeAjax = function(id, g_id){
            $.ajax({
                url: "{{url('admin/attributeGroups/ajax/getAttributeValues')}}",
                data: {id:id},
                success: function(response){
                    $(".aoption-list-" + g_id).append(response);
                    $(".selectpicker").selectpicker("refresh");
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
        };


    </script>
@endsection
