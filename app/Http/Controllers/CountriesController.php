<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class CountriesController extends Controller
{
    public function index()
    {
        return view('admin.countries');
    }

    public function addCountry()
    {
        return view("admin.countryAdd");
    }

    public function createCountry(Request $request)
    {
        $data=[
            "name"=>$request->get("name")
        ];

        $add = \App\Countries::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/countries");
    }
    
    public function editCountry($id)
    {
        $data = \App\Countries::find($id);
        return view('admin.countryEdit',compact('data'));
    }
    public  function updateCountry(Request $request)
    {
        $data=[
            "name"=>$request->get("name")
        ];

        try {
            \App\Countries::where('id','=',$request->get("id"))
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }

        return redirect('admin/countries');
    }

    public function countriesDatatable()
    {
        $countries = \App\Countries::orderBy('name')->get();

        return Datatables::of($countries)->make(true);
    }
    
    public function ajaxList()
    {
        return \App\Countries::paginate(15);
    }

    public function DeleteCountries($id)
    {
        $del = \App\Countries::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/countries");
    }

}
