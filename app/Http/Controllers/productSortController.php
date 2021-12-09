<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class productSortController extends Controller
{
    public function index()
    {
        $data=\App\HomeSort::orderBy('sort', 'asc')->get();
        $data->postUrl="sortHome";
        $data->title="Anasayfa Ürün Sıralaması";
        return view('admin.sortHome',compact('data'));
    }

    public function homePost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\HomeSort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Anasayfa vitrini sıralaması yapıldı.');
    }
    
    public function popular()
    {
        $data=\App\PopularSort::orderBy('sort', 'asc')->get();
        $data->postUrl="sortPopular";
        $data->title="Popüler Ürün Sıralaması";
        return view('admin.sortHome',compact('data'));
    }

    public function popularPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\PopularSort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Popüler ürünler vitrini sıralaması yapıldı.');
    }

    public function newSort()
    {
        $data=\App\NewSort::orderBy('sort', 'asc')->get();
        $data->postUrl="sortNew";
        $data->title="Yeni Ürünler Sıralaması";
        return view('admin.sortHome',compact('data'));
    }

    public function newPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\NewSort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Yeni ürünler vitrini sıralaması yapıldı.');
    }

    public function sponsor()
    {
        $data=\App\SponsorSort::orderBy('sort', 'asc')->get();
        $data->postUrl="sortSponsor";
        $data->title="Sponsor Ürünler Sıralaması";
        return view('admin.sortHome',compact('data'));
    }

    public function sponsorPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\SponsorSort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Sponsor ürünler vitrini sıralaması yapıldı.');
    }

    public function discount()
    {
        $data = \App\Products::leftJoin('discount_sorts',function ($join){
                $join->on('products.id', '=', 'discount_sorts.product_id');
        })->select('products.id, products.title, products.stock_code, products.stock','products.discount_type','discount_sorts.sort')->where('stock','>=','1')->where('discount_type', '>', 0);

        $data->select('products.*',DB::raw('IF(`sort` IS NOT NULL, `sort`, 999) `sort`'));

        $data->orderBy('sort','asc');

        $data->orderBy('updated_at','desc');

        $data = $data->limit(600)->get();

        //dd($data);
        
        //$data=\App\DiscountSort::orderBy('sort', 'asc')->get();
        $data->postUrl="sortDiscount";
        $data->title="İndirimli Ürünler Sıralaması";
        return view('admin.sortDiscount',compact('data'));
    }

    public function discountPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        $limit=0;
        //dd($out['item']);
        foreach($out["item"] as $key => $value)
        {
            if ($limit<20) {
                \App\DiscountSort::where('sort',$key+1)->update(["sort"=>$key+1,"product_id"=>$value]);
                //$sort = \App\DiscountSort::firstOrNew(array('product_id' => $value));
                //$sort->sort = $key+1;
                //$sort->save();
            }
            $limit++;
        }
        \LogActivity::addToLog('İndirimli ürünler vitrini sıralaması yapıldı.');
    }

    public function categori()
    {
        $data=collect();
        $data->title="Kategori Ürün Sıralaması";
        return view('admin.sortCategory',compact('data'));
    }

    public function categoriPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\CategorySort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Kategori vitrini sıralaması yapıldı.');
    }

    public function sortCategoriAjaxList(Request $request)
    {
        return \App\Categori::where(['parent_id'=>$request->get('depth')])->paginate(15);
    }

    public function sortCategoriGetList(Request $request)
    {
        $data=\App\CategorySort::where(["category_id"=>$request->get("id")])->orderBy('sort', 'asc')->get();
        $data->postUrl="sortSponsor";
        $data->title="Sponsor Ürünler Sıralaması";
        $list="";

        foreach($data as $item) {
            $list.='<tr style="cursor: move;" id="item_'.$item->id.'">
                <td>'.$item->sort.'</td>
                <td>'.$item->product->name.'</td>
                <td>'.$item->product->stock_code.'</td>
                <td>'.$item->product->stock.'</td>
                <td>'.$item->product->price.'</td>
            </tr>';
        }

        $category    = \App\Categori::find($request->get("id"));
        $subcategory = \App\Categori::where(["parent_id"=>$category->id])->count();
        $subcategoryResp="";
        if($subcategory>0)
        {
            $unique=uniqid();
            $subcategoryResp='<div class="white-box">
            <div class="form-group">
                    <label for="categori'.$unique.'" class="col-sm-2 control-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="categori'.$unique.'" id="categori'.$unique.'" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                        </select>
                    </div>
                </div>
            </div>
            <script>
            $("#categori'.$unique.'").select2({
                language: "tr",
                ajax: {
                    url: "'.url("admin/sortCategori/ajax/list").'",
                    dataType: \'json\',
                    delay: 150,
                    success:function (response) {
                        //console.log(response);
                    },
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            depth:'.$request->get("id").'
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.title, extra:item.id };
                            }),
                            pagination: {
                                more: (params.page * 15) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: \'Kategori Seçiniz\',
            });
            $("body").on(\'change\', "#categori'.$unique.'", function (e) {
                //console.log(evt);
                var $this = $(this);
                var id = $(this).select2(\'data\')[0].extra;
                $.ajax({
                    url: "'.url("admin/sortCategori/getList").'",
                    type:"post",
                    //dataType:\'json\',
                    data: {_token:"'.csrf_token().'",id:id},
                    success: function(response){
                        //var obj = JSON.Parse(response);
                        $("tbody").html(response.tbody);
                        $this.parent().parent().parent().nextAll(".white-box").remove();
                        $("#selectArea").append(response.subcat);
                        //$(".alert").remove();
                    },beforeSend: function () {
                        HoldOn.open({
                            theme:"sk-bounce",
                            message: "YÜkleniyor..."
                        });
                    },
                    complete: function () {
                        HoldOn.close();
                    }
                });

            });
            </script>';
        }

        return response()->json(["tbody"=>$list,'subcat'=>$subcategoryResp]);
        /*return json_encode([
            "tbody"=>$list
            ]);
         */
    }

    public function brand()
    {
        $data=collect();
        $data->title="Marka Ürün Sıralaması";
        return view('admin.sortBrand',compact('data'));
    }

    public function brandPost(Request $request)
    {
        $str=$request->get("data");
        parse_str($str,$out);
        foreach($out["item"] as $key => $value)
        {
            \App\brandSort::where('id',$value)->update(["sort"=>$key+1]);
        }
        \LogActivity::addToLog('Marka vitrini sıralaması yapıldı.');
    }

    public function sortBrandGetList(Request $request)
    {
        $data=\App\BrandSort::where(["brand_id"=>$request->get("id")])->orderBy('sort', 'asc')->get();
        $data->postUrl="sortBrand";
        $data->title="Marka Ürünleri Sıralaması";
        $list="";

        foreach($data as $item) {
            $list.='<tr style="cursor: move;" id="item_'.$item->id.'">
                <td>'.$item->sort.'</td>
                <td>'.$item->product->name.'</td>
                <td>'.$item->product->stock_code.'</td>
                <td>'.$item->product->stock.'</td>
                <td>'.$item->product->price.'</td>
            </tr>';
        }
        return response()->json(["tbody"=>$list]);
    }

}
