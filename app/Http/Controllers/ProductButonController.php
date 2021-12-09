<?php

namespace App\Http\Controllers;

use App\ProductButon;
use App\Products;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;

class ProductButonController extends Controller
{
    
    public function index(Request $request)
    {
        $data = \App\ButonDescriptions::get();
        $allSubCategories=\App\Categori::where('parent_id',0)->get();
        if ($request->get('category_id')) {
            $cat = \App\Categori::select('id','title')->where('id',$request->get('category_id'))->first();    
            if ($cat) {
                $data=$cat;
            }
        }
        return view('admin.productButton',compact('data','allSubCategories'));
    }
    
    public function Datatable(Request $request)
    {
        //$productsBtn = \App\Products::with('buttons','brand')->get(["name","id","brand_id","tax","price","stock_type"]);
        /*$productsBtn = ProductButon::with(['product' => function($query) {
            $query->select(['name']);
        }])->get();
        */
        //return Datatables::of($productsBtn)->make(true);

        $length = intval($request->input('length'));
        $start  = intval($request->input('start'));
        $draw   = $request->get('draw');

        switch ($request->get('order')[0]['column']) {
            case '1':
                $orderBy1 = 'id';
                $orderBy2 = $request->get('order')[0]["dir"];
                break;
            case '3':
                $orderBy1 = 'name';
                $orderBy2 = $request->get('order')[0]["dir"];
                break;
            case '7':
                $orderBy1 = 'tax';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            case '8':
                $orderBy1 = 'price';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            case '9':
                $orderBy1 = 'stock';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            case '10':
                $orderBy1 = 'status';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            case '11':
                $orderBy1 = 'hsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;

            case '12':
                $orderBy1 = 'campsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            
            case '13':
                $orderBy1 = 'catsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;

            case '14':
                $orderBy1 = 'brsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;

            case '15':
                $orderBy1 = 'newsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;

            case '16':
                $orderBy1 = 'spsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;

            case '17':
                $orderBy1 = 'popsort';
                $orderBy2 = $request->get('order')[0]["dir"];
            break;
            default:
                $orderBy1 = 'id';
                $orderBy2 = 'DESC';
                break;
        }

        $count = Products::filterByRequest($request)->count();
        //$prods = Products::filterByRequest($request)->with('showcase','newSort','campaignSort','sponsorSort','popularSort','categori','categorySort','brandSort','brandName')->orderBy('created_at','DESC')->limit($length)->offset($start)->get(["id","name","brand_id","stock","price","tax","status","stock_type"]);
        $prods = Products::filterByRequest($request)->select('products.*')->with('categori','buttons','brand')->orderBy($orderBy1,$orderBy2)->limit($length)->offset($start)->groupBy('products.id')->get(/*["id","name","barcode","brand_id","stock","price","tax","status","stock_type"]*/);

        //dd($prods);
        $responseData = [
            "draw" => $draw,
            "recordsTotal"=>$count,
            "recordsFiltered"=>$count,
            "data"=>$prods
        ];

        return response()->json($responseData);




    }
    
    public function updateStatus(Request $request)
    {
        $data=[$request->get('which')=>$request->get('status')];
        \App\ProductButon::updateOrCreate(['product_id'=>$request->get('id')],$data);
        return redirect("admin/productButton");
    }

    public function descriptions()
    {
        $data = \App\ButonDescriptions::get();
        return view("admin/productButtonDescriptions",compact('data'));
    }


    public function updatePD(Request $request)
    {
        
     
        foreach ($request->get('title') as $key => $value) {
            if ($value=="") {
                $value=$key+1;
            }
            $data=["title"=>$value];
            \App\ButonDescriptions::where('id',$key+1)->update($data);
        }

        foreach ($request->file('c') as $k => $v) {
            
            if($v!=null){
                $data=[];
                $image = $v;
                $destinationPath = public_path().'/src/uploads/productButton/descriptions/';
                $filename = str_replace($image->getClientOriginalExtension(), ".".$image->getClientOriginalExtension(), str_slug($image->getClientOriginalName())) ;
                $image->move($destinationPath, $filename);
                $data["image"] = $filename;

                // old image delete
                $old = \App\ButonDescriptions::where('id',$k+1)->first();
                if (!empty($old->image) && $old->image!=$data["image"]){
                    $destinationPath = public_path().'/src/uploads/productButton/descriptions/'.$old->image;
                    if(file_exists($destinationPath)){
                        @unlink($destinationPath);
                    }
                }
                
                
                \App\ButonDescriptions::where('id',$k+1)->update($data);
            }

        }



        return redirect('admin/productButton/descriptions');
        
    }



}
