<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\WholesaleForm;
use Mail;

class WholesaleController extends Controller
{
    public function save(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'quantity' => 'required'
        ], [
            'product_id' => 'İşlemler sıradan bir hata oluştu! Lütfen bizimle iletişime geçin!',
            'name.required' => 'Lütfen adınızı girini!',
            'phone.required' => 'Lütfen telefonunuzu giriniz!',
            'quantity.required' => 'Lütfen kaç adet almak istediğinizi belirtiniz!'
        ]);

        $wholesaleForm = WholesaleForm::create($request->input());

        if ($wholesaleForm) {
            $product = $wholesaleForm->product;

            $productUrl = url($product->slug . '-p-' . $product->id);

            Mail::queue('mailTemplates.wholesale', [
                'form' => $wholesaleForm,
                'product' => $product,
                'productUrl' => $productUrl
            ], function ($message) {
                $message->from('consumer@marketpaketi.com.tr', 'Marketpaketi.com.tr');
                $message->to('hakan@marketpaketi.com.tr', 'Hakan');
                // $message->to('ahmet.bedir@tekkilavuz.net', 'Ahmet Bedir');
                $message->subject('Toptan Fiyat İstek Formu');
            });

            return response()->json(['success' => true, 'data' => $wholesaleForm]);
        }

        return response()->json(['success' => false]);
    }
}
