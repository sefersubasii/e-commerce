<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews');
    }

    public function datatable()
    {
        $data = \App\ProductReview::all();
        return Datatables::of($data)->make(true);
        
    }
    
    public function edit($id)
    {
        $data = \App\ProductReview::find($id);
        return view("admin.reviewEdit",compact('data'));
    }


    public function update($id,Request $request)
    {
        $data = [
            "status"=>$request->get("status"),
            "author"=>$request->get("author"),
            "text"  =>$request->get("text"),
            "rating"=>$request->get("rating")
        ];

        try {
            \App\ProductReview::where('id','=',$request->get("id"))
                ->update($data);
            $request->session()->flash("status",array(1,"Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }

        return redirect("admin/reviews");
    }

    public function delete($id)
    {
        $del = \App\ProductReview::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }

        return redirect("admin/reviews");
    }

}
