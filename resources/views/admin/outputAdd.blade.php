@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Oluştur</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/output/list')}}" class="btn btn-block btn-default btn-rounded">← Entegrasyonlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Yeni</h3>

                        <form method="post" action="{{url('admin/output/create/')}}" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                    <div class="col-sm-10">
                                        <select name="categories[]" id="categories" multiple=""  class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brands" class="col-sm-2 control-label">Markalar</label>
                                    <div class="col-sm-10">
                                        <select name="brands[]" id="brands" multiple="" class="brands-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="otherFilters" class="col-sm-2 control-label">Diğer Filtreler</label>
                                    <div class="col-sm-10">
                                        <select name="otherFilters[]" id="otherFilters" multiple="" class="otherFiltersSelect js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            <option value="1">Stokta Olan Ürünler</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="font-family:initial;font-weight: 100;font-size: 12px" class="row">

                                    <!-- LEFT -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="id" name="selectedColumns[]" value="id" type="checkbox">
                                                <label for="id"> Ürün ID (Stok kodu değil) </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[id]" value="id" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="stock_code" name="selectedColumns[]" value="stock_code"  type="checkbox">
                                                <label for="stock_code"> Ürün Stok Kodu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stock_code]" value="stock_code" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="name" name="selectedColumns[]" value="name" type="checkbox">
                                                <label for="name"> Ürün Adı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[name]" value="name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="status" name="selectedColumns[]" value="status" type="checkbox">
                                                <label for="status"> Ürün Aktif/Pasif Durumu</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[status]" value="status" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="barcode" name="selectedColumns[]" value="barcode"  type="checkbox">
                                                <label for="barcode"> Barcode </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[barcode]" value="barcode" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="brand" name="selectedColumns[]" value="brand"  type="checkbox">
                                                <label for="brand"> Markası </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brand]" value="brand" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="brand_id" name="selectedColumns[]" value="brand_id" type="checkbox">
                                                <label for="brand_id"> Marka ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brand_id]" value="brand_id" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="brandCode" name="selectedColumns[]" value="brandCode" type="checkbox">
                                                <label for="brandCode"> Marka Kodu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brandCode]" value="brandCode" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="category" name="selectedColumns[]" value="category" type="checkbox">
                                                <label for="category"> 1. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category]" value="category" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="categoryId" name="selectedColumns[]" value="categoryId" type="checkbox">
                                                <label for="categoryId"> 1. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId]" value="categoryId" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="category2" name="selectedColumns[]" value="category2" type="checkbox">
                                                <label for="category2"> 2. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category2]" value="category2" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="categoryId2" name="selectedColumns[]" value="categoryId2" type="checkbox">
                                                <label for="categoryId2"> 2. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId2]" value="categoryId2" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="category3" name="selectedColumns[]" value="category3" type="checkbox">
                                                <label for="category3"> 3. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category3]" value="category3" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="categoryId3" name="selectedColumns[]" value="categoryId3" type="checkbox">
                                                <label for="categoryId3"> 3. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId3]" value="categoryId3" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="categoryTree"  name="selectedColumns[]" value="categoryTree"  type="checkbox">
                                                <label for="categoryTree"> Kategori Ağacı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryTree]" value="categoryTree" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="slug"  name="selectedColumns[]" value="slug"  type="checkbox">
                                                <label for="slug"> Ürün Adresi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[slug]" value="slug" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="desi" name="selectedColumns[]" value="desi" type="checkbox">
                                                <label for="desi"> Ürün Desisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[desi]" value="desi" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CENTER -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="price" name="selectedColumns[]" value="price" type="checkbox">
                                                <label for="price"> Fiyatı </label>

                                                <input name="additionalPrice[price]" minlength="1" required type="number" value="0" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[price]" value="price" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="tax" name="selectedColumns[]" value="tax" type="checkbox">
                                                <label for="tax"> KDV Oranı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[tax]" value="tax" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="priceWithTaxTL" name="selectedColumns[]" value="priceWithTaxTL" type="checkbox">
                                                <label for="priceWithTaxTL"> <small>TL Kuruna Çevirilmiş KDV Dahil Fiyat</small> </label>

                                                <input name="additionalPrice[priceWithTaxTL]" minlength="1" required type="number" value="0" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceWithTaxTL]" value="priceWithTaxTL" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="priceWithTax" name="selectedColumns[]" value="priceWithTax" type="checkbox">
                                                <label for="priceWithTax"> KDV Dahil Fiyat </label>

                                                <input name="additionalPrice[priceWithTax]" minlength="1" required type="number" value="0" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceWithTax]" value="priceWithTax" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="priceTaxWithCur" name="selectedColumns[]" value="priceTaxWithCur" type="checkbox">
                                                <label for="priceTaxWithCur"> TL Kuruna Çevrilmiş KDV Dahil Fiyat </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceTaxWithCur]" value="priceTaxWithCur" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="discountedPrice"  name="selectedColumns[]" value="discountedPrice"  type="checkbox">
                                                <label for="discountedPrice"> İndirimli Fiyat (KDV Dahil)</label>

                                                <input name="additionalPrice[discountedPrice]" minlength="1" required type="number" value="0" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discountedPrice]" value="discountedPrice" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="discountedPriceTL"  name="selectedColumns[]" value="discountedPriceTL"  type="checkbox">
                                                <label for="discountedPriceTL"> <small>TL Kuruna Çevrilmiş İndirimli Fiyat</small> </label>

                                                <input name="additionalPrice[discountedPriceTL]" minlength="1" required type="number" value="0" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discountedPriceTL]" value="discountedPriceTL" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="rebatedPriceWithoutTax"  name="selectedColumns[]" value="rebatedPriceWithoutTax"  type="checkbox">
                                                <label for="rebatedPriceWithoutTax"> İndirimli Fiyat (KDV Hariç) </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[rebatedPriceWithoutTax]" value="rebatedPriceWithoutTax" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="discount"   name="selectedColumns[]" value="discount"   type="checkbox">
                                                <label for="discount"> İndirim Miktarı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discount]" value="discount" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="discount_type"  name="selectedColumns[]" value="discount_type"  type="checkbox">
                                                <label for="discount_type"> İndirim Tipi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discount_type]" value="discount_type" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="rebatePercent" name="selectedColumns[]" value="rebatePercent" type="checkbox">
                                                <label for="rebatePercent"> Ürün İndirim Yüzdesi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[rebatePercent]" value="rebatePercent" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="seo"  name="selectedColumns[]" value="seo"  type="checkbox">
                                                <label for="seo"> Seo Tanımlama Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[seo]" value="seoDesc" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="seoTitle"  name="selectedColumns[]" value="seoTitle"  type="checkbox">
                                                <label for="seoTitle"> Seo Başlık Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[seoTitle]" value="seoTitle" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="keywords"  name="selectedColumns[]" value="keywords"  type="checkbox">
                                                <label for="keywords"> Seo Anahtar Kelimeler </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[keywords]" value="keywords" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RIGHT -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="stockStatus" name="selectedColumns[]" value="stockStatus"  type="checkbox">
                                                <label for="stockStatus"> Stok Durumu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockStatus]" value="stockStatus" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="stockType"  name="selectedColumns[]" value="stockType"  type="checkbox">
                                                <label for="stockType"> Stok Tipi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockType]" value="stockType" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="stockAmount"  name="selectedColumns[]" value="stockAmount"  type="checkbox">
                                                <label for="stockAmount"> Stok Miktarı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockAmount]" value="stockAmount" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image" name="selectedColumns[]" value="image"  type="checkbox">
                                                <label for="image"> Standart Resim </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image]" value="image" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image1"  name="selectedColumns[]" value="image1"  type="checkbox">
                                                <label for="image1"> Ürün Resmi 1 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image1]" value="image1" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image2"  name="selectedColumns[]" value="image2"  type="checkbox">
                                                <label for="image2"> Ürün Resmi 2 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image2]" value="image2" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image3"  name="selectedColumns[]" value="image3"  type="checkbox">
                                                <label for="image3"> Ürün Resmi 3 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image3]" value="image3" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image4"  name="selectedColumns[]" value="image4"  type="checkbox">
                                                <label for="image4"> Ürün Resmi 4 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image4]" value="image4" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image5"  name="selectedColumns[]" value="image5"  type="checkbox">
                                                <label for="image5"> Ürün Resmi 5 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image5]" value="image5" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="image6"  name="selectedColumns[]" value="image6"  type="checkbox">
                                                <label for="image6"> Ürün Resmi 6 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image6]" value="image6" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="isOptionedProduct" name="selectedColumns[]" value="isOptionedProduct"  type="checkbox">
                                                <label for="isOptionedProduct"> Seçenekli Ürün Olup Olmadığı Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[isOptionedProduct]" value="isOptionedProduct" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input id="multipleOptions1"  name="selectedColumns[]" value="multipleOptions1" type="checkbox">
                                                <label for="multipleOptions1"> Seçenek İsimlerinin Virgülle Birleştirilmiş Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[multipleOptions1]" value="multipleOptions" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <hr>

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="outputName"> Adı </label>
                                            <input class="col-sm-8" id="outputName" name="outputName" value="" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="rootElementName"> Döküman ana etiketi </label>
                                            <input class="col-sm-8" name="rootElementName" value="root" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="loopElementName"> Key/Tag ana etiketi </label>
                                            <input class="col-sm-8" name="loopElementName" value="item" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="outputDescription"> Açıklama </label>
                                            <textarea class="col-sm-8" name="outputDescription" id="outputDescription" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <hr>

                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Kaydet</button>
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
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>

        function exp(p) {
            $.ajax({
                url: "{{url('admin/output/export/')}}/"+p,
                success: function (response) {
                }
            });
        }

        $( document ).ready(function() {
            $(".otherFiltersSelect").select2();

            // Categories
            $(".categories-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/categories/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.title};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Kategori Seçiniz'
            });

            // Brands
            $(".brands-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/brands/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name};
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Marka Seçiniz'
            });
        });

    </script>
@endsection