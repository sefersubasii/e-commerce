<?php

namespace App\Http\Controllers;

use  Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.attributeGroups');
    }
    
    public function attributeGroupsDatatable()
    {
        $attrGroups = \App\AttributeGroup::All();
        
        return Datatables::of($attrGroups)->make(true);
    }
    
    public function addAttributeGroups()
    {
        return view('admin.attributeGroupsAdd');
    }

    public function createAttributeGroups(Request $request)
    {
        $data=[
            "name"=>$request->get("name")
        ];
        $add = \App\AttributeGroup::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/attributeGroups");
    }
    
    public function editAttributeGroups($id)
    {
        $data = \App\AttributeGroup::find($id);
        return view('admin.attributeGroupEdit',compact('data'));
    }

    public function updateAttributeGroups(Request $request)
    {
        $data = array(
            "name"=>$request->get("name")
        );
        try {
            $update = \App\AttributeGroup::where('id','=',$request->get("id"))
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect("admin/attributeGroups");
    }

    public function attributeGroupsDelete($id)
    {
        $br = \App\AttributeGroup::find($id);

        try {
            $br->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/attributeGroups");
    }

    public function attributeGroupsAjaxList()
    {
        return \App\AttributeGroup::paginate(15);
    }

    public function attributeGroupsAjaxGetGroup(Request $request)
    {
        $grp = \App\AttributeGroup::find($request->get("id"));
        $atts = $grp->attributes;
        $options="";
        foreach ($atts as $att){
            $options.= '<option value="'.$att->id.'">'.$att->name.'</option>';
        }
        $data = '
        <div class="col-md-3"  id="group-'.$grp->id.'"><div class="group-list">
                <div class="group-box"><div class="form-group">
                    <label for="s_brand" class="col-sm-5 control-label text-center">'.$grp->name.'</label>
                    <div class="col-sm-7">
                        <select id="atgroup-'.$grp->id.'" data-group-id="'.$grp->id.'">
                        '.$options.'
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                 <div class="clearfix"></div>
                <div class="group-options">
                   <div class="aoption-list-'.$grp->id.'">
                     
                   </div>
                </div>
                <button type=\'button\' class=\'btn btn-danger\' style=\'width:100px\' onclick="$.deleteDivFromId(\'group-'.$grp->id.'\')"><i class=\'fa fa-close\'></i> Sil</button>
            </div></div></div>
        ';
        return $data;
    }

    public function attributeGroupsAjaxGetAttributeValues(Request $request)
    {
        $attr=\App\Attribute::find($request->get("id"));
        //$values = \App\AttributeValue::where("aid",$request->get("id"))->get();
        //dd($attr->values);

        $options="";
        foreach ($attr->values as $vals)
        {
            $options.='<option value="'.$vals->id.'">'.$vals->value.'</option>';
        }

        $data = '
        <div class="attributeListRow clearfix" data-attribute-id="'.$attr->id.'" data-group-id="">
        <input type="hidden" name="attributes['.$attr->id.'][group_id]" value="'.$attr->attributeGroup->id.'">
        <input type="hidden" name="attributes['.$attr->id.'][id]" value="'.$attr->id.'">
        <div class="col-md-6 text-left">'.$attr->name.'</div>
            <div class="col-md-6 text-right">
                <select name="attributes['.$attr->id.'][value_id]" class="selectpicker show-tick" data-style="form-control" data-width="100%">
                    '.$options.'
                </select>
            </div>
        </div>
        ';
        return $data;
    }
    
    public function attributes()
    {
        return view('admin.attributes');
    }

    public function attributeDatatable()
    {
        $attr = \App\Attribute::All();

        return Datatables::of($attr)->make(true);
    }

    public function addAttributeArea()
    {
        $random_string = md5(microtime());
        $area='<div id="'.$random_string.'" style="margin-bottom:10px;">
                    <label class="col-sm-1 control-label">Değer Adı</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="degerler[]">
                    </div>
                    <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="$.deleteDivFromId(\''.$random_string.'\')"><i class="fa fa-close"></i> Sil</button></div>
                    <div class="clearfix"></div>
                </div>';
        return $area;
    }

    public function addAttribute()
    {
        return view('admin.attributeAdd');
    }

    public function createAttribute(Request $request)
    {
        $data = [
            "name"=>$request->get("name"),
            "gid"=>$request->get("group_id")
        ];

        $add = \App\Attribute::create($data);
        if ($add) {
            if(!empty($request->get("degerler"))) {

                $values = $request->get("degerler");

                foreach ($values as $value){
                    $arr[]=[
                        "value"=>$value,
                        "aid"=>$add->id
                    ];
                }

                foreach ($arr as $data) {
                    $add->avalues()->attach(false,array('aid' => $data["aid"], 'value' => $data["value"]));

                }

            }
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/attributes");

    }
    
    public function editAttribute($id)
    {
        $attr=\App\Attribute::find($id);
        //DB::enableQueryLog();
        //dd(DB::getQueryLog($attr->values));
        //dd($attr->avalues()->attach(false,['aid'=>$attr->id,'value'=>'deneme']));
        $data=[
            "attr"=>$attr,
            "group"=>$attr->attributeGroup->name,
            "value"=>$attr->values
        ];
        //dd($data);
        return view('admin.attributeEdit',compact('data'));
    }

    public function updateAttribute(Request $request)
    {
        $attribute = \App\Attribute::find($request->get('id'));

        $newdata = [
            "name"=>$request->get("name"),
            "gid"=>$request->get("group_id")
        ];

        $values = $request->get("degerler");

        if ($values!=null){
            foreach ($values as $value){
                $arr[]=[
                    "value"=>$value,
                    "aid"=>$attribute->id
                ];
            }
        }

        if(!$attribute->values->isEmpty() && $values!=null) {
            $attribute->avalues()->detach();
            foreach ($arr as $data) {
                $attribute->avalues()->attach(false,array('aid' => $data["aid"], 'value' => $data["value"]));
            }
        }elseif(!$attribute->values->isEmpty() && $values==null){
            $attribute->avalues()->detach();
        }else{
            if ($values!=null) {
                foreach ($arr as $data) {
                    $attribute->avalues()->attach(false, array('aid' => $data["aid"], 'value' => $data["value"]));
                }
            }
        }

        try {
            $update = \App\Attribute::where('id','=',$request->get("id"))
                 ->update($newdata);

            $request->session()->flash("status",array(1,"Tebrikler."));

        } catch (Exception $e) {
             $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }

        return redirect("admin/attributes");
    }

    public function attributeDelete($id)
    {
        $dl = \App\Attribute::find($id);
        try {
            $dl->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/attributes");

    }

}
