<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Campaign;
use App\Categori;
use App\Products;
use App\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function coupons()
    {
        return view('admin.campaigns');
    }

    public function couponsAdd()
    {
        return view('admin.campaignAddCoupon');
    }

    public function couponsDatatable()
    {
        $coupon = \App\Campaign::All();

        foreach ($coupon as $brand) {
            // $brand->deneme=$brand->getstartDateAttribute($brand->startDate);
            //$brand->edit='<a href="'.url("admin/campaigns/coupons/edit/{$brand->id}").'" class="btn btn-xs btn-success btn-rounded"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            //$brand->delete='<a href="'.url("admin/campaigns/coupons/delete/{$brand->id}").'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz?\')" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i> Sil</a>';
            //$resp[]=$brand;
        }
        return Datatables::of($coupon)->make(true);
    }

    public function createCoupon(Request $request)
    {
        $usage = $request->get("usage");

        switch ($usage) {
            case 1:
                $spacialVal = [];
                break;
            case 2:
                $spacialVal = $request->get("clients");
                break;
            case 3:
                $spacialVal = $request->get("groups");
                break;
            case 4:
                $spacialVal = $request->get("categories");
                break;
            case 5:
                $spacialVal = $request->get("products");
                break;
            case 6:
                $spacialVal = $request->get("brands");
                break;
            default:
                $spacialVal = [];
        }

        $data = array(
            "code"           => $request->get("code"),
            "maxUse"         => $request->get("max_limit"),
            "PersonUseLimit" => $request->get("person_limit"),
            "special"        => $request->get("usage"),
            "specialValues"  => json_encode($spacialVal),
            "startDate"      => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("start_date")))),
            "stopDate"       => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("expire_date")))),
            "value_type"     => $request->get("type"),
            "value"          => $request->get("value"),
            "freeShip"       => $request->get("free_shipping") ? $request->get("free_shipping") : 0,
            "discounted"     => $request->get("discount_p") ? $request->get("discount_p") : 0,
            "usageLimit"     => $request->get("usage_limit"),
        );

        $add = \App\Campaign::create($data);
        if ($add) {
            \LogActivity::addToLog('Kupon oluşturuldu.');
            $request->session()->flash('status', array(1, "Eklendi."));
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/campaigns/coupons");
    }

    public function editCoupon($id)
    {
        $data = Campaign::find($id);
        //dd(json_decode($data->specialValues,true));

        switch ($data->special) {
            case 1:
                $spacialVal = [];
                break;
            case 2:
                $spacialVal = [];
                break;
            case 3:
                $spacialVal = [];
                break;
            case 4:
                $spacialVal = Categori::whereIn("id", json_decode($data->specialValues, true))->get("id", "title");
                break;
            case 5:
                $spacialVal = Products::whereIn("id", json_decode($data->specialValues, true))->get();
                break;
            case 6:
                $spacialVal = Brand::whereIn("id", json_decode($data->specialValues, true))->get();
                //dd($spacialVal);
                break;
            default:
                $spacialVal = [];
        }

        //$cats = Categori::whereIn("id",json_decode($data->specialValues,true))->get("id","title");
        //dd($cats);

        $data["cats"] = $spacialVal;

        return view('admin.campaignEditCoupon', compact('data'));
    }

    public function updateCoupon(Request $request)
    {

        $usage = $request->get("usage");

        switch ($usage) {
            case 1:
                $spacialVal = [];
                break;
            case 2:
                $spacialVal = $request->get("clients");
                break;
            case 3:
                $spacialVal = $request->get("groups");
                break;
            case 4:
                $spacialVal = $request->get("categories");
                break;
            case 5:
                $spacialVal = $request->get("products");
                break;
            case 6:
                $spacialVal = $request->get("brands");
                break;
            default:
                $spacialVal = [];
        }

        $data = array(
            "code"           => $request->get("code"),
            "maxUse"         => $request->get("max_limit"),
            "PersonUseLimit" => $request->get("person_limit"),
            "special"        => $request->get("usage"),
            "specialValues"  => json_encode($spacialVal),
            "startDate"      => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("start_date")))),
            "stopDate"       => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("expire_date")))),
            "value_type"     => $request->get("type"),
            "value"          => $request->get("value"),
            "freeShip"       => $request->get("free_shipping") ? $request->get("free_shipping") : 0,
            "discounted"     => $request->get("discount_p") ? $request->get("discount_p") : 0,
            "usageLimit"     => $request->get("usage_limit"),
        );

        try {
            $update = \App\Campaign::where('id', '=', $request->get("id"))
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Kupon düzenlendi.');

        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/campaigns/coupons");

    }

    public function couponDelete($id)
    {
        $cp = Campaign::find($id);
        try {
            $cp->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Kupon silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }
        return redirect("admin/campaigns/coupons");
    }

    public function promotion()
    {
        return view('admin.promotions');
    }

    public function promotionsDatatable()
    {
        $promotion = \App\Promotion::All();

        return Datatables::of($promotion)->make(true);
    }

    public function promotionAdd()
    {
        return view('admin.promotionAdd');
    }

    public function createPromotion(Request $request)
    {
        //dd($request->all());

        $data = [
            "name"                  => $request->get("name"),
            "selectedDate"          => $request->has("selectedDate") ? $request->get("selectedDate") : 0,
            "type"                  => $request->get("radio"),
            "maxUsage"              => $request->get("max_limit"),
            "memberGroupId"         => $request->get("group_id"),
            "memberIds"             => null,
            "promotionDiscountType" => $request->get("promotionDiscountType"),
            "promotionValue"        => $request->get("promotionValue"),
            "basePriceLimit"        => $request->get("basePriceLimit"),
            "affectedProducts"      => $request->has("affectedProducts") ? json_encode($request->get("products")) : null,
            "affectedCount"         => $request->get("affectedCount"),
            "baseProducts"          => $request->has("baseProducts") ? json_encode($request->get("baseProducts")) : null,
            "baseProductsOperator"  => $request->get("radio2"),
            "baseCount"             => $request->get("baseCount"),
            "baseCategoryId"        => $request->has("category") ? $request->get("category") : null,
            "baseBrandId"           => $request->has("brand") ? $request->get("brand") : null,
            "description"           => $request->get("description"),
            "startDate"             => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("start_date")))),
            "stopDate"              => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("expire_date")))),
            "status"                => $request->has('status') ? $request->get("status") : 0,
        ];

        $create = \App\Promotion::create($data);

        if ($create) {
            \LogActivity::addToLog('Promosyon oluşturuldu.');
        }

        return redirect("admin/campaigns/promotion");

    }

    public function promotionDelete($id)
    {
        $promotionDelete = Promotion::find($id);
        try {
            $promotionDelete->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Kupon silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }
        return redirect("admin/campaigns/promotion");
    }

    public function editPromotion($id)
    {
        $data = \App\Promotion::find($id);
        $arr  = array();
        $arr2 = array();
        if ($data->affectedProducts != null) {
            //dd(json_decode($data->affectedProducts));
            foreach (json_decode($data->affectedProducts) as $item) {
                if ($data->product($item)) {
                    $arr[] = $data->product($item);
                }

            }
        }
        if ($data->baseProducts != null) {
            foreach (json_decode($data->baseProducts) as $item) {
                if ($data->product($item)) {
                    $arr2[] = $data->product($item);
                }

            }
        }

        $data->products     = $arr;
        $data->baseProducts = $arr2;

        return view('admin/promotionEdit', compact('data'));
    }

    public function updatePromotion($id, Request $request)
    {
        $data = [
            "name"                  => $request->get("name"),
            "selectedDate"          => $request->has("selectedDate") ? $request->get("selectedDate") : 0,
            "type"                  => $request->get("radio"),
            "maxUsage"              => $request->get("max_limit"),
            "memberGroupId"         => $request->get("group_id"),
            "memberIds"             => null,
            "promotionDiscountType" => $request->get("promotionDiscountType"),
            "promotionValue"        => $request->get("promotionValue"),
            "basePriceLimit"        => $request->get("basePriceLimit"),
            "affectedProducts"      => $request->has("affectedProducts") ? json_encode($request->get("products")) : null,
            "affectedCount"         => $request->get("affectedCount"),
            "baseProducts"          => $request->has("baseProducts") ? json_encode($request->get("baseProducts")) : null,
            "baseProductsOperator"  => $request->get("radio2"),
            "baseCount"             => $request->get("baseCount"),
            "baseCategoryId"        => $request->has("category") ? $request->get("category") : null,
            "baseBrandId"           => $request->has("brand") ? $request->get("brand") : null,
            "description"           => $request->get("description"),
            "startDate"             => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("start_date")))),
            "stopDate"              => date('Y-m-d', strtotime(str_replace("/", "-", $request->get("expire_date")))),
            "status"                => $request->has('status') ? $request->get("status") : 0,
        ];

        try {
            $update = \App\Promotion::where('id', '=', $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Kupon düzenlendi.');

        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/campaigns/promotion");
    }
}
