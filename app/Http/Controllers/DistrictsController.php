<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class DistrictsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get("city_id")){
            $data=$request->get("city_id");
            return view('admin.districts',compact('data'));
        }else{
            return redirect("admin/cities?country_id".$request->get("country_id"));
        }
    }

    public function addCities(Request $request)
    {
        if ($request->get("city_id")){
            $city=\App\Cities::find($request->get("city_id"));
            $data=[
                "city"=>$request->get("city_id"),
                "country"=>$city->country_id
            ];

            return view('admin.districtsAdd',compact('data'));
        }else{
            return redirect("admin/cities?city_id".$request->get("city_id"));
        }
    }

    public function createCities(Request $request)
    {
        $data = [
            "name"=>$request->get("name"),
            "cities_id"=>$request->get("city_id")
        ];
        $add = \App\Districts::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/districts?city_id=".$request->get("city_id"));

    }

    public function editCities($id)
    {
        $data = \App\Districts::find($id);
        return view('admin.districtsEdit',compact('data'));
    }

    public function updateCities(Request $request)
    {
        $data=[
            "name"=>$request->get("name")
        ];
        try {
            \App\Districts::where('id','=',$request->get("id"))
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect('admin/districts?city_id='.$request->get("city_id"));
    }

    public function DeleteCities(Request $request , $id)
    {
        $del = \App\Districts::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/districts?city_id=".$request->get("cities_id"));
    }

    public function citiesDatatable(Request $request)
    {
        $data = \App\Districts::where('cities_id',$request->get("cities_id"))->orderBy('name')->get();
        //dd($data);
        return Datatables::of($data)->make(true);
    }

    public function ajaxList(Request $request)
    {
        return \App\Districts::where("cities_id",$request->get("city_id"))->paginate(15);
    }
}
