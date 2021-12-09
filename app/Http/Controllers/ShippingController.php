<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class ShippingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:shipping_read', ['only' => ['index', 'shippingCompaniesDatatable']]);
        $this->middleware('permission:shipping_create', ['only' => ['addShippingCompanies', 'createShippingCompanies']]);
        $this->middleware('permission:shipping_edit', ['only' => ['editshippingCompanies', 'updateShippingCompanies']]);
        $this->middleware('permission:shipping_delete', ['only' => ['deleteShippingCompanies']]);
    }

    public function index()
    {
        return view('admin.shippingCompanies');
    }

    public function addShippingCompanies()
    {
        return view('admin.shippingCompaniesAdd');
    }

    public function createShippingCompanies(Request $request)
    {
        //dd($request->All());
        $data = [
            "name"          => $request->get("name"),
            "pay_type"      => $request->get("pay_type"),
            "status"        => $request->get("status"),
            "integration"   => $request->get("integration"),
            "sort"          => $request->get("order"),
            "price"         => $request->get("price"),
            "pd_status"     => $request->get("pd_status"),
            "pdCash_status" => $request->get("pdCash_status"),
            "pdCash_price"  => $request->get("pdCash_price"),
            "pdCard_status" => $request->get("pdCard_status"),
            "pdCard_price"  => $request->get("pdCard_price"),
        ];

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/ShippingCompanies/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;
        }

        $add = \App\Shipping::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/shippingCompanies");

    }

    public function shippingCompaniesDatatable()
    {
        $data = \App\Shipping::All();
        return Datatables::of($data)->make(true);
    }

    public function editshippingCompanies($id)
    {
        $data = \App\Shipping::find($id);
        return view('admin.shippingCompaniesEdit', compact('data'));
    }

    public function updateShippingCompanies(Request $request)
    {
        //old image
        $old = \App\Shipping::find($request->get("id"));

        $data = array(
            "name"          => $request->get("name"),
            "pay_type"      => $request->get("pay_type"),
            "status"        => $request->get("status"),
            "integration"   => $request->get("integration"),
            "sort"          => $request->get("order"),
            "price"         => $request->get("price"),
            "pd_status"     => $request->get("pd_status"),
            "pdCash_status" => $request->get("pdCash_status"),
            "pdCash_price"  => $request->get("pdCash_price"),
            "pdCard_status" => $request->get("pdCard_status"),
            "pdCard_price"  => $request->get("pdCard_price"),
        );

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/ShippingCompanies/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/ShippingCompanies/' . $old->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }
        }

        try {
            $update = \App\Shipping::where('id', '=', $request->get("id"))
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));

        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect("admin/shippingCompanies");

    }

    public function deleteShippingCompanies($id)
    {
        $br = \App\Shipping::find($id);

        if (!empty($br->image)) {
            $destinationPath = public_path() . '/src/uploads/ShippingCompanies/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        try {
            $br->delete();
            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/shippingCompanies");
    }

    public function ajaxList()
    {
        return \App\Shipping::paginate(15);
    }

    public function roles()
    {
        return view('admin.shippingRoles');
    }

    public function AddRoles()
    {
        return view('admin.shippingRoleAdd');
    }

    public function RolesDatatable()
    {
        $data = \App\ShippingRole::All();
        return Datatables::of($data)->make(true);
    }

    public function createRoles(Request $request)
    {

        if ($request->get("company_id") == "" || $request->get("type") == "") {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
            return redirect("admin/shippingRoles/add");
        }
        //dd($request->all());
        if ($request->get("type") == 2) {
            $value = $request->get("countries");
        } elseif ($request->get("type") == 3) {
            $value = $request->get("cities");
        } elseif ($request->get("type") == 4) {
            $value = $request->get("districts");
        } else {
            $value = [];
        }
        $data = [
            "name"          => $request->get("name"),
            "shipping_id"   => $request->get("company_id"),
            "type"          => $request->get("type"),
            "values"        => json_encode($value),
            "weight_price"  => $request->get("weight_price"),
            "fixed_price"   => $request->get("fixed_price"),
            "free_shipping" => $request->get("free_shipping"),
            "weight_limit"  => $request->get("weight_limit"),
            "desi"          => json_encode($request->get("oranlar")),
        ];

        $add = \App\ShippingRole::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/shippingRoles");

    }

    public function editRole($id)
    {
        $data  = \App\ShippingRole::find($id);
        $slots = \App\ShippingSlot::where('shipping_id', '=', $data->shipping_id)->get();
        //return dd($data);
        if (count(json_decode($data->values)) > 0) {
            foreach (json_decode($data->values) as $item) {
                if ($data->type == 2) {
                    $arr[] = $data->countries($item);
                } elseif ($data->type == 3) {
                    $arr[] = $data->cities($item);
                } elseif ($data->type == 4) {
                    $arr[] = $data->cities($item);
                }
            }
        } else {
            $arr = [];
        }

        //dd($arr);
        $data->valuesResult = $arr;
        $data->contryResult = @$arr[0]->country;
        return view("admin.shippingRoleEdit", compact('data', 'slots'));
    }

    public function updateRole($id, Request $request)
    {

        $this->validate($request, [
            'customPrices.conditions.*'      => 'required',
            'customPrices.cartAmountStart.*' => 'required',
            'customPrices.cartAmountEnd.*'   => 'required',
            'customPrices.shippingPrice.*'   => 'required',
        ], [
            '*.required' => 'Lütfen özel fiyat tanımlamak için tüm alanları doldurun!',
        ]);

        $old = \App\ShippingRole::find($id);

        if ($request->get("type") == 2) {
            $value = $request->get("countries");
        } elseif ($request->get("type") == 3) {
            $value = $request->get("cities");
        } elseif ($request->get("type") == 4) {
            $value = $request->get("districts");
        }
        $data = [
            "name"          => $request->get("name"),
            "shipping_id"   => $request->get("company_id"),
            "type"          => $request->get("type"),
            "values"        => json_encode(@$value),
            "weight_price"  => $request->get("weight_price"),
            "fixed_price"   => $request->get("fixed_price"),
            "free_shipping" => $request->get("free_shipping"),
            "weight_limit"  => $request->get("weight_limit"),
            "desi"          => json_encode($request->get("oranlar")),
            'custom_prices' => null,
        ];

        if ($request->get('customPrices')) {
            $data['custom_prices'] = serialize($request->get('customPrices'));
        }

        //slotları güncelle
        $slots = \App\ShippingSlot::where('shipping_id', '=', $old->shipping_id)->delete();

        if ($request->get('time1')) {
            foreach ($request->get('time1') as $key => $value) {
                if (!empty($value) && !empty($request->get('time2')[$key]) && !empty($request->get('max')[$key])) {
                    $dataSlot = ['shipping_id' => $old->shipping_id, "time1" => $value, 'time2' => $request->get('time2')[$key], 'max' => $request->get('max')[$key]];
                    \App\ShippingSlot::create($dataSlot);
                }
            }
        }

        try {
            $update = \App\ShippingRole::where('id', '=', $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));

        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect("admin/shippingRoles");

    }

    public function deleteRole($id)
    {
        $sr = \App\ShippingRole::find($id);
        try {
            $sr->delete();
            Session()->flash('status', array(1, "Silindi."));
        } catch (Exception $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }
        return redirect("admin/shippingRoles");
    }

}
