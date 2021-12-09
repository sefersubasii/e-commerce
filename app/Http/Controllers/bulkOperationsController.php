<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class bulkOperationsController extends Controller
{

    public function index()
    {
        return view('admin.bulkOperations');
    }
    
    public function template(Request $request)
    {

        if($request->get('value')=='price_change'){

            return '<h3 class="box-title">Fiyatları Değiştir</h3>
                <hr class="m-t-0">
                <input type="hidden" class="add_form" name="t_template" value="price_change">
                
                <div class="form-group">
                    <label for="t_type" class="col-md-12">Tipi</label>
                    <div class="col-sm-12">
                        <select name="t_type" id="t_type" class="add_form t_type selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                            <option value="1">Yüzde</option>
                            <option value="2">Fiyat</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="t_total" class="col-md-12">Değer</label>
                    <div class="col-sm-12">
                        <input type="text" class="add_form form-control" name="t_total" id="t_total">
                    </div>
                </div>
                <div class="form-group">
                    <label for="t_action" class="col-md-12">İşlem</label>
                    <div class="col-sm-12">
                        <select name="t_action" id="t_action" class="add_form t_action selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                            <option value="1">Arttır</option>
                            <option value="2">Azalt</option>
                            <option value="3">Eşitle</option>
                        </select>
                    </div>
                </div>
                
                <script>
                    $( document ).ready(function() {
                        $(\'.selectpicker\').selectpicker();
                
                        $("#t_price2").on(\'changed.bs.select\', function(e){
                            var value = e.target.value;
                            if(value == 0){
                                $(\'.t_type\').selectpicker(\'val\', \'2\').selectpicker(\'refresh\');
                                $(\'.t_action\').selectpicker(\'val\', \'3\').selectpicker(\'refresh\');
                            }else{
                                $(\'.t_type\').selectpicker(\'val\', \'\').selectpicker(\'refresh\');
                                $(\'.t_action\').selectpicker(\'val\', \'\').selectpicker(\'refresh\');
                            }
                        });
                    });
                </script>
                ';

        }elseif($request->get('value')=='tax_change'){

            return '<h3 class="box-title">KDV Ayarlarını Değiştir</h3>
                <hr class="m-t-0">
                <input type="hidden" class="add_form" name="t_template" value="tax_change">
                <div class="form-group">
                    <label for="t_tax_id" class="col-sm-12">KDV Oranı</label>
                    <div class="col-sm-12">
                        <select name="t_tax_id" class="add_form selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                            <option value="8">8%</option>
                            <option value="18">18%</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="t_vat_inclusive" class="col-md-12">KDV Dahil</label>
                    <div class="col-sm-12">
                        <select name="t_vat_inclusive" id="t_vat_inclusive" class="add_form selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                            <option value="0">Hayır</option>
                            <option value="1">Evet</option>
                            <option value="2">Değiştirme</option>
                        </select>
                    </div>
                </div>
                
                <script>
                    $( document ).ready(function() {
                        $(\'.selectpicker\').selectpicker();
                        
                    });
                </script>';

        }elseif ($request->get('value')=='discount_change'){
            return '
            <h3 class="box-title">İndirim Fiyatını Değiştir</h3>
            <hr class="m-t-0">
            <input type="hidden" class="add_form" name="t_template" value="discount_change">
            
            <div class="form-group">
                <label for="t_discount_type" class="col-sm-12">İndirim Türü</label>
                <div class="col-sm-12">
                    <select name="t_discount_type" id="t_discount_type" class="add_form selectpicker show-tick" data-style="form-control" data-width="100%">
                        <option value="3" selected="selected">Değiştirme</option>
                        <option value="1">Yüzdeli İndirim (%)</option>
                        <option value="2">İndirimli Fiyat</option>
                        <option value="0">İndirimli Yok</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="t_discount" class="col-sm-12">İndirim</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control add_form" name="t_discount" id="t_discount">
                </div>
            </div>
            
            <script>
                $( document ).ready(function() {
                    $(\'.selectpicker\').selectpicker();
                });
            </script>';
        }elseif ($request->get('value')=='status_update') {

            return '<h3 class="box-title">Ürün Durumunu Değiştir</h3>
            <hr class="m-t-0">
            <input type="hidden" class="add_form" name="t_template" value="status_update">
            <div class="form-group">
                <label for="t_status" class="col-md-12">Tipi</label>
                <div class="col-sm-12">
                    <select name="t_status" id="t_status" class="add_form selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                        <option value="0">Pasif</option>
                        <option value="1">Aktif</option>
                    </select>
                </div>
            </div>
            
            <script>
                $( document ).ready(function() {
                    $(\'.selectpicker\').selectpicker();
                });
            </script>
            ';

        }elseif ($request->get('value')=='product_type')
        {
            return '<h3 class="box-title">Ürün Tipini Değiştir</h3>
            <hr class="m-t-0">
            <input type="hidden" class="add_form" name="t_template" value="product_type">
            <div class="form-group">
                <label for="t_status" class="col-md-12">Tipi</label>
                <div class="col-sm-12">
                    <select name="t_status" id="t_status" class="add_form selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                        <option value="s_new">Yeni Ürün</option>
                        <option value="s_category">Kategori Vitrini</option>
                        <option value="s_campaign">Kampanyalı Ürün</option>
                        <option value="s_sponsor">Sponsor Ürün</option>
                        <option value="s_showcase">Vitrin Ürünü</option>
                        <option value="s_brand">Marka Vitrini</option>
                        <option value="s_sell">Çok Satan Ürün</option>
                        <option value="s_popular">Popüler Ürün</option>
                    </select>
                </div>
            </div>
            <script>
                $( document ).ready(function() {
                    $(\'.selectpicker\').selectpicker();
                });
            </script>';
        }elseif ($request->get('value')=='delete_product') {
            return 'Yapılacak işlem seçilmiştir fakat ek seçenek yoktur. Onaylamadan önce tekrar gözden geçiriniz.';
        }elseif ($request->get('value')=='stock_change') {
            return '<h3 class="box-title">Stok Belirle</h3>
            <hr class="m-t-0 ">
            <input type="hidden" class="add_form" name="t_template" value="stock_change">
            <div class="form-group">
                <label for="t_stock" class="col-md-12">Stok Adedi</label>
                <div class="col-sm-12">
                    <input type="text" class="add_form form-control" name="t_stock" id="t_stock">
                </div>
            </div>
            <div class="form-group">
                 <label for="stc_action" class="col-md-12">İşlem</label>
                 <div class="col-sm-12">
                     <select name="stc_action" id="stc_action" class="add_form selectpicker show-tick" title="Seçiniz" data-style="form-control" data-width="100%">
                         <option value="1">Arttır</option>
                         <option value="2">Azalt</option>
                         <option value="3">Eşitle</option>
                     </select>
                 </div>
            </div>
            <script>
                $( document ).ready(function() {
                    $(\'.selectpicker\').selectpicker();
                });
            </script>';
        }elseif ($request->get('value')=='stock_reset'){
            return 'Yapılacak işlem seçilmiştir fakat ek seçenek yoktur. Onaylamadan önce tekrar gözden geçiriniz.';
        }elseif ($request->get('value')=='brand_update'){
            return '<h3 class="box-title">Marka Güncelle</h3>
            <hr class="m-t-0">
            <input type="hidden" class="add_form" name="t_template" value="brand_update">
            <div class="form-group">
                <label for="t_brand_id" class="col-sm-12">Marka</label>
                <div class="col-sm-12">
                    <select name="t_brand_id" id="t_brand_id" class="brand-ajax js-states form-control add_form" tabindex="-1" style="display: none; width: 100%">
                    </select>
                </div>
            </div>
            
            <script>
            
                // Brand Ajax
                $(".brand-ajax").select2({
                    language: "tr",
                    ajax: {
                        url: "'.url("admin/brands/ajax/list").'",
                        dataType: \'json\',
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
                    placeholder: \'Marka Seçiniz\'
                });
            </script>';
        }elseif ($request->get('value')=='brand_reset'){
            return 'Yapılacak işlem seçilmiştir fakat ek seçenek yoktur. Onaylamadan önce tekrar gözden geçiriniz.';
        }elseif($request->get('value')=='shipping_price_change')
        {
            return '<h3 class="box-title">Kargo Fiyat</h3>
            <hr class="m-t-0 ">
            <div class="form-group">
                <label for="use_system" class="col-sm-2 control-label">Sistem</label>
                <div class="col-sm-2">
                    <input type="checkbox" name="use_system" value="1" class="js-switch" data-size="medium" data-color="#4F5467" data-switchery="true" style="display: none;">
                </div>
            </div>
            <div class="form-group">
                <label for="shipping_price" class="col-sm-2 control-label">Kargo Fiyatı</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="shipping_price" id="shipping_price" value="0">
                </div>
            </div><script>var elems = Array.prototype.slice.call(document.querySelectorAll(\'.js-switch\'));
    $(\'.js-switch\').each(function() {
        new Switchery($(this)[0], $(this).data());
    });</script>';
        }


    }

    public function TotalProducts(Request $request)
    {
        //filterByRequest
        $product = \App\Products::filterByRequest($request)->count();
        //dd($product);
        
        //$input = $request->all();
        
/*
        if(isset($input['category_id'])):
            $cid=$input['category_id'];
            $product = Products::whereHas('categori' , function($query) use ($cid)
            {
                $query->where('product_to_cat.cid', $cid);

            })->count();
        endif;
*/
        return $product;
    }

    public function process(Request $request)
    {
        $product = \App\Products::filterByRequest($request)->pluck('id')->toArray();

        //return dd($product);
        
        switch ($request->get("action_type")){
            case "price_change":

                $value = $request->get("t_total");

                if($request->get("t_action")==3){
                    //eşitle
                    DB::table('products')->whereIn('id', $product)->update(["price"=>$value]);
                }elseif ($request->get("t_action")==2){
                    //azalt
                    if ($request->get("t_type")==2):
                        DB::table('products')->whereIn('id', $product)->update([
                            "price"=>DB::raw( 'price - '.$value )
                        ]);
                    endif;
                    if ($request->get("t_type")==1):
                        DB::table('products')->whereIn('id', $product)->update([
                            "price"=>DB::raw( 'price * 0.'.$value )
                        ]);
                    endif;
                }elseif ($request->get("t_action")==1){
                    //arttır
                    if ($request->get("t_type")==2):
                        DB::table('products')->whereIn('id', $product)->update([
                            "price"=>DB::raw( 'price + '.$value )
                        ]);
                    endif;
                    if ($request->get("t_type")==1):
                        DB::table('products')->whereIn('id', $product)->update([
                            "price"=>DB::raw( 'price * 1.'.$value )
                        ]);
                    endif;
                }
                \LogActivity::addToLog('Toplu ürün düzenleme. (Fiyat)',$request->all());
                break;
            case "tax_change":
            
                if ($request->get("t_vat_inclusive")==2){
                    DB::table('products')->whereIn('id', $product)->update([
                        "tax"=>$request->get('t_tax_id')
                    ]);
                }elseif ($request->get("t_vat_inclusive")==1 || $request->get("t_vat_inclusive")==0){
                    DB::table('products')->whereIn('id', $product)->update([
                        "tax"=>$request->get('t_tax_id'),
                        "tax_status"=>$request->get("t_vat_inclusive")
                    ]);
                }
                \LogActivity::addToLog('Toplu ürün düzenleme. (Vergi)',$request->all());
                break;
            case "discount_change":
                if ($request->get("t_discount_type")==3){
                    DB::table('products')->whereIn('id', $product)->update([
                        "discount"=>$request->get('t_discount')
                    ]);
                }else{
                    DB::table('products')->whereIn('id', $product)->update([
                        "discount"=>$request->get('t_discount'),
                        "discount_type"=>$request->get("t_discount_type")
                    ]);
                }
                \LogActivity::addToLog('Toplu ürün düzenleme. (İndirim)',$request->all());
                break;
            case "status_update":
                DB::table('products')->whereIn('id', $product)->update([
                    "status"=>$request->get('t_status')
                ]);
                \LogActivity::addToLog('Toplu ürün düzenleme. (Durum)',$request->all());
                break;
            case "delete_product":
                DB::table('products')->whereIn('id', $product)->delete();
                \LogActivity::addToLog('Toplu ürün silme.',$request->all());
                break;
            case "brand_update":
                DB::table('products')->whereIn('id', $product)->update([
                    "brand_id"=>$request->get('t_brand_id')
                ]);
                \LogActivity::addToLog('Toplu ürün düzenleme. (Marka)',$request->all());
                break;
            case "brand_reset":
                DB::table('products')->whereIn('id', $product)->update([
                    "brand_id"=>0
                ]);
                \LogActivity::addToLog('Toplu ürün düzenleme. (Marka Sıfırlama)',$request->all());
                break;
            case 'shipping_price_change':
                DB::table('products_shippings')->whereIn('pid', $product)->update([
                    "use_system"=>$request->has("use_system") ? 1 : 0,
                    "shipping_price"=>$request->has("shipping_price") ? $request->get("shipping_price") : 0
                ]);
                \LogActivity::addToLog('Toplu ürün düzenleme. (Kargo Fiyatı)',$request->all());
                break;
        }
        $request->session()->flash("status",array(1,"Tebrikler."));

        return redirect()->back();


    }

}
