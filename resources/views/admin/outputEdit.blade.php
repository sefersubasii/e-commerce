@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Düzenle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/output/list')}}" class="btn btn-block btn-default btn-rounded">← Entegrasyonlar</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">{{$data->name}} ({{$data->permCode}})</h3>
                        <p>
                            URL = <a target="_blank" href="{{url("output/product/".$data->permCode)}}">{{url("output/product/".$data->permCode)}}</a>
                        </p>
                        <br>

                        <form method="post" action="{{url('admin/output/update/'.$data->id)}}" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="categories" class="col-sm-2 control-label">Kategoriler</label>
                                    <div class="col-sm-10">
                                        <select name="categories[]" id="categories" multiple=""  class="categories-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            @if($data->categories!=null)
                                                @foreach($data->selectedCats as $vals)
                                                    <option selected="selected" value="{{$vals->id}}">{{$vals->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brands" class="col-sm-2 control-label">Markalar</label>
                                    <div class="col-sm-10">
                                        <select name="brands[]" id="brands" multiple="" class="brands-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            @if($data->brands!=null)

                                                @foreach($data->selectedBrands as $vals)
                                                    <option selected="selected" value="{{$vals->id}}">{{$vals->name}}</option>
                                                @endforeach

                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="otherFilters" class="col-sm-2 control-label">Diğer Filtreler</label>
                                    <div class="col-sm-10">
                                        <select name="otherFilters[]" id="otherFilters" multiple="" class="otherFiltersSelect js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            <option {{ @in_array('1',json_decode($data->otherFilters)) ? 'selected' : '' }} value="1">Stokta Olan Ürünler</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="font-family:initial;font-weight: 100;font-size: 12px" class="row">

                                    <!-- LEFT -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ @in_array("id",$data->selectedColums) ? "checked" : "" }} id="id" name="selectedColumns[]" value="id" type="checkbox">
                                                <label for="id"> Ürün ID (Stok kodu değil) </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[id]" value="{{$data->names["id"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ @in_array("stock_code",$data->selectedColums) ? "checked" : "" }} id="stock_code" name="selectedColumns[]" value="stock_code"  type="checkbox">
                                                <label for="stock_code"> Ürün Stok Kodu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stock_code]" value="{{$data->names["stock_code"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ @in_array("name",$data->selectedColums) ? "checked" : "" }} id="name" name="selectedColumns[]" value="name" type="checkbox">
                                                <label for="name"> Ürün Adı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[name]" value="{{$data->names["name"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ @in_array("status",$data->selectedColums) ? "checked" : "" }} id="status" name="selectedColumns[]" value="status" type="checkbox">
                                                <label for="status"> Ürün Aktif/Pasif Durumu</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[status]" value="{{$data->names["status"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("barcode",$data->selectedColums) ? "checked" : "" }} id="barcode" name="selectedColumns[]" value="barcode"  type="checkbox">
                                                <label for="barcode"> Barcode </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[barcode]" value="{{$data->names["barcode"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("brand",$data->selectedColums) ? "checked" : "" }} id="brand" name="selectedColumns[]" value="brand"  type="checkbox">
                                                <label for="brand"> Markası </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brand]" value="{{$data->names["brand"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("brand_id",$data->selectedColums) ? "checked" : "" }} id="brand_id" name="selectedColumns[]" value="brand_id" type="checkbox">
                                                <label for="brand_id"> Marka ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brand_id]" value="{{$data->names["brand_id"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("brandCode",$data->selectedColums) ? "checked" : "" }} id="brandCode" name="selectedColumns[]" value="brandCode" type="checkbox">
                                                <label for="brandCode"> Marka Kodu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[brandCode]" value="{{$data->names["brandCode"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("category",$data->selectedColums) ? "checked" : "" }} id="category" name="selectedColumns[]" value="category" type="checkbox">
                                                <label for="category"> 1. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category]" value="{{$data->names["category"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("categoryId",$data->selectedColums) ? "checked" : "" }} id="categoryId" name="selectedColumns[]" value="categoryId" type="checkbox">
                                                <label for="categoryId"> 1. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId]" value="{{$data->names["categoryId"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("category2",$data->selectedColums) ? "checked" : "" }} id="category2" name="selectedColumns[]" value="category2" type="checkbox">
                                                <label for="category2"> 2. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category2]" value="{{@$data->names["category2"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("categoryId2",$data->selectedColums) ? "checked" : "" }} id="categoryId2" name="selectedColumns[]" value="categoryId2" type="checkbox">
                                                <label for="categoryId2"> 2. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId2]" value="{{@$data->names["categoryId2"]}}" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("category3",$data->selectedColums) ? "checked" : "" }} id="category3" name="selectedColumns[]" value="category3" type="checkbox">
                                                <label for="category3"> 3. Seviye Kategori </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[category3]" value="{{@$data->names["category3"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("categoryId3",$data->selectedColums) ? "checked" : "" }} id="categoryId3" name="selectedColumns[]" value="categoryId3" type="checkbox">
                                                <label for="categoryId3"> 3. Seviye Kategori ID </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryId3]" value="{{@$data->names["categoryId3"]}}" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("categoryTree",$data->selectedColums) ? "checked" : "" }} id="categoryTree"  name="selectedColumns[]" value="categoryTree"  type="checkbox">
                                                <label for="categoryTree"> Kategori Ağacı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryTree]" value="{{$data->names["categoryTree"]}}" type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("categoryMap",$data->selectedColums) ? "checked" : "" }} id="categoryMap"  name="selectedColumns[]" value="categoryMap"  type="checkbox">
                                                <label for="categoryMap"> Kategori Eşleştirme </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[categoryMap]" value="{{@$data->names["categoryMap"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("slug",$data->selectedColums) ? "checked" : "" }} id="slug"  name="selectedColumns[]" value="slug"  type="checkbox">
                                                <label for="slug"> Ürün Adresi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[slug]" value="{{$data->names["slug"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("desi",$data->selectedColums) ? "checked" : "" }} id="desi" name="selectedColumns[]" value="desi" type="checkbox">
                                                <label for="desi"> Ürün Desisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[desi]" value="{{$data->names["desi"]}}" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CENTER -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("price",$data->selectedColums) ? "checked" : "" }} id="price" name="selectedColumns[]" value="price" type="checkbox">
                                                <label for="price"> Fiyatı </label>

                                                @php($price = (isset($data->additionalPrice['price']) ? $data->additionalPrice['price'] : 0))
                                                <input name="additionalPrice[price]" minlength="1" required type="number" value="{{ $price }}" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[price]" value="{{$data->names["price"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("tax",$data->selectedColums) ? "checked" : "" }} id="tax" name="selectedColumns[]" value="tax" type="checkbox">
                                                <label for="tax"> KDV Oranı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[tax]" value="{{$data->names["tax"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("priceWithTaxTL", $data->selectedColums) ? "checked" : "" }} id="priceWithTaxTL" name="selectedColumns[]" value="priceWithTaxTL" type="checkbox">
                                                <label for="priceWithTaxTL"> <small>TL Kuruna Çevirilmiş KDV Dahil Fiyat</small> </label>

                                                @php($priceWithTaxTLPer = (isset($data->additionalPrice['priceWithTaxTL']) ? $data->additionalPrice['priceWithTaxTL'] : 0))
                                                <input name="additionalPrice[priceWithTaxTL]" type="number" value="{{ $priceWithTaxTLPer }}" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceWithTaxTL]" value="{{ isset($data->names["priceWithTaxTL"]) ? $data->names["priceWithTaxTL"] : 'priceWithTaxTL' }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("priceWithTax", $data->selectedColums) ? "checked" : "" }} id="priceWithTax" name="selectedColumns[]" value="priceWithTax" type="checkbox">
                                                <label for="priceWithTax"> KDV Dahil Fiyat </label>

                                                @php($priceWithTaxPer = (isset($data->additionalPrice['priceWithTax']) ? $data->additionalPrice['priceWithTax'] : 0))
                                                <input name="additionalPrice[priceWithTax]" type="number" value="{{ $priceWithTaxPer }}" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceWithTax]" value="{{isset($data->names["priceWithTax"]) ? $data->names["priceWithTax"] : 'priceWithTax'}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("priceTaxWithCur",$data->selectedColums) ? "checked" : "" }} id="priceTaxWithCur" name="selectedColumns[]" value="priceTaxWithCur" type="checkbox">
                                                <label for="priceTaxWithCur"> TL Kuruna Çevrilmiş KDV Dahil Fiyat </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[priceTaxWithCur]" value="{{$data->names["priceTaxWithCur"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("discountedPrice",$data->selectedColums) ? "checked" : "" }} id="discountedPrice"  name="selectedColumns[]" value="discountedPrice"  type="checkbox">
                                                <label for="discountedPrice">İndirimli Fiyat (KDV Dahil) </label>

                                                @php($discountedPriceAddPrice = (isset($data->additionalPrice['discountedPrice']) ? $data->additionalPrice['discountedPrice'] : 0))
                                                <input name="additionalPrice[discountedPrice]" type="number" value="{{ $discountedPriceAddPrice }}" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discountedPrice]" value="{{ $data->names["discountedPrice"] }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("discountedPriceTL",$data->selectedColums) ? "checked" : "" }} id="discountedPriceTL"  name="selectedColumns[]" value="discountedPriceTL"  type="checkbox">
                                                <label for="discountedPriceTL"> TL Kuruna Çevrilmiş İndirimli Fiyat </label>

                                                @php($discountedPriceTLAddPrice = (isset($data->additionalPrice['discountedPriceTL']) ? $data->additionalPrice['discountedPriceTL'] : 0))
                                                <input name="additionalPrice[discountedPriceTL]" type="number" value="{{ $discountedPriceTLAddPrice }}" style="width: 50px;margin-left: 7px;padding: 1px 5px;">%
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discountedPriceTL]" value="{{ isset($data->names["discountedPriceTL"]) ? $data->names["discountedPriceTL"] : 'discountedPriceTL'}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("rebatedPriceWithoutTax",$data->selectedColums) ? "checked" : "" }} id="rebatedPriceWithoutTax"  name="selectedColumns[]" value="rebatedPriceWithoutTax"  type="checkbox">
                                                <label for="rebatedPriceWithoutTax"> İndirimli Fiyat (KDV Hariç) </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[rebatedPriceWithoutTax]" value="{{$data->names["rebatedPriceWithoutTax"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("discount",$data->selectedColums) ? "checked" : "" }} id="discount"   name="selectedColumns[]" value="discount"   type="checkbox">
                                                <label for="discount"> İndirim Miktarı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discount]" value="{{$data->names["discount"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("discount_type",$data->selectedColums) ? "checked" : "" }} id="discount_type"  name="selectedColumns[]" value="discount_type"  type="checkbox">
                                                <label for="discount_type"> İndirim Tipi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[discount_type]" value="{{$data->names["discount_type"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("rebatePercent",$data->selectedColums) ? "checked" : "" }} id="rebatePercent" name="selectedColumns[]" value="rebatePercent" type="checkbox">
                                                <label for="rebatePercent"> Ürün İndirim Yüzdesi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[rebatePercent]" value="{{$data->names["rebatePercent"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("seo",$data->selectedColums) ? "checked" : "" }} id="seo"  name="selectedColumns[]" value="seo"  type="checkbox">
                                                <label for="seo"> Seo Tanımlama Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[seo]" value="{{$data->names["seo"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("seoTitle",$data->selectedColums) ? "checked" : "" }} id="seoTitle"  name="selectedColumns[]" value="seoTitle"  type="checkbox">
                                                <label for="seoTitle"> Seo Başlık Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[seoTitle]" value="{{$data->names["seoTitle"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("keywords",$data->selectedColums) ? "checked" : "" }} id="keywords"  name="selectedColumns[]" value="keywords"  type="checkbox">
                                                <label for="keywords"> Seo Anahtar Kelimeler </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[keywords]" value="{{$data->names["keywords"]}}" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RIGHT -->

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("stockStatus",$data->selectedColums) ? "checked" : "" }} id="stockStatus" name="selectedColumns[]" value="stockStatus"  type="checkbox">
                                                <label for="stockStatus"> Stok Durumu </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockStatus]" value="{{$data->names["stockStatus"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("stockType",$data->selectedColums) ? "checked" : "" }} id="stockType"  name="selectedColumns[]" value="stockType"  type="checkbox">
                                                <label for="stockType"> Stok Tipi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockType]" value="{{$data->names["stockType"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("stockAmount",$data->selectedColums) ? "checked" : "" }} id="stockAmount"  name="selectedColumns[]" value="stockAmount"  type="checkbox">
                                                <label for="stockAmount"> Stok Miktarı </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[stockAmount]" value="{{$data->names["stockAmount"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image",$data->selectedColums) ? "checked" : "" }} id="image" name="selectedColumns[]" value="image"  type="checkbox">
                                                <label for="image"> Standart Resim </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image]" value="{{$data->names["image"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image1",$data->selectedColums) ? "checked" : "" }} id="image1"  name="selectedColumns[]" value="image1"  type="checkbox">
                                                <label for="image1"> Ürün Resmi 1 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image1]" value="{{$data->names["image1"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image2",$data->selectedColums) ? "checked" : "" }} id="image2"  name="selectedColumns[]" value="image2"  type="checkbox">
                                                <label for="image2"> Ürün Resmi 2 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image2]" value="{{$data->names["image2"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image3",$data->selectedColums) ? "checked" : "" }} id="image3"  name="selectedColumns[]" value="image3"  type="checkbox">
                                                <label for="image3"> Ürün Resmi 3 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image3]" value="{{$data->names["image3"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image4",$data->selectedColums) ? "checked" : "" }} id="image4"  name="selectedColumns[]" value="image4"  type="checkbox">
                                                <label for="image4"> Ürün Resmi 4 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image4]" value="{{$data->names["image4"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image5",$data->selectedColums) ? "checked" : "" }} id="image5"  name="selectedColumns[]" value="image5"  type="checkbox">
                                                <label for="image5"> Ürün Resmi 5 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image5]" value="{{$data->names["image5"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("image6",$data->selectedColums) ? "checked" : "" }} id="image6"  name="selectedColumns[]" value="image6"  type="checkbox">
                                                <label for="image6"> Ürün Resmi 6 </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[image6]" value="{{$data->names["image6"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("isOptionedProduct",$data->selectedColums) ? "checked" : "" }} id="isOptionedProduct" name="selectedColumns[]" value="isOptionedProduct"  type="checkbox">
                                                <label for="isOptionedProduct"> Seçenekli Ürün Olup Olmadığı Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[isOptionedProduct]" value="{{$data->names["isOptionedProduct"]}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-info col-sm-8">
                                                <input {{ in_array("multipleOptions1",$data->selectedColums) ? "checked" : "" }} id="multipleOptions1"  name="selectedColumns[]" value="multipleOptions1" type="checkbox">
                                                <label for="multipleOptions1"> Seçenek İsimlerinin Virgülle Birleştirilmiş Bilgisi </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="names[multipleOptions1]" value="{{$data->names["multipleOptions1"]}}" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <hr>

                                    <div class="col-sm-4">
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="outputName"> Adı </label>
                                            <input class="col-sm-8" id="outputName" name="outputName" value="{{$data->name}}" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="rootElementName"> Döküman ana etiketi </label>
                                            <input class="col-sm-8" name="rootElementName" value="{{$data->rootElementName}}" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="loopElementName"> Key/Tag ana etiketi </label>
                                            <input class="col-sm-8" name="loopElementName" value="{{$data->loopElementName}}" type="text">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="col-sm-4" for="outputDescription"> Açıklama </label>
                                            <textarea class="col-sm-8" name="outputDescription" id="outputDescription" cols="30" rows="10">{{$data->description}}</textarea>
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <hr>

                                    <?php /*
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="id" name="selectedColumns[]" value="id" type="checkbox">
                                            <label for="id"> Ürün ID (Stok kodu değil) </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="price" name="selectedColumns[]" value="price" type="checkbox">
                                            <label for="price"> Fiyatı </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image" name="selectedColumns[]" value="image"  type="checkbox">
                                            <label for="image"> Standart Resim </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="stockCode" name="selectedColumns[]" value="stockCode"  type="checkbox">
                                            <label for="stockCode"> Ürün Stok Kodu </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="desi" name="selectedColumns[]" value="desi" type="checkbox">
                                            <label for="desi"> Ürün Desisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="name" name="selectedColumns[]" value="name" type="checkbox">
                                            <label for="name"> Ürün Adı </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="status" name="selectedColumns[]" value="status" type="checkbox">
                                            <label for="status"> Ürün Aktif/Pasif Durumu</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="slug"  name="selectedColumns[]" value="slug"  type="checkbox">
                                            <label for="slug"> Ürün Adresi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="brand" name="selectedColumns[]" value="brand"  type="checkbox">
                                            <label for="brand"> Markası </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="categoryTree"  name="selectedColumns[]" value="categoryTree"  type="checkbox">
                                            <label for="categoryTree"> Kategori Ağacı </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="barcode" name="selectedColumns[]" value="barcode"  type="checkbox">
                                            <label for="barcode"> Barcode </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="tax" name="selectedColumns[]" value="tax" type="checkbox">
                                            <label for="tax"> KDV Oranı </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="categoryId" name="selectedColumns[]" value="categoryId" type="checkbox">
                                            <label for="categoryId"> Kategori ID </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="brandId" name="selectedColumns[]" value="brandId" type="checkbox">
                                            <label for="brandId"> Marka ID </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="category" name="selectedColumns[]" value="category" type="checkbox">
                                            <label for="category"> Kategori </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="brandCode" name="selectedColumns[]" value="brandCode" type="checkbox">
                                            <label for="brandCode"> Marka Kodu </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="priceWithTax" name="selectedColumns[]" value="priceWithTax" type="checkbox">
                                            <label for="priceWithTax"> KDV Dahil Fiyat </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="rebatePercent" name="selectedColumns[]" value="rebatePercent" type="checkbox">
                                            <label for="rebatePercent"> Ürün İndirim Yüzdesi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="priceTaxWithCur" name="selectedColumns[]" value="priceTaxWithCur" type="checkbox">
                                            <label for="priceTaxWithCur"> TL Kuruna Çevrilmiş KDV Dahil Fiyat </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="discountedPrice"  name="selectedColumns[]" value="discountedPrice"  type="checkbox">
                                            <label for="discountedPrice"> TL Kuruna Çevrilmiş İndirimli Fiyat </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="stockStatus" name="selectedColumns[]" value="stockStatus"  type="checkbox">
                                            <label for="stockStatus"> Stok Durumu </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="stockType"  name="selectedColumns[]" value="stockType"  type="checkbox">
                                            <label for="stockType"> Stok Tipi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="rebatedPriceWithoutTax"  name="selectedColumns[]" value="rebatedPriceWithoutTax"  type="checkbox">
                                            <label for="rebatedPriceWithoutTax"> İndirimli Fiyat (KDV Hariç) </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="warranty"   name="selectedColumns[]" value="warranty"  type="checkbox">
                                            <label for="warranty"> Garanti Süresi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image1"  name="selectedColumns[]" value="image1"  type="checkbox">
                                            <label for="image1"> Ürün Resmi 1 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="discount"   name="selectedColumns[]" value="discount"   type="checkbox">
                                            <label for="discount"> İndirim Miktarı </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="multipleOptions1"  name="selectedColumns[]" value="multipleOptions1" type="checkbox">
                                            <label for="multipleOptions1"> Seçenek İsimlerinin Virgülle Birleştirilmiş Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image2" name="selectedColumns[]" value="image2"  type="checkbox">
                                            <label for="image2"> Ürün Resmi 2 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="discount_type"  name="selectedColumns[]" value="discount_type"  type="checkbox">
                                            <label for="discount_type"> İndirim Tipi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="isOptionedProduct" name="selectedColumns[]" value="isOptionedProduct"  type="checkbox">
                                            <label for="isOptionedProduct"> Seçenekli Ürün Olup Olmadığı Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image3"  name="selectedColumns[]" value="image3"  type="checkbox">
                                            <label for="image3"> Ürün Resmi 3 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="seo"  name="selectedColumns[]" value="seo"  type="checkbox">
                                            <label for="seo"> Seo Tanımlama Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="isOptionOfAProduct"  name="selectedColumns[]" value="isOptionOfAProduct" type="checkbox">
                                            <label for="isOptionOfAProduct"> Bir Ürünün Seçeneği Olup Olmadığı Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image4" name="selectedColumns[]" value="image4"  type="checkbox">
                                            <label for="image4"> Ürün Resmi 4 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="seoTitle"  name="selectedColumns[]" value="seoTitle"  type="checkbox">
                                            <label for="seoTitle"> Seo Başlık Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="rootProductId"  name="selectedColumns[]" value="rootProductId"  type="checkbox">
                                            <label for="rootProductId"> Bir Ürünün Seçeneği İse, Ana Ürünün ID Bilgisi </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image5" name="selectedColumns[]" value="image5" type="checkbox">
                                            <label for="image5"> Ürün Resmi 5 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="keywords"  name="selectedColumns[]" value="keywords"  type="checkbox">
                                            <label for="keywords"> Seo Anahtar Kelimeler </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="rootProductStockCode" name="selectedColumns[]" value="rootProductStockCode"  type="checkbox">
                                            <label for="rootProductStockCode"> Bir Ürünün Seçeneği İse, Ana Ürünün Stok Kodu </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox checkbox-info col-sm-8">
                                            <input id="image6"  name="selectedColumns[]" value="image6" type="checkbox">
                                            <label for="image6"> Ürün Resmi 6 </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text">
                                        </div>
                                    </div>
                                    */ ?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Kaydet</button>
                                                <a  href="{{url('admin/output/export/'.$data->permCode)}}" class="btn btn-info"><i class="fa fa-file-code-o"></i> Çıktı Al</a>
                                                <a  href="{{url('admin/output/catMap/'.$data->id)}}" class="btn btn-warning"><i class="fa fa-exchange"></i> Kategori Eşleştirme</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$data->id}}">
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