<?php

namespace App\Http\Controllers;

use App\Services\Price;
use App\Services\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Output\Output;
use Yajra\Datatables\Datatables;

class OutputController extends Controller
{

    public function index()
    {
        return view('admin.outputList');
    }

    public function add()
    {
        return view('admin.outputAdd');
    }

    public function create(Request $request)
    {
        $data = [
            "selectedColums"  => json_encode($request->get("selectedColumns")),
            'priceWithTaxPer' => $request->get('priceWithTaxPer'),
            "names"           => json_encode($request->get("names")),
            "categories"      => json_encode($request->get("categories")),
            "brands"          => json_encode($request->get("brands")),
            "otherFilters"    => json_encode($request->get("otherFilters")),
            "rootElementName" => $request->get("rootElementName"),
            "loopElementName" => $request->get("loopElementName"),
            "name"            => $request->get("outputName"),
            "description"     => $request->get("outputDescription"),
            "permCode"        => uniqid(),
            "status"          => 1,
        ];

        try {
            $add = \App\output::create($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/output/list/');
    }

    public function copy($id)
    {
        $copy          = \App\output::where("id", $id)->first();
        $new           = $copy->replicate();
        $new->permCode = uniqid();
        $new->name     = $copy->name . " Kopya";
        $new->save();
        return redirect('admin/output/list/');
    }

    public function delete($id)
    {
        $del = \App\output::find($id);
        try {
            $del->delete();
            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/output/list");
    }

    public function datatable()
    {
        $outs = \App\output::All();

        return Datatables::of($outs)->make(true);
    }
    public function edit($id)
    {
        $data = \App\output::find($id);

        $selectedCats   = \App\Categori::whereIn("id", json_decode($data->categories, true))->get("id", "title");
        $selectedBrands = \App\Brand::whereIn("id", json_decode($data->brands, true))->get();

        $data->selectedCats   = $selectedCats;
        $data->selectedBrands = $selectedBrands;

        return view('admin.outputEdit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $out  = \App\output::find($id);
        $data = [
            "selectedColums"  => json_encode($request->get("selectedColumns")),
            "additionalPrice" => json_encode($request->get("additionalPrice")),
            "names"           => json_encode($request->get("names")),
            "categories"      => json_encode($request->get("categories")),
            "brands"          => json_encode($request->get("brands")),
            "otherFilters"    => json_encode($request->get("otherFilters")),
            "rootElementName" => $request->get("rootElementName"),
            "loopElementName" => $request->get("loopElementName"),
            "name"            => $request->get("outputName"),
            "description"     => $request->get("outputDescription"),
        ];

        try {
            $update = $out->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/output/edit/' . $id);
    }

    public function exportProductXml($permCode)
    {
        return $this->outputProductXml($permCode, true);
    }

    public function outputProductXml($permCode, $download = false)
    {

        $data = \App\output::where("permCode", $permCode)->first();

        //$selectedColumns=["id","name","brand","stock_code","status","categoryTree","categoryId","brandCode","priceTaxWithCur","price","slug","barcode","brand_id","priceWithTax","discountedPrice","rebatedPriceWithoutTax","discount","discount_type","stockType","tax","stockStatus","image","category","rebatePercent","multipleOptions1","isOptionedProduct","seo","seoTitle","keywords","image1","image2","image3","image4","image5","image6","desi","stockAmount"];
        $selectedColumns = $data->selectedColums;

        $selectedColumns[] = "condition";

        $selectDbColumn = ["id", "stock_type", "content", "name"];
        $withArr        = [];

        $names = $data->names;

        if (in_array("id", $selectedColumns)) {
            array_push($selectDbColumn, "id");
        }
        if (in_array("name", $selectedColumns)) {
            array_push($selectDbColumn, "name");
        }
        if (in_array("barcode", $selectedColumns)) {
            array_push($selectDbColumn, "barcode");
        }
        if (in_array("stock_code", $selectedColumns)) {
            array_push($selectDbColumn, "stock_code");
        }
        if (in_array("status", $selectedColumns)) {
            array_push($selectDbColumn, "status");
        }
        if (in_array("price", $selectedColumns)) {
            array_push($selectDbColumn, "price");
        }
        if (in_array("slug", $selectedColumns)) {
            array_push($selectDbColumn, "slug");
        }
        if (in_array("brand_id", $selectedColumns)) {
            array_push($selectDbColumn, "brand_id");
        }
        if (in_array("discount", $selectedColumns)) {
            array_push($selectDbColumn, "discount");
        }
        if (in_array("discount_type", $selectedColumns)) {
            array_push($selectDbColumn, "discount_type");
        }
        if (in_array("seo", $selectedColumns) || in_array("seoTitle", $selectedColumns) || in_array("keywords", $selectedColumns)) {
            array_push($selectDbColumn, "seo");
        }
        if (in_array("tax", $selectedColumns)) {
            array_push($selectDbColumn, "tax");
        }

        //with
        if (in_array("categoryTree", $selectedColumns)) {
            array_push($withArr, "categori");
        }
        if (in_array("categoryId", $selectedColumns)) {
            array_push($withArr, "categori");
        }
        if (in_array("category", $selectedColumns)) {
            array_push($withArr, "categori");
        }

        if (in_array("categoryId2", $selectedColumns)) {
            array_push($withArr, "categori");
        }
        if (in_array("category2", $selectedColumns)) {
            array_push($withArr, "categori");
        }

        if (in_array("categoryId3", $selectedColumns)) {
            array_push($withArr, "categori");
        }
        if (in_array("category3", $selectedColumns)) {
            array_push($withArr, "categori");
        }

        if (in_array("brandCode", $selectedColumns)) {
            array_push($withArr, "brand");
        }
        if (in_array("priceTaxWithCur", $selectedColumns)) {
            $selectDbColumn[] = "tax_status";
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "tax";
        }
        if (in_array("desi", $selectedColumns)) {
            array_push($withArr, "shippings");
        }

        if (in_array("priceWithTax", $selectedColumns) || in_array("priceWithTaxTL", $selectedColumns)) {
            $selectDbColumn[] = "tax_status";
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "tax";
            //array_push($withArr,"priceWithTax");
        }

        if (in_array("discountedPrice", $selectedColumns)) {
            //array_push($withArr,"discountedPrice");
            $selectDbColumn[] = "tax";
            $selectDbColumn[] = "tax_status";
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "discount";
            $selectDbColumn[] = "discount_type";
        }

        if (in_array("discountedPriceTL", $selectedColumns)) {
            //array_push($withArr,"discountedPrice");
            $selectDbColumn[] = "tax";
            $selectDbColumn[] = "tax_status";
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "discount";
            $selectDbColumn[] = "discount_type";
        }
        if (in_array("rebatePercent", $selectedColumns)) {
            //array_push($withArr,"discountedPrice");
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "discount";
            $selectDbColumn[] = "discount_type";
        }
        if (in_array("rebatedPriceWithoutTax", $selectedColumns)) {
            //array_push($withArr,"rebatedPriceWithoutTax");
            $selectDbColumn[] = "price";
            $selectDbColumn[] = "discount";
            $selectDbColumn[] = "discount_type";
        }
        if (in_array("image", $selectedColumns)) {
            array_push($withArr, "images");
        }
        if (in_array("brand", $selectedColumns)) {
            array_push($selectDbColumn, "brand_id");
            array_push($withArr, "brand");
        }
        if (in_array("stockStatus", $selectedColumns)) {
            array_push($withArr, "variant");
            $selectDbColumn[] = "stock";
        }
        if (in_array("stockAmount", $selectedColumns)) {
            array_push($withArr, "variant");
            $selectDbColumn[] = "stock";
        }
        if (in_array("multipleOptions1", $selectedColumns)) {
            array_push($withArr, "variant");
        }
        if (in_array("isOptionedProduct", $selectedColumns)) {
            array_push($withArr, "variant");
        }
        if (in_array("isOptionOfAProduct", $selectedColumns)) {
            array_push($withArr, "isOptionOfAProduct");
        }
        if (in_array("rootProductId", $selectedColumns)) {
            array_push($withArr, "rootProductId");
        }
        if (in_array("rootProductStockCode", $selectedColumns)) {
            array_push($withArr, "rootProductStockCode");
        }

        $request = new Request();
        $request->replace([
            'category_ids' => json_decode($data->categories),
            'brand_ids'    => json_decode($data->brands),
        ]);

        //other filters
        $otherFilters = json_decode($data->otherFilters);
        if (@in_array("1", $otherFilters)) {
            $request->query->add(['onlyStock' => true]);
            $selectDbColumn[] = "stock";
        }

        $request->query->add(['status' => 1]);

        //return dd($data->catMap->pluck('local_cat_id')->toArray());

        //return dd($data->catMap->pluck('remote_cat_id')->toArray());
        $catMaps = [];
        //return array_combine($data->catMap->pluck('local_cat_id')->toArray(), $data->catMap->pluck('remote_cat_id')->toArray());
        if (in_array("categoryMap", $selectedColumns)) {
            array_push($withArr, "categori");
            $catMaps = array_combine($data->catMap->pluck('local_cat_id')->toArray(), $data->catMap->pluck('remote_cat_id')->toArray());
        }

        set_time_limit(0);
        ini_set('memory_limit', '3072M');
        if (!empty($withArr)) {
            $pro = \App\Products::filterByRequest($request)->with($withArr)->select($selectDbColumn)->get();
        } else {
            $pro = \App\Products::filterByRequest($request)->select($selectDbColumn)->get();
        }

        // $pro = $pro->toArray();

        $price   = new Price();
        $product = new Product();

        $content = view('admin.outputXml', compact(
            'pro', 'names', 'selectedColumns', 'price', 'product', 'data', 'catMaps'
        ))->render();

        if ($download == true) {
            return response($content)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With')
                ->header('Cache-Control', 'public')
                ->header('Content-Description', 'File Transfer')
                ->header('Content-Disposition', 'attachment; filename='.($data->name ?? 'products').'.xml')
                ->header('Content-Transfer-Encoding', 'binary')
                ->header('Content-Type', 'application/xml');
        } else {
            return response($content)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With')
                ->header('Content-Type', 'application/xml');
        }
    }

    public function catMap(Request $request, $id)
    {
        // $all = \App\OutputCatMap::where('output_id',$id)->get();
        // return dd($all);
        $localCat = \App\Categori::where(['parent_id' => 0, 'status' => 1])->get(['id', 'title']);
        return view('admin.outputCatMap', compact('localCat'));
    }

    public function catMapDatatable(request $request, $id)
    {
        $outs = \App\OutputCatMap::with('cat')->where(['output_id' => $id])->get();
        return Datatables::of($outs)->make(true);
    }

    public function deletecatMap(request $request, $id)
    {
        $del   = \App\OutputCatMap::find($id);
        $retId = $del->output_id;
        try {
            $del->delete();
            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }
        return redirect("admin/output/catMap/" . $retId);
    }

    public function createCatMap(Request $request)
    {

        $data = [
            "output_id"     => $request->get("output_id"),
            "remote_cat_id" => $request->get("remote_cat_id"),
            "local_cat_id"  => $request->get("categoryId"),
        ];

        try {
            $add = \App\OutputCatMap::create($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect("admin/output/catMap/" . $request->get('output_id'));
    }
}
