<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class CitiesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get("country_id")){
            $data=$request->get("country_id");
            return view('admin.cities',compact('data'));
        }else{
            return redirect("admin/countries");
        }
    }

    public function addCities(Request $request)
    {
        if ($request->get("country_id")){
            $data=$request->get("country_id");
            return view('Admin.citiesAdd',compact('data'));
        }else{
            return redirect("admin/countries");
        }
    }
    
    public function createCities(Request $request)
    {
        $data = [
            "name"=>$request->get("name"),
            "country_id"=>$request->get("country_id"),
            "status"=>1
        ];
        $add = \App\Cities::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/cities?country_id=".$request->get("country_id"));
        
    }
    
    public function editCities($id)
    {
        $data = \App\Cities::find($id);
        return view('admin.citiesEdit',compact('data'));
    }

    public function updateCities(Request $request)
    {
        $data=[
            "name"=>$request->get("name"),
            "status"=>$request->get("status")
        ];
        try {
            \App\Cities::where('id','=',$request->get("id"))
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect('admin/cities?country_id='.$request->get("country_id"));
    }

    public function DeleteCities(Request $request , $id)
    {
        $del = \App\Cities::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/cities?country_id=".$request->get("country_id"));
    }

    public function citiesDatatable(Request $request)
    {
        $data = \App\Cities::where('country_id',$request->get("country_id"))->orderBy('name')->get();
        //dd($data);
        return Datatables::of($data)->make(true);
    }

    public function ajaxList(Request $request)
    {

        return \App\Cities::where("country_id",$request->get("country_id"))->paginate(15);
    }
}
