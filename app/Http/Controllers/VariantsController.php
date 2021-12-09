<?php

namespace App\Http\Controllers;

use App\Variant;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class VariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.variants');   
    }

    public function variantsDatatable()
    {
        $variants = \App\Variant::All();

        foreach ($variants as $variant){
            // $brand->deneme=$brand->getstartDateAttribute($variant->startDate);
            //$variant->edit='<a href="'.url("admin/campaigns/coupons/edit/{$variant->id}").'" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            $variant->delete='<a href="'.url("admin/campaigns/coupons/delete/{$variant->id}").'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</a>';
            $resp[]=$variant;
        }
        return Datatables::of($variants)->make(true);
    }
    
    public function variantsAdd ()
    {
        return view('admin.variantAdd');
    }

    public function variantsAddarea()
    {
        $rnd = mt_rand(1000000, 9999999);
        return "<div id=".$rnd." style=\"margin-bottom:10px;\">
                    <label class=\"col-sm-1 control-label\">Değer Adı</label>
                    <div class=\"col-sm-8\">
                        <input type=\"text\" class=\"form-control\" name=\"degerler[]\">
                    </div>
                    <div class=\"col-md-2\"><button type='button' class='btn btn-danger' onclick=\"$.deleteDivFromId(".$rnd.")\"><i class='fa fa-close'></i> Sil</button></div>
                    <div class=\"clearfix\"></div>
                </div>";
    }

    public function createVariant(Request $request)
    {
        $data = array(
            "name"=>$request->get("name"),
            "filter_status"=> $request->get("add_filter") ? $request->get("add_filter") : 0
        );

        $add = \App\Variant::create($data);

        if ($add) {
            if(!empty($request->get("degerler"))) {
                //$myArray = explode(',', $request->get("degerler"));
                //$add->values()->attach($add->id,$request->get("degerler"));

                $projectsIds = [11, 33];

                $values = $request->get("degerler");

                foreach ($values as $value){
                    $arr[]=[
                        "value"=>$value,
                        "vid"=>$add->id
                    ];
                }

                //dd($arr);

                //$add->values()->attach(false,$arr);

                foreach ($arr as $data) {
                    $add->avalues()->attach(false,array('vid' => $data["vid"], 'value' => $data["value"]));

                }

            }

            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/variants");
    }

    public function editVariant($id)
    {
        $variant = Variant::find($id);

        $variant->vals=$variant->values;
        //dd($variant);
        return view('admin.variantEdit',compact('variant'));
    
    }


    public function updateVariant(Request $request)
    {
        $variant = \App\Variant::find($request->get("id"));

        $values = $request->get("degerler");


        if ($values!=null){
            foreach ($values as $value){
                $arr[]=[
                    "value"=>$value,
                    "vid"=>$variant->id
                ];
            }
        }

        $postdata = array(
            "name"=>$request->get("name"),
            "filter_status"=>$request->get("add_filter") ? $request->get("add_filter") : 0
        );

        if(!$variant->values->isEmpty()) {

            $variant->avalues()->detach();

            foreach ($arr as $data) {
                $variant->avalues()->attach(false,array('vid' => $data["vid"], 'value' => $data["value"]));
            }

        }else{
            if ($values!=null) {
                foreach ($arr as $data) {
                    $variant->avalues()->attach(false, array('vid' => $data["vid"], 'value' => $data["value"]));
                }
            }
        }
        
        try {
            $update = \App\Variant::where('id','=',$request->get("id"))
                ->update($postdata);
            $request->session()->flash("status",array(1,"Tebrikler."));

        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect("admin/variants");

    }

    public function deleteVariant($id)
    {
        $vr = \App\Variant::find($id);

        try {
            $vr->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(0,"Hata Oluştu."));
        }
        return redirect("admin/variants");
    }
    
    
    public function ajaxList()
    {
        return \App\Variant::paginate(15);   
    }

    public function ajaxGroup(Request $request)
    {
        //dd($request->get("id"));
        $id = $request->get('id');
        $variant = \App\Variant::find($id);
        $values  = $variant->values;
       // dd($values);
        $options="";
        foreach ($values as $val){
            $options.='<option value="'.$val->id.'">'.$val->value.'</option>';
        }
        $data ='<div class="col-md-3"  id="vgroup-'.$id.'"><div class="variant-list">
                <div class="variant-box"><div class="form-group">
                    <input type="hidden" name="variantGroups[]" value="'.$id.'">
                    <label for="s_brand" class="col-sm-5 control-label text-center">'.$variant->name.'</label>
                    <div class="col-sm-7">
                        <select id="variant-'.$id.'" data-group-id="'.$id.'" class="variant_select">
                        '.$options.'
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                 <div class="clearfix"></div>
                <div class="variant-options">
                   <div class="option-list-'.$id.'">
                     
                   </div>
                </div>
                <button type=\'button\' class=\'btn btn-default\' style=\'width:100px\' data-toggle="modal" data-target="#vgroup-2-modal"><i class=\'fa fa-wrench\'></i> Ayarlar</button>
                <button type=\'button\' class=\'btn btn-danger\' style=\'width:100px\' onclick="$.deleteDivFromId(\'vgroup-'.$id.'\')"><i class=\'fa fa-close\'></i> Sil</button>
            </div></div></div><div id="vgroup-2-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Varyasyon Grubu Ayarları</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="radio_2" class="col-sm-4 control-label">Ana Varyant Grubu</label>
                                <div class="col-sm-8">
                                    <div class="radio radio-custom">
                                      <input type="radio" name="main_variant" class="main_variant" id="radio_2" value="2">
                                      <label for="radio_2">Seç</label>
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
            </div><div id="Imagevgroup-2-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
            </div>';
        return $data;
    }

    public function ajaxTable(Request $request)
    {

        function combinations($arrays, $i = 0) {
            if (!isset($arrays[$i])) {
                return array();
            }
            if ($i == count($arrays) - 1) {
                return $arrays[$i];
            }

            // get combinations from subsequent arrays
            $tmp = combinations($arrays, $i + 1);

            $result = array();

            // concat each array from tmp with each element from $arrays[$i]
            foreach ($arrays[$i] as $v) {
                foreach ($tmp as $t) {
                    $result[] = is_array($t) ?
                        array_merge(array($v), $t) :
                        array($v, $t);
                }
            }

            return $result;
        }
/*
        echo "<pre>";
        print_r(
            combinations(
                array(
                    array('A1','A2','A3'),
                    array('B1','B2','B3'),
                    array('C1','C2')
                )
            )
        );
        echo "</pre>";
        die();
*/
        $data="";
        $last="";
        $say=-1;
        foreach ($request->get('variants') as $var){
            $anavar = \App\Variant_value::find($var);
            if ($last==$anavar->ana->id){
                $arr[$say][]=$anavar->value;
            }else{
                $say++;
                $arr[$say][]=$anavar->value;
            }
            $last = $anavar->ana->id;
        }

        //dd(combinations($arr));
        $arr=combinations($arr);

        if (is_array($arr[0])){

            $sonc="";
            $ids="";
            //echo "<pre>";
            foreach ($arr as $k){
                //print_r($k);
                foreach ($k as $v){
                    $id = \App\Variant_value::where('value',$v)->select('id')->first();
                    // dd($id);
                    $ids .= $id->id."-";
                    $sonc .= $v."-";
                }
                $res[]=[
                    "v"=>rtrim($sonc,"-"),
                    "id"=>rtrim($ids,"-"),
                ];
                $sonc="";
                $ids="";
            }
            //echo $sonc;
            //print_r($res);
            //echo "</pre>";

        }else{
            foreach ($arr as $i){
                $id = \App\Variant_value::where('value',$i)->select('id')->first();
                $res[]=[
                    "v"=>$i,
                    "id"=>$id->id
                ];
            }
        }

        //dd($res);
        $counter = 0;
        foreach ($res as $r){
            $counter++;
            $data.='<tr id="'.$counter.'" class="variant_table">
                    <input type="hidden" name="variants['.$counter.'][name]" value="'.$r["v"].'"> 
                    <input type="hidden" name="variants['.$counter.'][values]" value="'.$r["id"].'"> 
                    <input type="hidden" name="variants['.$counter.'][stock_code]" value="052-3778_02_1">
                    <td>'.$r["v"].'</td>
                    <td><input type="text" name="variants['.$counter.'][stock]" class="form-control" value="1"></td>
                    <td><input type="text" name="variants['.$counter.'][price]" class="form-control" value="0"></td>
                    <td><select name="variants['.$counter.'][price_value]" class="selectpicker show-tick" data-style="form-control" data-width="100%"><option value="1" selected="selected">Artı</option><option value="2">Eksi</option></select></td>
                    <td><input type="text" name="variants['.$counter.'][weight]" class="form-control" value="0"></td>
                    <td><select class="selectpicker show-tick" name="variants['.$counter.'][weight_type]" data-style="form-control" data-width="100%"><option value="1" selected="selected">Artı</option><option value="2">Eksi</option></select></td>
                    <td><select class="selectpicker show-tick" name="variants['.$counter.'][weight_value]" data-style="form-control" data-width="100%"><option value="1" selected="selected">Kg</option><option value="2">Gr</option><option value="3">Desi</option></select></td>
                </tr>';

        }

        return $data;
/*
        foreach ($request->get('variants') as $variant){
            $variant = \App\Variant_value::find($variant);
            //dd($variant);
            $data.='<tr id="'.$variant->id.'" class="variant_table">
                    <input type="hidden" name="variants['.$variant->id.'][name]" value="'.$variant->id.'"> 
                    <input type="hidden" name="variants['.$variant->id.'][values]" value="1"> 
                    <input type="hidden" name="variants['.$variant->id.'][stock_code]" value="052-3778_02_1">
                    <td>'.$variant->value.'</td>
                    <td><input type="text" name="variants['.$variant->id.'][stock]" class="form-control" value="1"></td>
                    <td><input type="text" name="variants['.$variant->id.'][price]" class="form-control" value="0"></td>
                    <td><select name="variants['.$variant->id.'][price_value]" class="selectpicker show-tick" data-style="form-control" data-width="100%"><option value="1" selected="selected">Artı</option><option value="2">Eksi</option></select></td>
                    <td><input type="text" name="variants['.$variant->id.'][weight]" class="form-control" value="0"></td>
                    <td><select class="selectpicker show-tick" name="variants['.$variant->id.'][weight_type]" data-style="form-control" data-width="100%"><option value="1" selected="selected">Artı</option><option value="2">Eksi</option></select></td>
                    <td><select class="selectpicker show-tick" name="variants['.$variant->id.'][weight_value]" data-style="form-control" data-width="100%"><option value="1" selected="selected">Kg</option><option value="2">Gr</option><option value="3">Desi</option></select></td>
                </tr>';
        }
        return $data;
*/
    }
    

}
