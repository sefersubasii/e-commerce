<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Psy\Exception\Exception;

class CustomerController extends Controller
{

    public function index()
    {
        return view('admin.customers');
    }

    public function addCustomer()
    {
        return view('admin.customerAdd');
    }

    public function createCustomer(Request $request)
    {
        if ($request->get("password") != $request->get("password_confirmation")) {
            Session()->flash('status', array(0, "Şifreler uyuşmuyor!"));
            return redirect("admin/customers");
        }

        $data = [
            "identity_number" => $request->get("identity_number"),
            "name"            => $request->get("name"),
            "surname"         => $request->get("surname"),
            "email"           => $request->get("email"),
            "phone"           => $request->get("phone"),
            "phoneGsm"        => $request->get("phoneGsm"),
            "company"         => $request->get("company"),
            "tax_office"      => $request->get("tax_office"),
            "tax_number"      => $request->get("tax_number"),
            "password"        => bcrypt($request->get("password")),
            "group_id"        => $request->get("group_id"),
            "status"          => $request->get("status"),
        ];

        try {
            $add = Member::create($data);

            $dataAddress = [
                "member_id"    => $add->id,
                "countries_id" => $request->get("country_id"),
                "cities_id"    => $request->get("city_id"),
                "districts_id" => $request->get("district_id"),
                "address"      => $request->get("address"),
                "postal_code"  => $request->get("postal_code"),
            ];

            MemberAddress::create($dataAddress);

            $request->session()->flash('status', array(1, "Eklendi."));
            \LogActivity::addToLog('Üye oluşturuldu.');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                // houston, we have a duplicate entry problem
                $request->session()->flash('status', array(0, "Bu mail adresi ile daha önce kayıt oluşturulmuştur!"));
            } else {
                $request->session()->flash('status', array(0, "Hata Oluştu! " . $errorCode));
            }

        }

        return redirect("admin/customers");

    }

    public function editCustomer($id)
    {
        $data = Member::with('getbillingAddress', 'getShippingAddress')->find($id);

        return view("admin.customerEdit", compact('data'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $member = Member::with('getShippingAddress', 'getbillingAddress', 'Address')->find($id);

        if (!empty($request->get("password"))) {
            if ($request->get("password") == $request->get("password_confirmation")) {
                $data["password"] = bcrypt($request->get("password"));
            } else {
                Session()->flash('status', array(0, "Şifreler uyuşmuyor!"));
                return redirect("admin/customers");
            }

        }

        $data = [
            "identity_number" => $request->get("identity_number"),
            "name"            => $request->get("name"),
            "surname"         => $request->get("surname"),
            "email"           => $request->get("email"),
            "phone"           => $request->get("phone"),
            "phoneGsm"        => $request->get("phoneGsm"),
            "company"         => $request->get("company"),
            "tax_office"      => $request->get("tax_office"),
            "tax_number"      => $request->get("tax_number"),
            "group_id"        => $request->get("group_id"),
            "status"          => $request->get("status"),
            "allowed_to_mail" => $request->get("allowed_to_mail"),
        ];

        $dataAddress = [
            "member_id"    => $id,
            "countries_id" => $request->get("country_id"),
            "cities_id"    => $request->get("city_id"),
            "districts_id" => $request->get("district_id"),
            "address"      => $request->get("address"),
            "postal_code"  => $request->get("postal_code"),
        ];

        try {
            $member->update($data);

            // Teslimat Bilgilerini Güncelle
            if ($shippings = $request->get('shipping')) {
                collect($shippings)
                    ->map(function ($item, $shippingId) use ($member) {
                        $member->getShippingAddress->find($shippingId)->update($item);
                    });
            }

            // Fatura Bilgilerini Güncelle
            if ($billings = $request->get('bgilling')) {
                collect($billings)
                    ->map(function ($item, $billingId) use ($member) {
                        $member->getbillingAddress->find($billingId)->update($item);
                    });
            }

            if (isset($member->Address)) {
                $member->Address->update($dataAddress);
            }

            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Üye düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/customers');
    }

    public function DeleteCustomer($id)
    {
        $del = Member::find($id);

        try {
            $del->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Üye silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/customers");
    }

    public function customersDatatable(Request $request)
    {

        //dd($request);

        $length = intval($request->input('length'));
        $start  = intval($request->input('start'));
        $draw   = $request->get('draw');

        $count   = Member::filterByRequest($request)->count();
        $members = Member::filterByRequest($request)->orderBy('created_at', 'DESC')->limit(20)->offset($start)->with('Group')->get();

        $responseData = [
            "draw"            => $draw,
            "recordsTotal"    => $count,
            "recordsFiltered" => $count,
            "data"            => $members,
        ];

        return response()->json($responseData);

        /*

    if(!empty($request->get("name"))){
    $src=$request->get("name");
    $object = Member::where(function($q) use ($src){
    $q->where('name', 'LIKE', '%'.$src.'%');
    }
    )->get();
    }else{
    $object = Member::All();
    }

    return Datatables::of($object)->make(true);
     */
    }

    public function stats()
    {
        //orders sum('grandtotal') groupby('member_id')->orderby(ttoal)

        $chart = DB::table('orders')
            ->join('members', function ($join) {
                $join->on('orders.member_id', '=', 'members.id');
            })
            ->where('orders.status', '=', 1)
            ->orWhere('orders.status', '=', 2)
            ->orWhere('orders.status', '=', 4)
            ->orWhere('orders.status', '=', 7)
            ->select([DB::raw('sum(grand_total) as total'), 'members.email'])
            ->groupBy('member_id')
            ->orderBy('total', 'desc')
            ->limit(20)
            ->get();

        $chart2 = DB::table('orders')
            ->join('members', function ($join) {
                $join->on('orders.member_id', '=', 'members.id');
            })
            ->where('orders.status', '=', 1)
            ->orWhere('orders.status', '=', 2)
            ->orWhere('orders.status', '=', 4)
            ->orWhere('orders.status', '=', 7)
            ->select([DB::raw('count(orders.id) as count'), 'members.email'])
            ->groupBy('member_id')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();

        $chart3 = DB::table('orders')
            ->join('members', function ($join) {
                $join->on('orders.member_id', '=', 'members.id');
            })
            ->join('order_items', function ($join) {
                $join->on('orders.id', '=', 'order_items.order_id');
            })
            ->where('orders.status', '=', 1)
            ->orWhere('orders.status', '=', 2)
            ->orWhere('orders.status', '=', 4)
            ->orWhere('orders.status', '=', 7)
            ->select([DB::raw('sum(order_items.qty) as qty'), 'members.email'])
            ->groupBy('member_id')
            ->limit(20)
            ->orderBy('qty', 'desc')
            ->get();

        $response = ["chart" => $chart, "chart2" => $chart2, "chart3" => $chart3];

        return $response;
    }

}
