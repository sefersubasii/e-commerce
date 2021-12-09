<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class RedirectionController extends Controller
{
   
    public function index()
    {
        return view("admin.redirections");
    }
    
    public function datatable()
    {
        $urls = \App\Redirection::All();
        return Datatables::of($urls)->make(true);
    }
    
    public function edit($id)
    {
        $data = \App\Redirection::find($id);
        return view('admin.redirectionEdit',compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = [
            "oldUrl"=>$request->get("oldUrl"),
            "newUrl"=>$request->get("newUrl")
        ];

        $update = \App\Redirection::where('id','=',$request->get("id"))
            ->update($data);

        $request->session()->flash('status',array(1,"Başarılı!"));

        return redirect("admin/redirection");
    }

    public function delete($id)
    {
        $del = \App\Redirection::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/redirection");
    }
    
    public function add()
    {
        return view("admin.redirectionAdd");
    }

    public function create(Request $request)
    {
        $data=[
            "oldUrl"=>$request->get("oldUrl"),
            "newUrl"=>$request->get("newUrl")
        ];
        $add = \App\Redirection::create($data);
        if ($add) {
            $request->session()->flash('status', array(1,"Eklendi."));
        }else{
            $request->session()->flash('status', array(0,"Hata Oluştu!"));
        }
        return redirect("admin/redirection");
    }

    
}
