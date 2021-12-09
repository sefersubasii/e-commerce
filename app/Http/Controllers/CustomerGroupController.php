<?php

namespace App\Http\Controllers;

use Mockery\CountValidator\Exception;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customerGroups');
    }

    public function Datatable()
    {
        $data = \App\MemberGroup::All();
        return Datatables::of($data)->make(true);
    }

    public function add()
    {
        return view('admin.customerGroupAdd');
    }
    public function create(Request $request)
    {
        $data=[
            "name"=>$request->get("name")
        ];

        try{
            \App\MemberGroup::create($data);
            $request->session()->flash('status', array(1,"Eklendi."));
        }catch (Exception $e){
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/customerGroups");
    }
    
    public function edit($id)
    {
        $data = \App\MemberGroup::find($id);
        return view("admin.customerGroupEdit",compact('data'));
    }

    public function update(Request $request,$id)
    {
        $data=[
            "name"=>$request->get("name")
        ];
        try{
            $update = \App\MemberGroup::find($id)
                ->update($data);
            $request->session()->flash('status', array(1,"Güncellendi."));
        }catch (Exception $e){
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/customerGroups");

    }

    public function delete($id)
    {
        $del = \App\MemberGroup::find($id);
        try{
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch (Exception $e){
            Session()->flash('status', array(0,"Hata Oluştu."));
        }
        return redirect("admin/customerGroups");
    }
    
    public function ajaxList()
    {
        return  \App\MemberGroup::paginate(15);
         
    }
}
