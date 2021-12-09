<?php

namespace App\Http\Controllers;

use App\BillingAddress;
use App\Cities;
use App\Districts;
use App\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Get Shipping Or Billing Adress
     *
     * @param Request $request
     * @return mixed
     */
    public function getAddress(Request $request)
    {
        return collect([
            'view' => $this->getViewInstance()->render(),
        ]);
    }

    /**
     * Save Shipping Or Billing Address
     *
     * @param Request $request
     * @return mixed
     */
    public function saveAddress(Request $request)
    {
        $data  = $this->getDataByRequest();
        $model = $this->getModelByRequest();
        $rules = $this->getValidationRuleByRequest();

        $validator = Validator::make($request->all(), $rules, [
            '*.required' => 'Bu alan zorunludur!',
        ]);

        if ($validator->fails()) {
            return $this->viewErrorResponse($validator);
        } else if (!$model) {
            return $this->errorResponse();
        }

        $model->update($data);

        return $this->successResponse();
    }

    private function getDataByRequest()
    {
        $data = request()->except([
            '_token',
            'shippingId',
            'billingId',
        ]);

        if ($phone = request()->get('phone')) {
            $data['phoneGsm'] = $phone;
        }

        return $data;
    }

    private function getModelByRequest()
    {
        if ($shippingId = request()->get('shippingId')) {
            return ShippingAddress::findOrfail($shippingId);
        } else if ($billingId = request()->get('billingId')) {
            return BillingAddress::findOrfail($billingId);
        }
    }

    private function getValidationRuleByRequest()
    {
        if ($shippingId = request()->get('shippingId')) {
            $rules = [
                'address_name' => 'required',
                'name'         => 'required',
                'surname'      => 'required',
                'phone'        => 'required',
                'address'      => 'required',
                'city'         => 'required',
                'state'        => 'required',
            ];
        } else if ($billingId = request()->get('billingId')) {
            $rules = [
                'type'         => 'required',
                'address_name' => 'required',
                'name'         => 'required',
                'surname'      => 'required',
                'phone'        => 'required',
                'address'      => 'required',
                'city'         => 'required',
                'state'        => 'required',
            ];

            if (request()->get('type') == 2) {
                unset($rules['surname']);
                $rules['tax_place'] = 'required';
                $rules['tax_no']    = 'required';
            }
        }

        return $rules ?? [];
    }

    private function getAddressInfo()
    {
        $view = $address = $city = $states = null;

        if ($shippingId = request('shippingId')) {
            $view    = 'delivery_edit';
            $address = ShippingAddress::findOrfail($shippingId);
            $city    = Cities::where('name', $address->city)->first();
            $states  = Districts::where('cities_id', $city->id)->get();
        }

        if ($billingId = request('billingId')) {
            $view    = 'billing_edit';
            $address = BillingAddress::findOrfail($billingId);
            $city    = Cities::where('name', $address->city)->first();
            $states  = Districts::where('cities_id', $city->id)->get();
        }

        return compact('view', 'address', 'states');
    }

    private function successResponse()
    {
        $userId    = auth('members')->user()->id;
        $shippings = ShippingAddress::whereMemberId($userId)->get(['id', 'address_name']);
        $billings  = BillingAddress::whereMemberId($userId)->get(['id', 'address_name']);

        return response()->json([
            'message'           => 'Adres başarıyla güncellendi',
            'type'              => 'success',
            'shippingAddresses' => $shippings,
            'billingAddresses'  => $billings,
        ]);
    }

    private function getViewInstance()
    {
        $cities      = Cities::all();
        $addressInfo = $this->getAddressInfo();

        return view('frontEnd.partials.address.' . $addressInfo['view'], [
            'address' => $addressInfo['address'],
            'states'  => $addressInfo['states'],
            'cities'  => $cities,
        ])
            ->with('old', function ($old, $default = null) {
                return request()->get($old) ?? $default;
            });
    }

    private function viewErrorResponse($validator)
    {
        return collect([
            'view' => $this->getViewInstance()->withErrors($validator)->render(),
        ]);
    }

    private function errorResponse()
    {
        return response()->json([
            'message' => 'İşlemler sırasında bir hata oluştu!',
            'type'    => 'error',
        ]);
    }
}
