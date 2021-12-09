<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class RefundRequestsController extends Controller
{

    public function index()
    {
        return view('admin.refundRequests');
    }

    public function datatable()
    {
        //$data = \App\RefundRequest::with('order.customer')->orderBy('created_at','desc')->get();
        $data = \App\RefundRequest::with(array('order.customer'=>function($query){
            $query->select('id','name','surname');
        }))->orderBy('created_at','desc')->get();
        return Datatables::of($data)->make(true);
    }

    public function edit($id)
    {
        $data = \App\RefundRequest::find($id);
        $ids= array_column($data->products->toArray(), 'product_id');
        $data->ids=$ids;
        //dd($data);
        return view("admin.refundRequestEdit",compact('data'));
    }

    public function update(Request $request)
    {
        $data=[
            "refundAmount"=>$request->get("price"),
            "status"=>$request->get("status")
        ];

        //dd($request->get('products'));
        $update = \App\RefundRequest::where('id','=',$request->get("id"))
            ->update($data);



        if ($request->get("status")==1)
        {
            foreach ($request->get("products") as $k => $v){
                $dataItems = [
                    "status" => isset($v["status"]) ? $v["status"] : 0,
                    "qty"    => $v["qty"]
                ];
                $update = \App\RefundReqProduct::where('product_id','=',$v["id"])
                    ->update($dataItems);
            }
            $updateOrder = \App\Order::where('id','=',$request->get("orderId"))
                ->update(["status"=>3]);
        }

        $request->session()->flash('status',array(1,"Başarılı!"));
        //return redirect("admin/refundRequests/edit/".$request->get("id"));
        return response()->json(["status"=>200]);

    }

    public function delete($id)
    {
        $del = \App\RefundRequest::find($id);

        try {
            $del->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(1,"Hata Oluştu."));
        }
        return redirect("admin/refundRequests");
    }

}
