<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class StockWarningController extends Controller
{
    public function index()
    {
        return view('admin.stockWarnings');
    }

    public function datatable()
    {
        /*
        $data= \App\StockWarning::with(array('customer'=>function($query){
            $query->select('name','surname');
        }))->get();
        */
        $data = \App\StockWarning::All();
        return Datatables::of($data)->make(true);
    }

    public function delete($id)
    {
        $del=\App\StockWarning::find($id);
        try{
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));

        }catch(Exeption $e){
            Session()->flash('status', array(0,"Hata Oluştu."));
        }
        return redirect("admin/stockWarnings");
    }
    
}
