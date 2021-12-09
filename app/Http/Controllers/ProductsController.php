<?php

namespace App\Http\Controllers;

use App\Helpers\HelpersNew;
use App\homeSort;
use App\productImage;
use App\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Image;
use Mockery\CountValidator\Exception;
use Yajra\Datatables\Datatables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $allSubCategories = \App\Categori::where('parent_id', 0)->get();
        $data             = null;
        if ($request->get('category_id')) {
            $cat = \App\Categori::select('id', 'title')->where('id', $request->get('category_id'))->first();
            if ($cat) {
                $data = $cat;
            }
        }
        return view('admin.products', compact('data', 'allSubCategories'));
    }

    public function add(){
        return view('admin.productAdd');
    }

    public function productsDatatable(Request $request)
    {
        $length  = intval($request->input('length'));
        $start   = intval($request->input('start'));
        $draw    = $request->get('draw');
        $columns = $request->get('columns');
        $order   = $request->get('order');

        $orderColumn = $columns[$order[0]['column']] ?: 'id';
        $orderDir    = 'DESC';

        if (isset($orderColumn['orderable']) && $orderColumn['orderable']) {
            $orderColumn = $orderColumn['name'];
            $orderDir    = $order[0]['dir'];
        } else {
            $orderColumn = 'id';
        }

        $products = Products::filterByRequest($request);

        $count = $products->count();

        $prods = $products
            ->select(
                'products.*',
                'popular_sorts.sort as popsort',
                'sponsor_sorts.sort as spsort',
                'new_sorts.sort as newsort',
                'brand_sorts.sort as brsort',
                'category_sorts.sort as catsort',
                'home_sorts.sort as hsort',
                'campaign_sorts.sort as campsort'
            )
            ->leftjoin('popular_sorts', 'popular_sorts.product_id', '=', 'products.id')
            ->leftjoin('sponsor_sorts', 'sponsor_sorts.product_id', '=', 'products.id')
            ->leftjoin('new_sorts', 'new_sorts.product_id', '=', 'products.id')
            ->leftjoin('brand_sorts', 'brand_sorts.product_id', '=', 'products.id')
            ->leftjoin('category_sorts', 'category_sorts.product_id', '=', 'products.id')
            ->leftjoin('home_sorts', 'home_sorts.product_id', '=', 'products.id')
            ->leftjoin('campaign_sorts', 'campaign_sorts.product_id', '=', 'products.id')
            ->with(
                'showcase',
                'newSort',
                'campaignSort',
                'sponsorSort',
                'popularSort',
                'categori',
                'categorySort',
                'brandSort',
                'brandName'
            )
            ->orderBy($orderColumn, $orderDir)
            ->limit($length)
            ->offset($start)
            ->groupBy('products.id')
            ->get();

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'            => $prods,
        ]);
    }

    public function ajaxList(Request $request)
    {
        $product = Products::select('name', 'id', 'stock_type');

        if (!empty($request->get('q'))) {
            return $product
                ->where('name', 'like', '%' . $request->get('q') . '%')
                ->paginate(15);
        }

        return $product->paginate(15);
    }

    public function createProduct(Request $request)
    {
        $seo = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
        ];
        if (!empty($request->get('discountstartdate'))) {
            $discountstartdate = Carbon::parse($request->get('discountstartdate'));
        } else {
            $discountstartdate = null;
        }
        if (!empty($request->get('discountstartdate'))) {
            $discountfinishdate = Carbon::parse($request->get('discountfinishdate'));
        } else {
            $discountfinishdate = null;
        }
        $data = array(
            "name"                 => $request->get("name"),
            "slug"                 => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("name")),
            "brand_id"             => $request->has("brand_id") ? $request->get("brand_id") : 0,
            "stock_code"           => $request->has("stock_code") ? $request->get("stock_code") : 0,
            "stock_type"           => $request->get("stock_type"),
            "stock"                => $request->get("stock"),
            "barcode"              => $request->get("barcode"),
            "price"                => str_replace(",", ".", $request->get("price")),
            "maximum"              => $request->has("maximum") ? $request->get("maximum") : null,
            "package"              => $request->has("package") ? $request->get("packageCount") : 0,
            "tax_status"           => $request->has("vat_inclusive") ? $request->get("vat_inclusive") : 0,
            "tax"                  => $request->get("tax_id"),
            "discount_type"        => $request->get("discount_type"),
            "discount"             => $request->get("discount"),
            "content"              => $request->get("description"),
            "seo"                  => json_encode($seo),
            "status"               => $request->get("status"),
            'costprice'            => str_replace(",", ".", $request->get("costprice")),
            'discount_start_date'  => $discountstartdate,
            'discount_finish_date' => $discountfinishdate,
        );

        $data["final_price"] = $this->discountedPrice($this->withTax($data["price"], $data["tax_status"], $data["tax"]), $data["discount_type"], $data["discount"]);

        $add = \App\Products::create($data);

        $addPro = \App\Products::find($add->id);

        if (!empty($request->get("categories"))) {
            $myArray = explode(',', $request->get("categories"));
            $addPro->categori()->attach($myArray);
        }

        //ürün kargo-desi bilgileri
        $shippingData = [
            "pid"            => $add->id,
            "desi"           => $request->has("cargo_weight") ? $request->get("cargo_weight") : 0,
            "shipping_price" => $request->has("shipping_price") ? $request->get("shipping_price") : 0,
            "use_system"     => $request->has("use_system") ? 1 : 0,
        ];
        $proShipping = \App\Products_shipping::create($shippingData);

        //ürüne indirim tanımlandıysa indirimli ürün vitrinine ekleyelim.
        if ($request->get("discount_type") > 0) {
            if (\App\DiscountSort::orderBy('sort', 'desc')->first()) {
                $count = \App\DiscountSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            $dataDiscount = [
                "product_id" => $add->id,
                "sort"       => $count,
            ];
            $addDiscountSort = \App\DiscountSort::create($dataDiscount);
        }

        if ($add) {
            \LogActivity::addToLog('Ürün oluşturuldu.', $request->all());
            $request->session()->flash('status', array(1, "Eklendi."));
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        //return redirect("admin/products");
        return redirect('admin/products/edit/' . $addPro->id);
    }

    public function editProduct($id)
    {
        $data = Products::find($id);

        //$pro = new Product();

        //dd($pro->stockStatus($data));

        $data->brand_name = $data->brand;
        $check            = [];

        if (count($data->variant) > 0) {
            $data->variants = $data->variant;
        }
        //dd($data->variant[0]->value[0]);

        $varArr      = [];
        $selectedVar = [];
        $varArrCheck = [];

        if (count($data->variant) > 0) {
            foreach ($data->variant as $var) {
                foreach ($var->value as $val) {
                    if (!in_array($val->vid, $varArrCheck)) {
                        $vrGrp    = \App\Variant::find($val->vid);
                        $varArr[] = $vrGrp;
                        $arr2[]   = \App\Variant::find($val->vid)->values;
                    }
                    $varArrCheck[] = $val->vid;
                    if (!in_array($val->id, $selectedVar)) {
                        $selectedVar[] = $val->id;
                    }
                }
            }
            $data->variantGroup  = $varArr;
            $data->variantValues = $arr2;
            $data->selectedVar   = $selectedVar;
        }

        //dd($data);

        /*

        if (count($data->variant)>0) {
        $data->variants=$data->variant;
        foreach ($data->variants as $v){
        $zzz[]=$v->vvid;
        }

        $data->selectedVar=$zzz;

        foreach ($data->variants as $var){
        $vrGrp=\App\Variant::find($var->vid);
        if (!in_array($vrGrp->id,$check)){
        $arr[]=$vrGrp;
        $arr2[]=\App\Variant::find($var->vid)->values;
        }
        $check[]=$vrGrp->id;

        }
        $data->variantGroup=$arr;
        $data->variantValues=$arr2;
        }

         */

        //dd($data->attributes);

        if (count($data->attributes) > 0) {
            foreach ($data->attributes as $attr) {
                $selected[]     = $attr->aid;
                $selectedVals[] = $attr->id;
                $a              = \App\Attribute::find($attr->aid);
                if (!in_array($a->attributeGroup->id, $check)) {
                    $attGroupArr[] = $a->attributeGroup;
                }
                $check[] = $a->attributeGroup->id;
                //dd($a->attributeGroup);
            }

            $data->attrGroups  = $attGroupArr;
            $data->attr        = $selected;
            $data->selectedVal = $selectedVals;
        }

        //dd($data);

        //dd($data->attrGroups[0]->attributes);

        $data->image = $data->images;
        $data->image = json_decode($data->image["images"]);

        //print_r(json_decode($data->image["images"]));
        //die();
        //dd($data);

        $selectedCategoryIds = ''; 
        if(isset($data->categori)){
            $selectedCategoryIds = collect($data->categori)->pluck('id')->implode(',');
        }

        return view('admin.productEdit', compact('data', 'data', 'selectedCategoryIds'));
    }

    public function discountedPrice($price, $type, $discount)
    {
        switch ($type) {
            case 0:
                return $price;
                break;
            case 1:
                return $price - (($price * $discount) / 100);
                break;
            case 2:
                return $discount;
                break;
            case 3:
                return $price - $discount;
                break;
        }
    }

    public function withTax($price, $tax_status, $tax)
    {
        $price = doubleval($price);
        switch ($tax_status) {
            case 0:
                return $price + (($price * $tax) / 100);
                break;
            case 1:
                return $price;
                break;
        }
    }

    public function updateProduct(Request $request)
    {

        $pro = \App\Products::find($request->get("id"));
        $seo = [
            "seo_title"       => $request->get("seo_title"),
            "seo_keywords"    => $request->get("seo_keywords"),
            "seo_description" => $request->get("seo_description"),
        ];
        if (!empty($request->get('discountstartdate')) && $request->get('discountstartdate') != "Invalid date") {
            $discountstartdate = Carbon::parse($request->get('discountstartdate'));
        } else {
            $discountstartdate = null;
        }
        if (!empty($request->get('discountfinishdate')) && $request->get('discountfinishdate') != "Invalid date") {
            $discountfinishdate = Carbon::parse($request->get('discountfinishdate'));
        } else {
            $discountfinishdate = null;
        }
        $data = array(
            "name"                 => $request->get("name"),
            "slug"                 => str_slug($request->has("custom_url") ? $request->get("slug") : $request->get("name")),
            "brand_id"             => $request->has("brand_id") ? $request->get("brand_id") : 0,
            "stock_code"           => $request->has("stock_code") ? $request->get("stock_code") : 0,
            "stock_type"           => $request->get("stock_type"),
            "stock"                => $request->get("stock"),
            "barcode"              => $request->get("barcode"),
            "price"                => str_replace(",", ".", $request->get("price")),
            "maximum"              => $request->has("maximum") ? $request->get("maximum") : null,
            "package"              => $request->has("package") ? $request->get("packageCount") : 0,
            "wholesale"            => $request->has('wholesale') ? 1 : 0,
            "tax_status"           => $request->has("vat_inclusive") ? $request->get("vat_inclusive") : 0,
            "tax"                  => $request->get("tax_id"),
            "discount_type"        => $request->get("discount_type"),
            "discount"             => $request->get("discount"),
            "content"              => $request->get("description"),
            "seo"                  => json_encode($seo),
            "status"               => $request->get("status"),
            'costprice'            => str_replace(",", ".", $request->get("costprice")),
            'discount_start_date'  => $discountstartdate,
            'discount_finish_date' => $discountfinishdate,
        );

        //final_price
        $priceWithTax        = $this->withTax($data["price"], $data["tax_status"], $data["tax"]);
        $data["final_price"] = $this->discountedPrice($priceWithTax, $data["discount_type"], $data["discount"]);

        //dd($request->all());
        if (!empty($request->get("categories"))) {
            $myArray = explode(',', $request->get("categories"));
            $pro->categori()->detach();
            $pro->categori()->attach($myArray);
        }

        //ürüne indirim tanımlandıysa indirimli ürün vitrinine ekleyelim yada çıkaralım.
        if ($request->get("discount_type") > 0) {
            if (\App\DiscountSort::where('product_id', '=', $pro->id)->count() == 0) {
                if (\App\DiscountSort::orderBy('sort', 'desc')->first()) {
                    $count = \App\DiscountSort::orderBy('sort', 'desc')->first()->sort + 1;
                } else {
                    $count = 1;
                }
                $dataDiscount = [
                    "product_id" => $pro->id,
                    "sort"       => $count,
                ];
                $addDiscountSort = \App\DiscountSort::create($dataDiscount);
            }
        } else {
            if (\App\DiscountSort::where('product_id', '=', $pro->id)->exists()) {
                \App\DiscountSort::where('product_id', '=', $pro->id)->delete();
            }
        }

        //ürün kargo-desi bilgileri
        $shipping                 = \App\Products_shipping::firstOrNew(array('pid' => $pro->id));
        $shipping->desi           = $request->get("cargo_weight");
        $shipping->shipping_price = $request->has("shipping_price") ? $request->get("shipping_price") : 0;
        $shipping->use_system     = $request->has("use_system") ? 1 : 0;
        $shipping->save();

        if ($pro->showcase != null && $request->has("s_showcase") == false) {
            $pro->showcase()->delete();
        } elseif ($pro->showcase == null && $request->has("s_showcase") == true) {
            if (\App\homeSort::orderBy('sort', 'desc')->first()) {
                $count = \App\homeSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\homeSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->newSort != null && $request->has("s_new") == false) {
            $pro->newSort()->delete();
        } elseif ($pro->newSort == null && $request->has("s_new") == true) {
            if (\App\newSort::orderBy('sort', 'desc')->first()) {
                $count = \App\newSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\newSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->campaignSort != null && $request->has("s_campaign") == false) {
            $pro->campaignSort()->delete();
        } elseif ($pro->campaignSort == null && $request->has("s_campaign") == true) {
            if (\App\campaignSort::orderBy('sort', 'desc')->first()) {
                $count = \App\campaignSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\campaignSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->sellSort != null && $request->has("s_sell") == false) {
            $pro->sellSort()->delete();
        } elseif ($pro->sellSort == null && $request->has("s_sell") == true) {
            if (\App\sellSort::orderBy('sort', 'desc')->first()) {
                $count = \App\sellSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\sellSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->sponsorSort != null && $request->has("s_sponsor") == false) {
            $pro->sponsorSort()->delete();
        } elseif ($pro->sponsorSort == null && $request->has("s_sponsor") == true) {
            if (\App\sponsorSort::orderBy('sort', 'desc')->first()) {
                $count = \App\sponsorSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\sponsorSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->popularSort != null && $request->has("s_popular") == false) {
            $pro->popularSort()->delete();
        } elseif ($pro->popularSort == null && $request->has("s_popular") == true) {
            if (\App\popularSort::orderBy('sort', 'desc')->first()) {
                $count = \App\popularSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            \App\popularSort::create(["product_id" => $request->get("id"), "sort" => $count]);
        }

        if ($pro->brandSort != null && $request->has("s_brand") == false) {
            $pro->brandSort()->delete();
        } elseif ($pro->brandSort == null && $request->has("s_brand") == true) {
            if (\App\brandSort::orderBy('sort', 'desc')->first()) {
                $count = \App\brandSort::orderBy('sort', 'desc')->first()->sort + 1;
            } else {
                $count = 1;
            }
            if (!empty($pro->brand)) {
                \App\brandSort::create(["product_id" => $request->get("id"), "brand_id" => $pro->brand->id, "sort" => $count]);
            }
        }

        if ($request->has("s_category") == false) {
            $pro->categorySort()->delete();
        } else {
            $pro->categorySort()->delete();
            $sayac = 0;
            foreach ($pro->categori as $cat => $item) {
                $sayac++;
                $dataCatUpdate = [
                    "category_id" => $item->id,
                    "product_id"  => $request->get("id"),
                    "sort"        => $sayac,
                ];
                \App\categorySort::create($dataCatUpdate);
            }
        }

        if (!empty($request->get("variants")) && !$pro->variant->isEmpty()) {
            $pro->variant()->delete();

            foreach ($request->get("variants") as $variant) {
                $variantData = [
                    "pid"        => $request->get("id"),
                    "name"       => $variant["name"],
                    "vals"       => $variant["values"],
                    "stock_code" => $variant["stock_code"],
                    "stock"      => $variant["stock"],
                    "price"      => $variant["price"],
                    "desi"       => $variant["weight"],
                ];
                $addVariant = \App\Product_variant::create($variantData);

                if (strpos($variant["values"], '-') !== false) {
                    $exp = explode("-", $variant["values"]);
                } else {
                    $exp[0] = $variant["values"];
                }

                for ($i = 0; $i < count($exp); $i++) {
                    $addVariant->value()->attach($exp[$i]);
                }
            }
        } elseif (!$pro->variant->isEmpty() && $request->get("variants") == null) {
            $pro->variant()->delete();
        } else {
            if ($request->get("variants") != null) {
                foreach ($request->get("variants") as $variant) {
                    $variantData = [
                        "pid"        => $request->get("id"),
                        "name"       => $variant["name"],
                        "vals"       => $variant["values"],
                        "stock_code" => $variant["stock_code"],
                        "stock"      => $variant["stock"],
                        "price"      => $variant["price"],
                        "desi"       => $variant["weight"],
                    ];
                    $addVariant = \App\Product_variant::create($variantData);

                    if (strpos($variant["values"], '-') !== false) {
                        $exp = explode("-", $variant["values"]);
                    } else {
                        $exp[0] = $variant["values"];
                    }

                    for ($i = 0; $i < count($exp); $i++) {
                        $addVariant->value()->attach($exp[$i]);
                    }
                }
            }
        }

        if (!empty($request->get("attributes"))) {
            $degerler = $request->get("attributes");
            foreach ($degerler as $deger) {
                $attrArr[] = $deger["value_id"];
            }
        }

        if (count($request->get("relateds")) > 0) {
            $relateds = $request->get("relateds");
            foreach ($relateds as $related) {
                $relatedsArr[] = $related;
            }
        }

        try {
            $update = $pro
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Ürün düzenlendi.', $request->all());

            if (!empty($request->get("attributes")) && !$pro->attributes->isEmpty()) {
                $pro->attributes()->detach();
                $pro->attributes()->attach($attrArr);
            } elseif (!$pro->attributes->isEmpty() && $request->get("attributes") == null) {
                $pro->attributes()->detach();
            } else {
                if (isset($attrArr) && $attrArr != null) {
                    $pro->attributes()->attach($attrArr);
                }
            }

            if (!empty($request->get("relateds")) && !$pro->relateds->isEmpty()) {
                $pro->relateds()->detach();
                $pro->relateds()->attach($relatedsArr);
            } elseif (!$pro->relateds->isEmpty() && $request->get("relateds") == null) {
                $pro->relateds()->detach();
            } else {
                if (isset($relatedsArr) && $relatedsArr != null) {
                    $pro->relateds()->attach($relatedsArr);
                }
            }

            //elasticsearch product update
            /*
        $product = \App\Products::select(['id','barcode','name','slug','discount','discount_type','stock','stock_type','price','final_price'])->where('id',$pro->id)->first();
        $client = ClientBuilder::create()->build();
        $params = [
        'index' => 'catalogeko',
        'type' => 'products',
        'id' => $pro->id
        ];
        $params['body']['doc'] = $product->toArray();
        //$params['body'][] = $product->toArray();
        $params['body']['upsert']=['counter' => 1];

        $client->update($params);
         */
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect("admin/products/edit/" . $request->get("id"));
    }

    public function productsDelete($id)
    {
        $pro = \App\Products::find($id);

        try {
            if ($pro->images) {
                $imgs = $pro->images->images;
                foreach (json_decode($imgs, true) as $item) {
                    // Uzak sunucu resim sil
                    remoteImageDelete($id, $item);

                    $pathToImage = public_path() . '/src/uploads/products/' . $id . '/' . $item;
                    if (File::exists($pathToImage)) {
                        unlink($pathToImage);
                    }
                }
            }

            //$client = ClientBuilder::create()->build();
            //$params = [
            //    'index' => 'catalogeko',
            //    'type' => 'products',
            //    'id' => $pro->id
            //];
            //$client->delete($params);

            $pro->delete();

            \LogActivity::addToLog('Ürün silindi.');

            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/products");
    }

    public function imageUpload(Request $request)
    {
        $productId = $request->get('id');

        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('file');

        $destinationPathMin = public_path('src/uploads/products/min/' . $productId . '/');
        $destinationPath    = public_path('src/uploads/products/' . $productId . '/');

        $filename = $request->get('name') . '-' . md5(uniqid(mt_rand(), true)) . '.' . $image->getClientOriginalExtension();

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        // Resmi Kaydet
        Image::make($image)->save($destinationPath . $filename, 80, 'jpg');

        $images = \App\productImage::where('pid', $productId)->value('images');

        if (is_null($images)) {
            $data = [
                'pid'    => $productId,
                'images' => json_encode([1 => $filename]),
            ];

            $arr = \App\productImage::create($data);
        } else {
            $arr = json_decode($images, true);
            if (is_null($arr)) {
                $arr = [(count($arr) + 1) => $filename];
            } else {
                $arr[(count($arr) + 1)] = $filename;
            }

            $imagesss         = \App\productImage::where('pid', $productId)->first();
            $imagesss->images = json_encode($arr);
            $imagesss->save();
        }

        // Resmin küçük boyutunu kaydet
        if (!File::exists($destinationPathMin)) {
            File::makeDirectory($destinationPathMin, 0777, true);
        }

        $img = Image::make($destinationPath . $filename)
            ->resize(null, 360, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($destinationPathMin . $filename, 80, 'jpg');

        # Resmi Uzak Sunucuya Yükle #
        $uploadResponse = remoteImageUpload($productId, $filename, $destinationPath . $filename, $destinationPathMin . $filename);

        // Yerel sunucudan yüklenen resimleri sil
        File::deleteDirectory($destinationPath);
        File::deleteDirectory($destinationPathMin);

        // Uzak sunucuya yükleme işleminin sonucunu
        $uploadResult = (strstr($uploadResponse, 'Success') ? 200 : 500);

        $response = [
            'success'  => $uploadResult,
            'filename' => 'https://data.tekkilavuz.com.tr/marketpaketi/products/' . $productId . '/' . $filename,
            'type'     => count($arr) . '. Resim',
            'id'       => count($arr),
        ];

        return json_encode($response);
    }

    public function imageRemove(Request $request)
    {
        $images = \App\productImage::where("pid", $request->get("pId"))->value('images');
        $arr    = json_decode($images, true);

        if (isset($arr[$request->get("id")])) {
            $pathToImage = public_path() . '/src/uploads/products/' . $request->get("pId") . '/' . $arr[$request->get("id")];
            if (File::exists($pathToImage)) {
                $var = "var";
                unlink($pathToImage);
            } else {
                $var         = "yok";
                $pathToImage = "null";
            }

            if (File::exists(public_path() . '/src/uploads/products/min/' . $request->get("pId") . '/' . $arr[$request->get("id")])) {
                unlink(public_path() . '/src/uploads/products/min/' . $request->get("pId") . '/' . $arr[$request->get("id")]);
            }

            // Uzak sunucudan resmi sil
            $deleteResponse = remoteImageDelete($request->get('pId'), $arr[$request->get("id")]);

            unset($arr[$request->get("id")]);
            $indis = [];
            for ($i = 1; $i <= count($arr); $i++) {
                $indis[] = $i;
            }

            $arrCombine = array_combine($indis, $arr);

            $imagesss         = \App\productImage::where("pid", $request->get("pId"))->first();
            $imagesss->images = json_encode($arrCombine);
            $imagesss->save();

            $resp = [
                'success' => 200,
                'path'    => $pathToImage,
                'dosya'   => $var,
            ];
        } else {
            $resp = [
                'success' => 200,
                'message' => 'Sisteme kayıtlı böyle bir görsel bulunmuyor.',
            ];
        }

        return json_encode($resp);
    }

    public function imageSort(Request $request)
    {
        $keysArr = $request->get("pimage");

        $images = \App\productImage::where("pid", $request->get("id"))->value('images');
        $valArr = json_decode($images, true);

        //ksort($sortArr);
        $sorted = array_map(function ($v) use ($valArr) {
            return $valArr[$v];
        }, $keysArr);

        for ($i = 1; $i <= count($sorted); $i++) {
            $indis[] = $i;
        }
        // dd($indis);
        //dd(array_combine($indis,$sorted));
        $arrCombine       = array_combine($indis, $sorted);
        $imagesss         = \App\productImage::where("pid", $request->get("id"))->first();
        $imagesss->images = json_encode($arrCombine);
        $imagesss->save();

        $resp = ["success" => 200];

        return json_encode($resp);
    }

    public function productsRelatedsAjax(Request $request, $id)
    {
        if (!empty($request->get('q'))) {
            return Products::where('name', 'like', '%' . $request->get('q') . '%')->where('id', '!=', $id)->select("name", "id", "stock_type")->paginate(15);
        } else {
            return Products::where('id', '!=', $id)->select("name", "id", "stock_type")->paginate(15);
        }
    }

    public function productsRelated(Request $request)
    {
        $data = \App\Products::find($request->get("id"));

        $response = '<tr id="relatedp_' . $data->id . '">
                <td><input type="hidden" name="relateds[]" value="' . $data->id . '"><a href="#">' . $data->id . '</a></td>
                <td>' . $data->name . '</td>
                <td>' . @$data->brand->name . '</td>
                <td>' . $data->price . '</td>
                <td><button type=\'button\' class=\'btn btn-danger waves-effect waves-light\' onclick="$.deleteDivFromId(\'relatedp_' . $data->id . '\')"><i class=\'fa fa-close\'></i> Sil</button></td>
                </tr>';

        return $response;
    }

    public function sortStatusUpdate(Request $request)
    {
        // dd($request->all());
        switch ($request->get("which")) {
            case "status":
                \App\Products::find($request->get("id"))->update(array("status" => $request->get("status")));
                \LogActivity::addToLog('Ürün durumu değiştirildi.');
                break;
            case "home":
                if ($request->get("status") == 1) {
                    if (\App\HomeSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\HomeSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    \App\HomeSort::create(["product_id" => $request->get("id"), "sort" => $count]);
                } else {
                    $pro = \App\Products::find($request->get("id"));
                    $pro->showcase()->delete();
                }
                \LogActivity::addToLog('Anasayfa vitrin durumu değiştirildi.');
                break;
            case "campaign":
                if ($request->get("status") == 1) {
                    if (\App\CampaignSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\CampaignSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    \App\CampaignSort::create(["product_id" => $request->get("id"), "sort" => $count]);
                } else {
                    $pro = \App\Products::find($request->get("id"));
                    $pro->campaignSort()->delete();
                }
                \LogActivity::addToLog('Kampanyalı vitrin durumu değiştirildi.');
                break;
            case "category":
                $pro = \App\Products::find($request->get("id"));
                if ($request->get("status") == 1) {
                    $pro->categorySort()->delete();
                    $sayac = 0;
                    foreach ($pro->categori as $cat => $item) {
                        $sayac++;
                        $dataCatUpdate = [
                            "category_id" => $item->id,
                            "product_id"  => $request->get("id"),
                            "sort"        => $sayac,
                        ];
                        \App\categorySort::create($dataCatUpdate);
                    }
                } else {
                    $pro->categorySort()->delete();
                }
                \LogActivity::addToLog('Kategori vitrin durumu değiştirildi.');
                break;
            case "brand":
                $pro = \App\Products::find($request->get("id"));

                if ($request->get("status") == 1) {
                    if (\App\BrandSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\BrandSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    if (!empty($pro->brand)) {
                        \App\BrandSort::create(["product_id" => $request->get("id"), "brand_id" => $pro->brand->id, "sort" => $count]);
                    }
                } else {
                    $pro->brandSort()->delete();
                }
                \LogActivity::addToLog('Marka vitrin durumu değiştirildi.');
                break;
            case "new":
                $pro = \App\Products::find($request->get("id"));
                if ($request->get("status") == 1) {
                    if (\App\NewSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\NewSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    \App\NewSort::create(["product_id" => $request->get("id"), "sort" => $count]);
                } else {
                    $pro->newSort()->delete();
                }
                \LogActivity::addToLog('Yeni vitrin durumu değiştirildi.');
                break;
            case "sponsor":
                $pro = \App\Products::find($request->get("id"));
                if ($request->get("status") == 1) {
                    if (\App\SponsorSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\SponsorSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    \App\SponsorSort::create(["product_id" => $request->get("id"), "sort" => $count]);
                } else {
                    $pro->sponsorSort()->delete();
                }
                \LogActivity::addToLog('Sponsor vitrin durumu değiştirildi.');
                break;
            case "popular":
                $pro = \App\Products::find($request->get("id"));
                if ($request->get("status") == 1) {
                    if (\App\PopularSort::orderBy('sort', 'desc')->first()) {
                        $count = \App\PopularSort::orderBy('sort', 'desc')->first()->sort + 1;
                    } else {
                        $count = 1;
                    }
                    \App\PopularSort::create(["product_id" => $request->get("id"), "sort" => $count]);
                } else {
                    $pro->popularSort()->delete();
                }
                \LogActivity::addToLog('Popüler vitrin durumu değiştirildi.');
                break;
        }
    }

    public function productsCopy($id)
    {
        $data             = Products::find($id);
        $data->brand_name = $data->brand;
        $check            = [];

        if (count($data->variant) > 0) {
            $data->variants = $data->variant;
        }

        $varArr      = [];
        $selectedVar = [];
        $varArrCheck = [];

        if (count($data->variant) > 0) {
            foreach ($data->variant as $var) {
                foreach ($var->value as $val) {
                    if (!in_array($val->vid, $varArrCheck)) {
                        $vrGrp    = \App\Variant::find($val->vid);
                        $varArr[] = $vrGrp;
                        $arr2[]   = \App\Variant::find($val->vid)->values;
                    }
                    $varArrCheck[] = $val->vid;
                    if (!in_array($val->id, $selectedVar)) {
                        $selectedVar[] = $val->id;
                    }
                }
            }
            $data->variantGroup  = $varArr;
            $data->variantValues = $arr2;
            $data->selectedVar   = $selectedVar;
        }

        if (count($data->attributes) > 0) {
            foreach ($data->attributes as $attr) {
                $selected[]     = $attr->aid;
                $selectedVals[] = $attr->id;
                $a              = \App\Attribute::find($attr->aid);
                if (!in_array($a->attributeGroup->id, $check)) {
                    $attGroupArr[] = $a->attributeGroup;
                }
                $check[] = $a->attributeGroup->id;
            }

            $data->attrGroups  = $attGroupArr;
            $data->attr        = $selected;
            $data->selectedVal = $selectedVals;
        }

        $data->image = $data->images;
        $data->image = json_decode($data->image["images"]);

        return view('admin.productCopy', compact('data', 'data'));
    }

    public function createCopyProduct(Request $request)
    {
        $data = [
            "name" => $request->get("name"),
        ];

        $add = \App\Products::create($data);

        if ($add) {
            // //image copy
            // $oldproduct = \App\Products::find($request->get("id"));
            // $oldimage = $oldproduct->images;
            //
            // if (!empty($oldimage)) {
            //     $oldimgArr=json_decode($oldimage->images);
            //
            //     foreach ($oldimgArr as $k => $v) {
            //         // $oldPath = public_path().'/src/uploads/products/'.$request->get("id").'/'.$v;
            //         $oldPath = getCdnImage($request->get('id'), $v);
            //         $oldMinPath = getCdnMinImage($request->get('id'), $v);
            //
            //         $microtime = explode(' ', str_replace('0.', null, microtime()));
            //         $ext = pathinfo($oldPath, PATHINFO_EXTENSION);
            //         $filename = str_slug($request->get('name')).'-'.$microtime[0].$microtime[1].'.'.$ext;
            //         $createpath = public_path().'/src/uploads/products/'.$add->id;
            //
            //         $uploadResponse = remoteImageUpload($add->id, $filename, $oldPath, $oldMinPath);
            //
            //         if (strstr($uploadResponse, 'Success')) {
            //             $images = \App\productImage::where("pid", $add->id)->value('images');
            //
            //             if (is_null($images)) {
            //                 $data = ["pid"=> $add->id, "images" => json_encode([1=>$filename])];
            //                 $arr = \App\productImage::create($data);
            //             } else {
            //                 $arr = json_decode($images, true);
            //                 if (is_null($arr)) {
            //                     $arr = [count($arr)+1=>$filename];
            //                 } else {
            //                     $arr[count($arr)+1]=$filename;
            //                 }
            //                 $imagesss = \App\productImage::where("pid", $add->id)->first();
            //                 $imagesss->images=json_encode($arr);
            //                 $imagesss->save();
            //             }
            //         }
            //     }
            // }
            //

            $request->request->add(["id" => $add->id]);

            $this->updateProduct($request);
            \LogActivity::addToLog('Ürün kopyalandı.');
        }

        return redirect("admin/products/edit/" . $add->id);
    }

    public function shortEdit(Request $request)
    {
        //dd($request->all());

        $pro = \App\Products::find($request->get("id"));
        if (empty($pro->discount_start_date) || empty($pro->discount_finish_date)) {
            $pro->discount_start_date  = '2020-01-10 00:00:00';
            $pro->discount_finish_date = '2022-12-31 00:00:00';

        }
        if (empty($pro->costprice)) {
            $pro->costprice = '0';
        }
        $message = '<div id="brand-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div style="max-width:600px" class="modal-dialog">
                                            <div class="modal-content">
                                            <form id="add_brand" method="post" action="' . url('admin/products/shortUpdate') . '/' . $pro->id . '" class="form-horizontal form-bordered">
                                            <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Hızlı Düzenle</h4>
                                            </div>
                                            <div class="modal-body">
                                            <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Adı</label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control" value="' . $pro->name . '" name="name" id="name">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="price" class="col-sm-3 control-label">Fiyat</label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control" name="price" id="price" value="' . $pro->price . '">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="price" class="col-sm-3 control-label">Maliyet</label>
                                            <div class="col-sm-9">
                                            <div class="input-daterange input-group">
                                            <input type="text" class="form-control"  name="costprice" id="costprice" value="' . $pro->costprice . '">
                                            <span class="input-group-addon bg-white b-0">KDV Dahil</span>
                                            <input type="text" class="form-control" readonly  name="kdvcostprice" id="kdvcostprice" value="' . $this->withTax($pro->costprice, $pro->tax_status, $pro->tax) . '">
                                            </div>
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="price" class="col-sm-3 control-label">Stok</label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control" name="stock" id="stock" value="' . $pro->stock . '">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="discount_type" class="col-sm-3 control-label">İndirim Türü</label>
                                            <div class="col-sm-9">
                                            <select name="discount_type" id="status" class="form-control" data-style="form-control" data-width="100%">
                                            <option value="0" ' . ($pro->discount_type == 0 ? 'selected' : '') . '>İndirim Yok</option>
                                            <option value="1" ' . ($pro->discount_type == 1 ? 'selected' : '') . '>Yüzdeli İndirim (%)</option>
                                            <option value="2" ' . ($pro->discount_type == 2 ? 'selected' : '') . '>İndirimli Fiyat</option>
                                            </select>
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="discount" class="col-sm-3 control-label">İndirim</label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control"' . (HelpersNew::discountControl($pro->discount_start_date, $pro->discount_finish_date, $pro->discount_type) == true ? 'style="color:red!important;font-weight:bold"' : '') . ' name="discount" id="discount" value="' . $pro->discount . '">
                                            </div>
                                            </div>

                                            <div class="form-group">
                                            <label for="price" class="col-sm-3 control-label">İndirim Geçerlilik Tarihi</label>
                                            <div class="col-sm-9">
                                            <div class="input-daterange input-group">
                                            <input placeholder="gün-ay-yıl" type="text" class="form-control datepicker' . $pro->id . '" name="discountstartdate" id="discountstartdate" value="' . date("d-m-Y H:i", strtotime($pro->discount_start_date)) . '">
                                            <span class="input-group-addon bg-default b-0">ve</span>
                                            <input placeholder="gün-ay-yıl" type="text" class="form-control datepicker' . $pro->id . '" name="discountfinishdate" id="discountfinishdate" value="' . date("d-m-Y H:i", strtotime($pro->discount_finish_date)) . '">
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Güncelle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                            </div>
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <input type="hidden" name="index" value="' . $request->get("index") . '">
                                            </form>
                                            </div>
                                            </div>
                                            </div>
                                            <script>
                                            $(document).ready(function () {
                                                $(".datepicker' . $pro->id . '").datetimepicker({
                                                    format: "DD-MM-YYYY HH:mm:ss",
                                                    useSeconds: true,
                                                    autoclose: true,
                                                    language: "tr",
                                                });
                                            });
                                            </script>';
        $data = ["status" => true, "message" => $message];
        return json_encode($data);
    }

    public function shortUpdate(Request $request, $id)
    {
        $pro = Products::find($id);

        $data = [
            "name"                 => $request->get("name"),
            "stock"                => $request->get("stock"),
            "price"                => str_replace(",", ".", $request->get("price")),
            "discount_type"        => $request->get("discount_type"),
            "discount"             => $request->get("discount"),
            'costprice'            => str_replace(",", ".", $request->get("costprice")),
            'discount_start_date'  => Carbon::parse($request->get('discountstartdate')),
            'discount_finish_date' => Carbon::parse($request->get('discountfinishdate')),
        ];

        // Final Price
        $priceWithTax        = $this->withTax($data["price"], $pro->tax_status, $pro->tax);
        $data["final_price"] = $this->discountedPrice($priceWithTax, $data["discount_type"], $data["discount"]);

        try {
            $pro->update($data);
            \LogActivity::addToLog('Ürün düzenlendi.', $request->all());
            //$request->session()->flash('status',array(1,"Tebrikler!"));
            $data = ['status' => 200, 'message' => 'Başarılı bir şelilde güncellendi.', 'index' => $request->get("index"), "data" => $data];
        } catch (Exception $e) {
            $data = ['status' => 0, 'message' => 'Ürün güncellenirken bir hata oluştu.'];
            //$request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        //return redirect('admin/products');
        echo json_encode($data);
    }

    public function outputProductXml()
    {
        $names = [
            "name"       => "urunAdi",
            "id"         => "g:id",
            "stock_type" => "stck_type",
        ];

        $select = ["name", "id", "stock_type"];

        $pro = \App\Products::select(["name", "id", "stock_type"])->get();
        $pro = $pro->toArray();

        $content = view('admin.outputXml', compact('pro', 'names', 'select'));
        return response($content, 200)
            ->header('Content-Type', 'rss+xml');
    }

    public function outputProductXmlold()
    {
        $select = ["name", "id", "stock_type"];
        $pro    = \App\Products::select(["name", "id", "stock_type"])->get();
        //dd($pro->toArray());
        $pro = $pro->toArray();
        //return view('admin.outputXml');
        $names = [
            "name"       => "ned",
            "id"         => "g:id",
            "stock_type" => "stck_type",
        ];
        $data = [
            "list"  => [
                "name"    => "emre",
                "surname" => "bas",
                "team"    => "fenerbahce",
                "item"    => "value",
            ],
            "list2" => [
                "name"    => "mustafa",
                "surname" => "keser",
                "team"    => "basaksehr",
                "item"    => "value",
            ],
        ];

        $content = view('admin.outputXml', compact('pro', 'names', 'select'));
        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function bulkTransport(Request $request)
    {
        // return dd($request->all());

        //return dd($request->get("categories"));

        if (!empty($request->get("categories"))) {
            //$myArray = explode(',', $request->get("categories"));
            $myArray = $request->get("categories");

            foreach ($request->get('products') as $key => $value) {
                $pro = \App\Products::find($value);
                $pro->categori()->detach();
                $pro->categori()->attach($myArray);
            }
            \LogActivity::addToLog('Ürün toplu taşıma işlemi yapıldı.', $request->all());
            $data = ["status" => true, "message" => "Taşıma işlemi tamamlandı"];
        } else {
            $data = ["status" => false, "message" => "Hata"];
        }
        return json_encode($data);
    }

    public function criticalStock()
    {
        //$data = \App\Products::select('id','name','stock','stock_type')->where('status',1)->whereBetween('stock', [1,3])->orderBy('stock')->orderBy('created_at','desc')->limit(300)->get();
        $kritikStok = \App\Products::select('products.id', 'products.name', 'products.stock', 'products.stock_type', 'order_items.order_id', DB::raw('MAX(order_items.id) as latest'))->where('products.stock', '=', 0)
            ->where('products.status', '=', 1)
            ->Join('order_items', 'products.id', '=', 'order_items.product_id')
        //->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('orders', function ($leftJoin) {
                $leftJoin->on('orders.id', '=', 'order_items.order_id')

                    ->where('orders.created_at', '=', DB::raw("(select max(`id`) from orders)"));
                //->orderBy('created_at', 'desc')
                //->limit(1);
            })->groupBy('products.id')->orderBy('latest', 'desc')->limit(1000)->get();
        return Datatables::of($kritikStok)->make(true);
    }

    public function stats()
    {

        $charts = \App\Order_item::join('orders', function ($join) {
            $join->on('order_items.order_id', '=', 'orders.id')
                ->where('status', '!=', '9')->where('status', '!=', '3')->where('status', '!=', '8')->where('status', '!=', '5')->where('status', '!=', '0');
        })
        //->select(DB::raw('sum(CASE WHEN status = 9 THEN 0 WHEN order.status = 3 THEN 0 ELSE qty END) as totalQty, name, order.status'))
            ->select([DB::raw('sum(qty) as totalQty, name'), DB::raw('count(qty) as orderCount'), DB::raw('substr(name, 1, 40) as short')])
            ->groupBy('product_id')
            ->orderBy('totalQty', 'desc')
            ->limit(25)
            ->get();

        $response = ["chart" => $charts];

        return $response;
    }
}
