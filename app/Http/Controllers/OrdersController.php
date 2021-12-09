<?php

namespace App\Http\Controllers;

use App\Contracts\Sms;
use App\Helpers\LogActivity;
use App\Order;
use App\Services\Price;
use App\Services\SuratKargo;
use App\Services\YurticiKargo;
use App\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mail;
use Symfony\Component\HttpFoundation\Session\Session;
use \Milon\Barcode\DNS1D;

class OrdersController extends Controller
{

    /**
     * Yurtici Karga Instance
     *
     * @var object
     */
    protected $yurticiKargo;

    public function __construct()
    {
        $this->yurticiKargo = new YurticiKargo([
            'username' => 'OZKORUGO',
            'password' => '3BA99D4304874F',
        ]);
    }

    public function index()
    {
        session(['lastOrdersTime' . Auth::user()->id => Carbon::now()]);
        $cities            = \App\Cities::select('name')->get();
        $shippingCompanies = \App\Shipping::select('id', 'name')->get();
        return view("admin.orders", compact('shippingCompanies', 'cities'));
    }

    public function detail($id)
    {
        dd(Order::find($id));
    }

    public function failedOrders()
    {
        $cities            = \App\Cities::select('name')->get();
        $shippingCompanies = \App\Shipping::select('id', 'name')->get();
        return view("admin.failedOrders", compact('shippingCompanies', 'cities'));
    }

    public function datatable(Request $request)
    {
        $length = intval($request->input('length'));
        $start  = intval($request->input('start'));
        $draw   = $request->get('draw');

        $data = Order::filterByRequest($request);

        $count = $data->count();

        $data = Order::filterByRequest($request)->select('id', 'order_no', 'member_id', 'customer_note', 'status', 'payment_type', 'shipping_address_id', 'grand_total', 'billOutput', 'order_detail_output', 'created_at', 'statusMessage')
            ->with(array('shippingAddress' => function ($query) {
                $query->select('city', 'id');
            }))
            ->with(array('customer' => function ($query) {
                $query->select('id', 'name', 'surname');
            }))
            ->limit($length)
            ->offset($start)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            "draw"            => $draw,
            "recordsTotal"    => $count,
            "recordsFiltered" => $count,
            "data"            => $data,
        ]);
    }

    /**
     * Sipriş durumunu günceller ve sipariş durumuna göre kargo bilgilerini oluşturur.
     *
     * @param  Request $request
     * @return json
     */
    public function updateBulkStatus(Request $request)
    {
        $data = [
            "status" => $request->get("status"),
        ];

        $orderId = $request->get('orders');

        $order = Order::findOrFail($orderId);

        $shippingInfo = $order->shippingAddress;

        //Sipariş iptal edildi, ürünleri stoğa geri alalım
        if ($request->get("status") == 3) {
            foreach ($order->items as $key => $vp) {
                DB::table('products')->where('id', $vp["product_id"])->increment('stock', $vp["qty"]);
            }
        }

        /**
         * Kargo Entegrasyonu
         */
        $shippingApiResponse = null;
        if ($request->get("status") == 1) {
            switch ($order->shipping_id) {
                case 6:
                    $shippingApiResponse = $this->createShipmentYk($order);
                    break;
                default:
                    $shippingApiResponse = json_encode(["Kargo firması için entegrasyon bulunmamaktadır"]);
                    break;
            }
        } else if ($request->get('status') == 3 && $order->status == 1) {
            $shippingApiResponse = $this->yurticiKargo->cancelShipment($order->order_no);
        }

        $response = [
            "stataus"     => 200,
            "orderId"     => $order->id,
            "ShippingApi" => $shippingApiResponse,
        ];

        $response["billingNo"] = false;

        if ($request->get("status") == 2 && ($order->shipping_id == 5 || $order->shipping_id == 6)) {
            $response["billingNo"] = "required";
        }

        $oldOrderData = $order->toArray();
        
        // Sipariş Durumunu Güncelle
        $order->update($data);

        // Mail Gönder
        if ($request->get("status") != 2) {
            $this->sendOrderMail($order);
        }

        // SMS Gönder
        $order->sendSms();

        LogActivity::addToLog(
            sprintf(
                'Sipariş durumu güncellendi. "%s" ==> "%s"', 
                $oldOrderData['statusText'],
                $order->status_text
            ),
            $oldOrderData,
            $order
        );

        return response()->json($response);
    }

    /**
     * Hatalı ödemeler sayfasına düşen siparişlerini durumunu değiştir.
     */
    public function updateOrderStatus(Request $request)
    {
        if (!$request->has('status') || !$request->has('orders')) {
            return response()->json([
                'success' => false,
                'message' => 'Lütfen girilen bilgileri kontrol edin!',
            ]);
        }

        $status = $request->get('status');
        $orders = Order::whereIn('id', $request->get('orders'))->get();

        foreach ($orders as $order) {
            $order->status = $status;
            $result        = $order->save();

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'İşlemler sırasında bir hata oluştu!',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Siparişlerin durumu başarıyla güncellendi',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $orders = Order::with('items')
                ->whereIn('id', $request->get('orders'))
                ->get();

            // Ürün stokları geri yükle ve sil
            $orders->map(function ($order) {
                $order->items->map(function ($orderItem) {
                    DB::table('products')
                        ->where('id', $orderItem['product_id'])
                        ->increment('stock', $orderItem['qty']);
                });

                LogActivity::addToLog(
                    sprintf(
                        'Sipariş silindi. OrderId ==> %s', 
                        $order->id
                    ),
                    $order
                );

                $order->delete();
            });

            Session()->flash('status', array(1, "Silindi."));
        } catch (Exeption $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }

        return redirect('admin/orders');
    }

    public function test($id)
    {
        $price           = new Price();
        $data            = Order::find($id);
        $dataItems       = "";
        $slot            = "";
        $grandTotalPrice = 0;

        $discountInfo = "";
        if ($data->discount_amount > 0 && $data->coupon_code == null) {
            $discountInfo = "<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Promosyon Avantajı:</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
        } elseif ($data->discount_amount > 0 && $data->coupon_code != null) {
            $discountInfo = "<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Kupon Kodu İndirimi (" . $data->coupon_code . "):</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
        }

        if ($data->slot) {
            $slot = "<tr>
						<td valign=\"top\"><b>Slot Seçimi</b></td>
						<td valign='top' align='center'>:</td>
						<td valign=\"top\">" . $data->slot->shippingSlot->time1 . " - " . $data->slot->shippingSlot->time2 . "</td>
					</tr>";
        }

        foreach ($data->items as $key => $val) {
            $dataItems .= "
            <table width=\"100%\" height=\"40\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
              <tr>
                <td width='5%' style='padding-left:10px'>" . $val->product->img . "</td>
                <td width='43%'><a target='_blank' href='" . url(str_slug($val->name) . '-p-' . $val->product_id) . "' style='font-weight:normal; text-decoration:none;'>" . $val->name . "</a> <a title='Düzenle 'href='/admin/product/edit/id/268992' class='iconItemGrid icon-ico editDetail'></a></td>
                <td width='10%'>x " . $val->qty . "</td>
                <td width='20%'><div style='width:100px;word-wrap:break-word;'>" . $val->stock_code . "</div></td>
                <td width='15%'>" . $price->currencyFormat($val->price) . " TL</td>
                <td width='15%'></td>
              </tr>
	        </table>";

            // Genel Toplam Tutarını Hesapla
            $grandTotalPrice += ($val->price * $val->qty);
        }

        $bankText = "";
        if ($data->payment_type == 1) {
            $bank = \App\Bank::find($data->bank_id);

            if ($bank) {
                $bankText = "<tr>
					<td valign=\"top\"><b>Ödeme İşlemi</b></td>
					<td valign='top' align='center'>:</td>
					<td valign=\"top\">" . $bank->name . " - " . $bank->owner . "-" . $bank->iban . ' - Hesap Türü : ' . $bank->currency . "</td>
				</tr>";
            } else {
                $bankText = '<tr valign="top"><td valign="top" align="center">Banka bilgilerine ulaşılamadı.</td></tr>';
            }
        }

        $paymentText = "";
        if ($data->payment_type == 2 || $data->payment_type == 4) {
            $paymentText = "
		<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
		  <tr>
			<td width=\"44%\" style=\"padding-left:10px;\">
			</td>
			<td width=\"30%\" style='text-align:right;'>
				<b>" . $data->payment . " Ücreti:</b>
			</td>
			<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px'>
				" . $price->currencyFormat($data->pdAmount) . " TL
			</td>
		  </tr>
		</table>";

            $grandTotalPrice += $data->pdAmount;
        } else {
            $paymentText = "";
        }

        return "<span class='DataList'>
<table width='100%' cellspacing='2' cellpadding='2' style='font-size:12px;font-family:arial; padding:0px 0px 5px 0px;'>
	<tr>
        <td width='20%' valign=\"top\"><b>Müşteri Bilgileri</b></td>
        <td valign='top' align='center' valign=\"top\">:</td>
        <td valign=\"top\">" . $data->customer->fullname . "  " . $data->customer->email . "  " . $data->shippingAddress->phone . " / " . $data->shippingAddress->phoneGsm . "</td>
    </tr>

    <tr>
		<td width='20%' valign=\"top\"><b>Ref No / Sipariş No</b></td>
		<td valign='top' align='center' valign=\"top\">:</td>
		<td valign=\"top\">" . $data->order_no . "</td>
	</tr>

	<tr>
		<td valign=\"top\"><b>Ödeme Türü</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->payment . "</td>
	</tr>
	<tr>
		<td valign=\"top\"><b>Sipariş Durumu</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->statusText . "</td>
	</tr>
	" . $bankText . "
	<tr>
		<td valign=\"top\"><b>Kargo Firması</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->shippingCompany->name . "</td>
	</tr>
	" . $slot . "
	<tr>
		<td valign=\"top\"><b>Kargo No</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->shipping_no . "</td>
	</tr>
	<tr>
		<td valign=\"top\"><b>Sipariş Tarihi</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->created_at . "</td>
	</tr>
	<tr>
		<td valign=\"top\"><b>Sipariş Notu</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->customer_note . "</td>
	</tr>
	<tr>
		<td valign=\"top\"><b>IP Adresi</b></td>
		<td valign='top' align='center'>:</td>
		<td valign=\"top\">" . $data->ip . "</td>
	</tr>
</table>
<table width=\"100%\" height=\"30\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#F4F4F4;border-collapse:collapse;font-size:12px;font-family:arial;border:1px solid #D7D7D7;\">
  <tr>
	<td width='5%' style='padding-left:3px'><a href=\"javascript:void(0)\" class=\"bonibonItemGrid bonibon-ico quickPicture\"></a></td>
    <td width='41%'><b>Sepetim</b></td>
	<td width='11%'><b>Miktar</b></td>
	<td width='19%'><b>Stok Kodu</b></td>
	<td width='14%'><b>Fiyat</b></td>
	<td width='17%'><b></b></td>
  </tr>
</table>
<div style=\"width:100%;max-height:121px;overflow-y:scroll; overflow-x:hidden; background:#fff; border-bottom: 1px solid #D7D7D7\">
" . $dataItems . "
</div>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>Ara Toplam:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->grand_total - $data->tax_amount) . " TL
	</td>
  </tr>
</table>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>KDV:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->tax_amount) . " TL
	</td>
  </tr>
</table>
<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
  <tr>
    <td width=\"44%\" style=\"padding-left:10px;\">
	</td>
	<td width=\"30%\" style='text-align:right;'>
		<b>KDV Dahil:</b>
	</td>
	<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
		" . $price->currencyFormat($data->grand_total) . " TL
	</td>
  </tr>
</table>
" . $discountInfo . "
	<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
	  <tr>
		<td width=\"44%\" style=\"padding-left:10px;\">
		</td>
		<td width=\"30%\" style='text-align:right;'>
			<b>Kargo Ücreti:</b>
		</td>
		<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px'>
			" . $price->currencyFormat($data->shipping_amount) . " TL
		</td>
	  </tr>
	</table>
	" . $paymentText . "
	<table width=\"100%\" height=\"25\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
	  <tr>
		<td width=\"44%\" style=\"padding-left:10px;\">
		</td>
		<td width=\"30%\" style='text-align:right;'>
			<b>Genel Toplam:</b>
		</td>
		<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px'>
			" . $price->currencyFormat(($data->grand_total) - $data->discount_amount) . " TL
		</td>
	  </tr>
	</table>
</span>";
    }

    public function delete($id)
    {
        try {
            $order = Order::with('items')->find($id);

            // ürünleri stoğa geri alalım
            foreach ($order->items as $orderItem) {
                DB::table('products')
                    ->where('id', $orderItem['product_id'])
                    ->increment('stock', $orderItem['qty']);
            }

            LogActivity::addToLog(
                sprintf(
                    'Sipariş silindi. OrderId ==> %s', 
                    $order->id
                ),
                $order
            );

            $order->delete();

            Session()->flash('status', array(1, "Silindi."));
        } catch (Exeption $e) {
            Session()->flash('status', array(0, "Hata Oluştu."));
        }

        //return redirect('admin/orders');
        return redirect()->back();
    }

    public function printOrderShipping($id)
    {
        $order    = Order::find($id);
        $settings = \App\Settings_basic::first();
        $company  = json_decode($settings->company);

        $paymentopt = "";
        $barcode    = "";

        if ($order->shippingCompany->pay_type == 0) {
            $paymentopt = "Gönderici Ödemeli Kargo";
        } else {
            $paymentopt = "Alıcı Ödemeli";
        }

        if (!empty($order->order_no)) {
            $barcode = '
<table width="400" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
    <tr>
         <td style="padding-left:5px;"><b>Barkod</b></td>
    </tr>
</table>
<table width="400" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
	<tr>
			<td style="text-align:center;padding-bottom:5px;padding-top:15px" valign="top">
			<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($order->order_no, 'C128', 1.5, 60) . '" alt="barcode"/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center; font-size: 1rem; padding-bottom:7px;">' . $order->order_no . '</td>
	</tr>
</table>';
        }

        if ($order) {

            $data = '<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script language="javascript">
        window.print();
    </script>
</head>
<body>
    <table width="400" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
    <tr>
        <td style="padding-left:5px;"><b>Alıcı Bilgileri</b></td>
    </tr>
</table>
<table width="400" cellspacing="2" cellpadding="2" align="center" style="font-size:11px;font-family:arial; padding:0px 0px 5px 0px; border-left:1px solid #BBB; border-right:1px solid #BBB;">
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">İsim</td>
        <td valign="top"> : </td>
        <td valign="top">' . $order->shippingAddress->name . ' ' . $order->shippingAddress->surname . '</td>
    </tr>
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">Adres</td>
        <td valign="top"> : </td>
        <td valign="top">
                ' . $order->shippingAddress->address . '
                <br>
                ' . $order->shippingAddress->state . ' / ' . $order->shippingAddress->city . ' / Türkiye
                <br>
                ' . $order->shippingAddress->phone . ' / ' . $order->shippingAddress->phoneGsm . '
                </td>
    </tr>
</table>
<table width="400" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
    <tr>
        <td style="padding-left:5px;"><b>Gönderen Bilgileri</b></td>
    </tr>
</table>
<table width="400" cellspacing="2" cellpadding="2" align="center" style="font-size:11px;font-family:arial; padding:0px 0px 5px 0px; border-left:1px solid #BBB; border-right:1px solid #BBB; border-bottom: 1px solid #BBB;">
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">İsim</td>
        <td valign="top"> : </td>
        <td valign="top">' . $company->company_name . '</td>
    </tr>
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">Telefon</td>
        <td valign="top"> : </td>
        <td valign="top">' . $company->company_phone . '</td>
    </tr>
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">Adres</td>
        <td valign="top"> : </td>
        <td valign="top">' . $company->company_address . '</td>
    </tr>
</table>
<table width="400" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
    <tr>
        <td style="padding-left:5px;"><b>Kargo Bilgileri</b></td>
    </tr>
</table>
<table width="400" cellspacing="2" cellpadding="2" align="center" style="font-size:11px;font-family:arial; padding:0px 0px 5px 0px; border-left:1px solid #BBB; border-right:1px solid #BBB; border-bottom: 1px solid #BBB;">
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">Ödeme Türü</td>
        <td valign="top"> : </td>
        <td valign="top">
            ' . $order->payment . '
        </td>
    </tr>         <tr>
        <td valign="top" style="font-weight:bold;" width="100">Kargo Firması</td>
        <td valign="top"> : </td>
        <td valign="top">' . $order->shippingCompany->name . '</td>
    </tr>
    <tr>
        <td valign="top" style="font-weight:bold;" width="100">Kargo Tipi</td>
        <td valign="top"> : </td>
        <td valign="top">
                        ' . $paymentopt . '
                    </td>
    </tr>
    ' . $barcode . '
</table>
</body>
</html>';
        } else {

            $data = "Sipariş Bulunamadı.";
        }

        return $data;
    }

    public function printOrder($id)
    {
        $price         = new Price();
        $data          = Order::find($id);
        $dataItems     = "";
        $promosyon     = "";
        $promosyonInfo = "";
        $barcode       = "";
        // Genel Toplam Fiyatı
        $grandTotalPrice = 0;

        if (!empty($data->order_no)) {
            $barcode = '
			<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
			    <tr>
			         <td style="padding-left:5px;"><b>Barkod</b></td>
			    </tr>
			</table>
			<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #BBB;">
			    <tr>
					 <td style="text-align:center;padding-bottom:5px;padding-top:15px" valign="top">
						<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data->order_no, 'C128', 1.5, 60) . '" alt="barcode"/>
					</td>
			    </tr>
			    <tr>
			    	<td style="text-align:center; font-size: 1rem; padding-bottom:7px;">' . $data->order_no . '</td>
			    </tr>
			</table>';
        }

        $slot = "";

        if ($data->slot) {
            $slot = "<tr>
						<td valign=\"top\"><b>Teslimat Saati</b></td>
						<td valign='top' align='center'>:</td>
						<td valign=\"top\">" . $data->slot->shippingSlot->time1 . " - " . $data->slot->shippingSlot->time2 . "</td>
					</tr>";
        }

        // Kargo ücreti var ise faturaya yansıtalım
        if ($data->shipping_amount > 0) {
            $grandTotalPrice += $data->shipping_amount;
        }

        $shippingAddress = $data->shippingAddress;
        $billingAddress  = $data->billingAddress;

        $discountInfo = "";
        if ($data->discount_amount > 0 && $data->coupon_code == null) {
            $discountInfo = "<table width=\"700\" height=\"30\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Promosyon Avantajı:</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
        } elseif ($data->discount_amount > 0 && $data->coupon_code != null) {
            $discountInfo = "<table width=\"700\" height=\"30\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:left;background:#fff;border-collapse:collapse;font-size:12px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;\">
			  <tr>
			    <td width=\"44%\" style=\"padding-left:10px;\">
				</td>
				<td width=\"30%\" style='text-align:right;'>
					<b>Kupon Kodu İndirimi (" . $data->coupon_code . "):</b>
				</td>
				<td width=\"26%\" style='padding: 0pt 0pt 0pt 16px;'>
					" . $price->currencyFormat($data->discount_amount) . " TL
				</td>
			  </tr>
			</table>";
        }

        foreach ($data->items as $key => $val) {
            $dataItems .=
            '<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;border-bottom:1px solid #D7D7D7;">
				  <tr>
					<td width=\'46%\' style=\'padding-left:5px\'><a target=\'_blank\' font-weight:normal; text-decoration:none; font-size:11px;\'>' . $val->name . '</a> </td>
					<td width=\'11%\'>x ' . $val->qty . '</td>
					<td width=\'19%\'>' . $val->stock_code . '</td>
					<td width=\'14%\'>' . $price->currencyFormat($val->price) . ' TL</td>
					<td width=\'17%\'></td>
				  </tr>
				</table>';

            // Genel Toplamı Hesapla
            $grandTotalPrice += floatval($val->price * $val->qty);
        }

        // alınan çıktı miktarını güncelle
        $data->increment('order_detail_output');

        return ('

<span class=\'PrinterFriendly\'>
<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #D7D7D7;">
	<tr>
		<td style="padding-left:5px;"><b>Sipariş Bilgileri</b></td>
	</tr>
</table>
<table width=\'700\' cellspacing=\'2\' cellpadding=\'2\' align="center" style=\'font-size:11px;font-family:arial; padding:0px 0px 5px 0px; border-left:1px solid #D7D7D7; border-right:1px solid #D7D7D7;\'>
	<tr>
		<td width=\'20%\' valign="top"><b>Ref No / Sipariş No</b></td>
		<td valign=\'top\' align=\'center\' valign="top">:</td>
		<td valign="top">' . $data->order_no . '</td>
	</tr>
	<tr>
		<td valign="top"><b>Ödeme Türü</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->payment . '</td>
	</tr>
	<tr>
		<td valign="top"><b>Sipariş Durumu</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->statusText . '</td>
	</tr>
	<tr>
		<td valign="top"><b>Kargo Firması</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->shippingCompany->name . '</td>
	</tr>
	' . $slot . '
	<tr>
		<td valign="top"><b>Kargo No</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->shipping_no . '</td>
	</tr>
	<tr>
		<td valign="top"><b>Sipariş Tarihi</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->created_at . ' </td>
	</tr>
	<tr>
		<td valign="top"><b>Sipariş Notu</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->customer_note . '</td>
	</tr>
	<tr>
		<td valign="top"><b>IP Adresi</b></td>
		<td valign=\'top\' align=\'center\'>:</td>
		<td valign="top">' . $data->ip . '</td>
	</tr>

</table>
<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #D7D7D7;">
  <tr>
    <td width=\'46%\' style=\'padding-left:3px\'><b>Sepetim</b></td>
	<td width=\'11%\'><b>Miktar</b></td>
	<td width=\'19%\'><b>Stok Kodu</b></td>
	<td width=\'14%\'><b>Fiyat</b></td>
	<td width=\'17%\'><b></b></td>
  </tr>
</table>
	' . $dataItems . '
	' . $promosyon . '
<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;">
  <tr>
    <td width="44%" style="padding-left:10px;">
	</td>
	<td width="30%" style=\'text-align:right;\'>
		<b>Ara Toplam:</b>
	</td>
	<td width="26%" style=\'padding: 0pt 0pt 0pt 15px;\'>
		' . $price->currencyFormat($grandTotalPrice - $data->tax_amount) . ' TL
	</td>
  </tr>
</table>
<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;">
  <tr>
    <td width="44%" style="padding-left:10px;">
	</td>
	<td width="30%" style=\'text-align:right;\'>
		<b>KDV:</b>
	</td>
	<td width="26%" style=\'padding: 0pt 0pt 0pt 15px;\'>
		' . $price->currencyFormat($data->tax_amount) . ' TL
	</td>
  </tr>
</table>
<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;">
  <tr>
    <td width="44%" style="padding-left:10px;">
	</td>
	<td width="30%" style=\'text-align:right;\'>
		<b>KDV Dahil:</b>
	</td>
	<td width="26%" style=\'padding: 0pt 0pt 0pt 15px;\'>
		' . $price->currencyFormat($grandTotalPrice) . ' TL
	</td>
  </tr>
</table>
' . $discountInfo . '
	<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;">
	  <tr>
		<td width="44%" style="padding-left:10px;">
		</td>
		<td width="30%" style=\'text-align:right;\'>
			<b>Kargo Ücreti:</b>
		</td>
		<td width="26%" style=\'padding: 0pt 0pt 0pt 15px\'>
			' . $price->currencyFormat($data->shipping_amount) . ' TL
		</td>
	  </tr>
	</table>
	<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align:left;background:#fff;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7;border-right:1px solid #D7D7D7;">
	  <tr>
		<td width="44%" style="padding-left:10px;">
		</td>
		<td width="30%" style=\'text-align:right;\'>
			<b>Genel Toplam:</b>
		</td>
		<td width="26%" style=\'padding: 0pt 0pt 0pt 15px\'>
			' . $price->currencyFormat($grandTotalPrice - $data->discount_amount) . ' TL
		</td>
	  </tr>
	</table>
</span>
<span class=\'PrinterFriendly\'>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border-left:1px solid #D7D7D7; border-right:1px solid #D7D7D7; border-top:1px solid #D7D7D7;">
	<tr>
		<td style="padding-left:5px;"><b>Fatura Bilgileri</b></td>
	</tr>
	</table>
	<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff;font-size:11px;font-family:arial;border:1px solid #D7D7D7; padding:5px;">
	<tr>
		<td width="120" valign="top"><strong>Adı Soyadı</strong></td>
	  	<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $billingAddress->name . ' ' . $billingAddress->surname . '</td>
	</tr>
	<tr>
		<td width="120" valign="top"><strong>Adres</strong></td>
		<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $billingAddress->address . ' ' . $billingAddress->state . ' ' . $billingAddress->city . '</td>
	</tr>
	<tr>
		<td width="120" valign="top"><strong>Telefon</strong></td>
	  	<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $billingAddress->phone . '</td>
	</tr>
	<tr>
		<td valign="top"><strong>Cep Telefonu</strong></td>
	    <td align="center" valign="top"><strong>:</strong></td>
	    <td>' . $billingAddress->phoneGsm . '</td>
	</tr>
	<tr>
		<td valign="top"><strong>Vergi No</strong></td>
	    <td align="center" valign="top"><strong>:</strong></td>
	    <td>' . $billingAddress->tax_no . '</td>
	</tr>
	<tr>
		<td valign="top"><strong>Vergi Dairesi</strong></td>
	    <td align="center" valign="top"><strong>:</strong></td>
	    <td>' . $billingAddress->tax_place . '</td>
	</tr>
	</table>
        <table width="700" height="80">
                <tr>
                    <td>
                    </td>
                </tr>
        </table>
	<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4;border-collapse:collapse;font-size:11px;font-family:arial;border:1px solid #D7D7D7;">
		<tr>
			<td style="padding-left:5px;"><b>Teslimat Bilgileri</b></td>
		</tr>
	</table>
	<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff;border-left:1px solid #D7D7D7;font-size:11px;font-family:arial;border-right:1px solid #D7D7D7; padding:5px;">
	<tr>
		<td width="120" valign="top"><strong>Adı Soyadı</strong></td>
	  	<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $shippingAddress->name . ' ' . $shippingAddress->surname . '</td>
	</tr>

	<tr>
		<td width="120" valign="top"><strong>Adres</strong></td>
		<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $shippingAddress->address . ' ' . $shippingAddress->state . ' ' . $shippingAddress->city . '</td>
	</tr>
	<tr>
		<td width="120" valign="top"><strong>Telefon</strong></td>
	  	<td align="center" valign="top" width="5"><strong>:</strong></td>
	  	<td>' . $shippingAddress->phone . '</td>
	</tr>
	<tr>
		<td valign="top"><strong>Cep Telefonu</strong></td>
	    <td align="center" valign="top"><strong>:</strong></td>
	    <td>' . $shippingAddress->phoneGsm . '</td>
	</tr>
	' . $barcode . '
	</table>


</span><script language="javascript">
window.print();
</script>
        ');
    }

    public function invoiceSettings()
    {
        return view('admin/invoiceSettings');
    }

    public function invoiceCreator(Request $request)
    {
        if ($request->has("itemIndex")) {
            $itemIndex = explode("|", $request->get('itemIndex'));
        } else {
            $itemIndex = 0;
        }

        $lastPage = boolval($request->get('lastPopup'));

        $order          = Order::find($request->get("id"));
        $billingAddress = $order->billingAddress;
        $price          = new Price();
        $opp            = json_decode($order->promotionProducts, true);
        $tax18          = 0;
        $tax8           = 0;
        $tax1           = 0;
        $tax18amount    = 0;
        $tax8amount     = 0;
        $tax1amount     = 0;
        $taxes          = "";
        $names          = "";
        $units          = "";
        $qty            = "";
        $one_price      = "";
        $ttl_price      = "";

        // Toplam Tutar
        $grandTotalPrice = 0;

        // Genel tutarı hesapla
        $order->items->map(function ($item) use (&$grandTotalPrice) {
            $grandTotalPrice += ($item->price * $item->qty);
        });

        if ($itemIndex != 0) {
            foreach ($itemIndex as $key => $value) {
                $promosyonEk = "";
                if (is_array($opp) && array_key_exists(@$order->items[$value]->product_id, $opp)) {
                    $order->items[$value]->price = $order->items[$value]->price - ($opp[$order->items[$value]->product_id] / $order->items[$value]->qty);
                    $promosyonEk                 = "Promosyon (" . $price->currencyFormat($opp[$order->items[$value]->product_id] / $order->items[$value]->qty) . ")";
                }
                $names .= "<div class=\"listItem\">" . $order->items[$value]->name . " " . $promosyonEk . "</div>";
                $units .= "<div class=\"listItem\">" . $order->items[$value]->product->stockTypeString . "</div>";
                $qty .= "<div class=\"listItem\">" . $order->items[$value]->qty . "</div>";
                $taxes .= "<div class=\"listItem\">" . $order->items[$value]->product->tax . "</div>";
                $one_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->items[$value]->price) . "</div>";
                $ttl_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->items[$value]->price * $order->items[$value]->qty) . "</div>";
            }
        } else {
            foreach ($order->items as $item) {
                $promosyonEk = "";
                if (is_array($opp) && array_key_exists(@$item->product_id, $opp)) {
                    $item->price = $item->price - ($opp[$item->product_id] / $item->qty);
                    $promosyonEk = "Promosyon (" . $price->currencyFormat($opp[$item->product_id] / $item->qty) . ")";
                }
                $names .= "<div class=\"listItem\">" . $item->name . " " . $promosyonEk . "</div>";
                $units .= "<div class=\"listItem\">" . $item->product->stockTypeString . "</div>";
                $qty .= "<div class=\"listItem\">" . $item->qty . "</div>";
                $taxes .= "<div class=\"listItem\">" . $item->product->tax . "</div>";

                $one_price .= "<div class=\"listItem\">" . $price->currencyFormat($item->price) . "</div>";
                $ttl_price .= "<div class=\"listItem\">" . $price->currencyFormat($item->price * $item->qty) . "</div>";

                // Toplam tutarı hepla
            }
        }

        if (empty($request->get('billingDate'))) {
            $billDate = date('d.m.Y H:i:s');
        } else {
            $billDate = $request->get('billingDate');
        }

        //dd($taxes);
        LogActivity::addToLog('Fatura çıktısı alındı.');

        if ($request->get('lastPopup') == 1) {
            $order->billOutput = $order->billOutput + 1;
            $order->save();

            foreach ($order->items as $item) {
                switch ($item->product->tax) {
                    case '18':
                        $tax18 += ($item->price * $item->qty) / (1 + (18 / 100)) /*($item->price*$item->qty)*/
                        /** (1 + (18/100))*/
                        ;
                        $tax18amount += (($item->price / 1.18) * $item->qty) * (18 / 100);
                        break;
                    case '8':
                        $tax8 += ($item->price * $item->qty) / (1 + (8 / 100));
                        $tax8amount += (($item->price / 1.08) * $item->qty) * (8 / 100);
                        break;
                    case '1':
                        $tax1 += ($item->price * $item->qty) / (1 + (1 / 100));
                        $tax1amount += (($item->price / 1.01) * $item->qty) * (1 / 100);
                        break;
                    default:
                        break;
                }
            }

            if ($order->pdAmount > 0) {
                $tax18 += ($order->pdAmount) / (1 + (18 / 100)) /*($item->price*$item->qty)*/
                /** (1 + (18/100))*/
                ;
                $tax18amount += ($order->pdAmount / 1.18) * (18 / 100);
                $names .= "<div class=\"listItem\">" . $order->payment . "</div>";
                $units .= "<div class=\"listItem\">Adet</div>";
                $qty .= "<div class=\"listItem\">1</div>";
                $taxes .= "<div class=\"listItem\">18</div>";
                $one_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->pdAmount) . "</div>";
                $ttl_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->pdAmount) . "</div>";

                // Genel Toplama Ürün İndirim Fiyatınıda Ekle
                $grandTotalPrice += $order->pdAmount;
            }

            // Kargo ücreti var ise faturaya yansıtalım
            if ($order->shipping_amount > 0) {
                $tax18 += ($order->shipping_amount) / (1 + (18 / 100));
                $tax18amount += ($order->shipping_amount / 1.18) * (18 / 100);
                $names .= "<div class=\"listItem\">Kargo Ücreti</div>";
                $units .= "<div class=\"listItem\">Adet</div>";
                $qty .= "<div class=\"listItem\">1</div>";
                $taxes .= "<div class=\"listItem\">18</div>";
                $one_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->shipping_amount) . "</div>";
                $ttl_price .= "<div class=\"listItem\">" . $price->currencyFormat($order->shipping_amount) . "</div>";

                // Genel Toplama Kargo Fiyatınıda Ekle
                $grandTotalPrice += $order->shipping_amount;
            }
        }

        if ($request->get('lastPopup') == 1 || $request->has('itemIndex')) {
            $ek = "";
        } else {
            $ek = "var productContainerHeight = '700';
                if(parseInt(productContainerHeight)>0){
                    var productContainerClass = \"\";
                    if(jQuery(\"#productLabel_w\").attr('id')!=undefined){
                        productContainerClass = \"productLabel_w\";
                    }else if(jQuery(\"#stockCode_w\").attr('id')!=undefined){
                        productContainerClass = \"stockCode_w\";
                    }else if(jQuery(\"#barCode_w\").attr('id')!=undefined){
                        productContainerClass = \"barCode_w\";
                    }
                    var listItemHeight = jQuery(\"#\"+productContainerClass+\" div.listItem\").height(); // <div class=\"listItem\"></div> taginin height değeri.
                    var maxProductCount = Math.floor(productContainerHeight / listItemHeight);
                    var listItemCount = item.length;
                    var popupCount = Math.ceil(item.length / maxProductCount);
                    var itemCount = 0;
                    var itemArr = new Array();
                    if(popupCount>1){
                        for(var i=0; i<listItemCount; i++){
                            itemCount++;
                            itemArr.push(i);
                            if(itemCount==maxProductCount || i==listItemCount-1){
                                if(listItemCount-1 == i){
                                    window.open('invoiceCreator?id=" . $order->id . "&billingDate=" . $billDate . "&irsaliyeDate=&irsaliyeNumber=&_token=" . $request->get('_token') . "&itemIndex='+itemArr.join('|')+'&lastPopup=1','_blank','width=777,height=962,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');
                                }else{
                                    window.open('invoiceCreator?id=" . $order->id . "&billingDate=" . $billDate . "&irsaliyeDate=&irsaliyeNumber=&_token=" . $request->get('_token') . "&itemIndex='+itemArr.join('|'),'_blank','width=777,height=962,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');
                                }
                                itemCount = 0;
                                itemArr = new Array();
                            }
                        }
                    }else{
                        window.open('invoiceCreator?id=" . $order->id . "&billingDate=" . $billDate . "&irsaliyeDate=&irsaliyeNumber=&_token=" . $request->get('_token') . "&lastPopup=1','_blank','width=777,height=962,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');
                    }
                }else{
                    window.open('invoiceCreator?id=" . $order->id . "&billingDate=" . $billDate . "&irsaliyeDate=&irsaliyeNumber=&_token=" . $request->get('_token') . "&lastPopup=1','_blank','width=777,height=962,resizable=0,scrollbars=yes,titlebar=no,location=no,toolbar=no');
                }";
        }

        return view('admin.invoice.show', compact(
            'ek',
            'order',
            'names',
            'billingAddress',
            'price',
            'billDate',
            'qty',
            'one_price',
            'ttl_price',
            'taxes',
            'grandTotalPrice',
            'tax1amount',
            'tax8amount',
            'tax18amount',
            'tax1',
            'tax8',
            'tax18',
            'units',
            'lastPage'
        ));
    }

    public function updateShippingNumModal(Request $request)
    {
        $order             = Order::find($request->get('id'));
        $shippingCompanies = Shipping::select("name", "id")->get();

        $options = $shippingCompanies->map(function ($item) use ($order) {
            $selected = $item->id == $order->shipping_id ? ' selected ' : '';

            return '<option ' . $selected . ' value="' . $item->id . '">' . $item->name . '</option>';
        })->implode('');

        $message = '<div id="shippingUpdate-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div style="max-width:600px" class="modal-dialog">
                            <div class="modal-content">
                                <form id="add_brand" method="post" action="' . url('admin/orders/updateShippingNumSave') . '/' . $order->id . '" class="form-horizontal form-bordered">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Kargo Düzenle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="shipping_id" class="col-sm-3 control-label">Kargo Firması</label>
                                            <div class="col-sm-9">
                                                <select name="shipping_id" id="shipping_id" class="form-control" data-style="form-control" data-width="100%">
                                                    ' . $options . '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shippingNo" class="col-sm-3 control-label">Kargo No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="shippingNo" id="shippingNo" value="' . $order->shipping_no . '">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="$.updateShippingNumSave()" class="btn btn-danger waves-effect waves-light">Güncelle</button>
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                    </div>
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                </form>
                            </div>
                        </div>
                    </div>';

        return response()->json([
            "status"  => true,
            "message" => $message,
        ]);
    }

    public function shortUpdateSave(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        try {
            $order->update([
                'shipping_id' => $request->get('shipping_id'),
                'shipping_no' => $request->get('shippingNo'),
            ]);

            $order->sendSms(null , true);

            $this->sendOrderMail($order);

            $request->session()->flash('status', array(1, "Tebrikler!"));

            LogActivity::addToLog('Kargo durumu düzenlendi.');

            $response = ["status" => 200, "message" => "Kargo durumu düzenlendi."];
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
            $response = ["status" => 0, "message" => "Hata Oluştu!"];
        }
        return response()->json($response);
    }

    /**
     * Resend Order Email
     */
    public function resendMail(Request $request)
    {
        $order = Order::findOrFail($request->get('id'));

        if (!$order) {
            return response()->json([
                "status"  => 0,
                "message" => "Böyle bir sipariş bulunmuyor!",
            ]);
        }

        $this->sendOrderMail($order);

        LogActivity::addToLog('Sipariş maili tekrar gönderildi.');

        return response()->json([
            "status"  => 200,
            "message" => "Mail tekrar gönderildi.",
        ]);
    }

    public function sendOrderMail($order)
    {
        $myPrice   = new Price();
        $mailItems = "";
        $name      = $order->customer->name;
        $surname   = $order->customer->surname;

        $mailText = "";
        $subject  = "";

        switch ($order->status) {
            case 1:
                $mailText = "Siparişiniz onaylanmıştır. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz onaylanmıştır.";
                break;
            case 2:
                $mailText = "Siparişiniz kargoya verilmiştir. Sipariş detayları aşağıdadır.<br>";
                $subject  = "Siparişiniz kargoya verilmiştir.";
                if (!empty($order->shipping_no)) {
                    $mailText .= "Kargo No: " . $order->shipping_no;
                }
                break;
            case 3:
                $mailText = "Siparişiniz iptal edilmiştir. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz iptal edilmiştir.";
                break;
            case 4:
                $mailText = "Siparişiniz teslim edilmiştir. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz teslim edilmiştir.";
                break;
            case 5:
                $mailText = "Siparişiniz tedarik sürecindedir. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz tedarik sürecindedir.";
                break;
            case 6:
                $mailText = "Siparişiniz için ödeme beklenmektedir. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz için ödeme beklenmektedir.";
                break;
            case 7:
                $mailText = "Siparişiniz hazırlanmaktadır. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz hazırlanmaktadır.";
                break;
            case 8:
                $mailText = "Siparişiniz iade edildi. Sipariş detayları aşağıdadır.";
                $subject  = "Siparişiniz iade edildi.";
                break;
            default:
                $mailText = "Siparişiniz sisteme aşağıdaki bilgiler ile kaydedilmiştir.";
                $subject  = "Sipariş Dekontu / ID No : " . $order->id;
                if ($order->payment_type == 1) {
                    $mailText .= " Ödemeniz gereken tutar " . $myPrice->currencyFormat($order->grand_total) . " TL 'dir.";
                }
                break;
        }

        foreach ($order->items as $key => $v) {
            $mailItems .= '<table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
                              <tbody>
                                <tr style="background: #f1f1f1; font-size: 12px">
                                  <td width="31%">' . $v["name"] . '</td>
                                  <td width="19%">' . $v["stock_code"] . '</td>
                                  <td width="13%">' . $myPrice->currencyFormat($v["price"]) . ' TL</td>
                                  <td width="7%">x' . $v["qty"] . '</td>
                                  <td width="15%">  ' . $myPrice->currencyFormat($v["price"] * $v["qty"]) . ' TL</td>
                                  <td width="15%">  ' . $myPrice->currencyFormat($v["price"]) . ' TL</td>
                                </tr>
                              </tbody>
                            </table>';
        }

        $shippingAddress = $order->shippingAddress; //\App\ShippingAddress::where('id','=',$order->shipping_address_id)->first();
        $billingAddress  = $order->billingAddress; //\App\BillingAddress::where('id','=',$order->billing_address_id)->first();

        $discountInfo = "";
        if ($order->discount_amount > 0 && $order->coupon_code == null) {
            $discountInfo = '
            <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
              <tbody>
                <tr>
                  <td width="50%"> </td>
                  <td width="20%"><strong> Promosyon Avantajı:</strong></td>
                  <td width="15%">  ' . $myPrice->currencyFormat($order->discount_amount) . ' TL</td>
                  <td width="15%">  ' . $myPrice->currencyFormat($order->discount_amount) . ' TL</td>
                </tr>
              </tbody>
            </table>';
        } elseif ($order->discount_amount > 0 && $order->coupon_code != null) {
            $discountInfo = '
            <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
              <tbody>
                <tr>
                  <td width="50%"> </td>
                  <td width="20%"><strong> Kupon Kodu İndirimi (' . $order->coupon_code . '):</strong></td>
                  <td width="15%">  ' . $myPrice->currencyFormat($order->discount_amount) . ' TL</td>
                  <td width="15%">  ' . $myPrice->currencyFormat($order->discount_amount) . ' TL</td>
                </tr>
              </tbody>
            </table>';
        }

        if ($order->slot) {
            $slot = $order->slot->shippingSlot->time1 . " - " . $order->slot->shippingSlot->time2;
        } else {
            $slot = "";
        }

        try {
            \Mail::queue(
                'mailTemplates.order',
                array(
                    'name'            => $name,
                    'surname'         => $surname,
                    'bank'            => $order->payment_type == 1 ? \App\Bank::find($order->bank_id) : '',
                    'created'         => $order,
                    'date'            => Carbon::parse($order->created_at)->format('d-m-Y'),
                    'time'            => Carbon::parse($order->created_at)->format('H:i:s'),
                    'shippingAddress' => $shippingAddress,
                    'billingAddress'  => $billingAddress,
                    'shippingCompany' => $order->shippingCompany->name,
                    'slot'            => $slot,
                    'mailItems'       => $mailItems,
                    'taxAmount'       => $myPrice->currencyFormat($order->tax_amount),
                    'shippingAmount'  => $myPrice->currencyFormat($order->shipping_amount),
                    'grandTotal'      => $myPrice->currencyFormat($order->grand_total),
                    'discountInfo'    => $discountInfo,
                    'pdAmount'        => $myPrice->currencyFormat($order->pdAmount),
                    'mailText'        => $mailText,

                ),
                function ($message) use ($order, $subject) {
                    $message->from('consumer@marketpaketi.com.tr', 'marketpaketi.com.tr');
                    $message->to($order->customer->email)->subject($subject);
                }
            );

            $response = true;
        } catch (Exception $e) {
            $response = false;
        }

        return $response;
    }

    public function showNote(Request $request)
    {
        $order = Order::select(['id', 'note'])->where('id', $request->get('id'))->first();

        $message = '<div id="note-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	                    <div style="max-width:600px" class="modal-dialog">
	                        <div class="modal-content">
	                            <form id="add_brand" method="post" action="' . url('admin/orders/noteUpdate') . '/' . $order->id . '" class="form-horizontal form-bordered">
	                                <div class="modal-header">
	                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                                    <h4 class="modal-title">Not</h4>
	                                </div>
	                                <div class="modal-body">
	                                    <div class="form-group">
	                                        <label for="note" class="col-sm-3 control-label">Not</label>
	                                        <div class="col-sm-9">
	                                            <textarea type="text" class="form-control" name="note" id="note">' . $order->note . '</textarea>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="modal-footer">
	                                    <button type="submit" class="btn btn-success waves-effect waves-light">Kaydet</button>
	                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Kapat</button>
	                                </div>
	                                <input type="hidden" name="_token" value="' . csrf_token() . '">
	                            </form>
	                        </div>
	                    </div>
        </div>';
        $data = ["status" => true, "message" => $message];
        return json_encode($data);
    }

    public function updateNote(Request $request, $id)
    {
        $order = Order::select(['id', 'note'])->where('id', $id)->first();
        if ($order) {
            $order->note = $request->get('note');
            try {
                $order->save();
                $request->session()->flash('status', array(1, "Tebrikler!"));
                LogActivity::addToLog('Sipariş notu düzenlendi.');
            } catch (Exception $e) {
                $request->session()->flash('status', array(0, "Hata Oluştu!"));
            }
        }
        return redirect('admin/orders');
    }

    public function resendCargo()
    {
        $data         = ['username' => 'OZKORUGO', 'password' => '3BA99D4304874F'];
        $yurticiKargo = new YurticiKargo($data);

        $orders = Order::whereShippingId(6)
            ->whereStatus(1)
            ->where('created_at', '>', Carbon::now()->subDays(10))
            ->get();

        $orderNumbers = $orders->pluck('order_no')->toArray();
        $cargoResult  = $yurticiKargo->QueryShipment($orderNumbers);

        $notSendedOrders = collect();
        if (isset($cargoResult->ShippingDeliveryVO) && $cargoResult->ShippingDeliveryVO->outFlag === "0") {
            $details = $cargoResult->ShippingDeliveryVO->shippingDeliveryDetailVO;

            if ($cargoResult->ShippingDeliveryVO->count == "1") {
                if (isset($details->errCode) && $details->errCode == "82519") {
                    $notSendedOrders[] = $details;
                }
            } else if ($cargoResult->ShippingDeliveryVO->count > 1) {
                foreach ($details as $detail) {
                    if (isset($detail->errCode) && $detail->errCode == "82519") {
                        $notSendedOrders[] = $detail;
                    }
                }
            }
        }

        $successRecords = collect();
        $errorRecords   = collect();
        $notSendedOrders->map(function ($detail) use (&$successRecords, &$errorRecords) {
            $order        = Order::with('customer')->whereOrderNo($detail->cargoKey)->first();
            $createResult = $this->createShipmentYk($order);
            if ($createResult->outFlag == "1" && isset($createResult->shippingOrderDetailVO)) {
                $errorRecords[] = "Müşteri: <u style='color:red;'>" . $order->customer->fullname . " (<a target='blank' href='" . url('/admin/customers/edit/' . $order->customer->id) . "'>Düzenle</a>)</u> <br> ORDER NO: <u style='color:red;'>" . $createResult->shippingOrderDetailVO->cargoKey . "</u> <br> Hata Mesajı: <u style='color:red;'>" . $createResult->shippingOrderDetailVO->errMessage . "</u>";
            } else {
                $successRecords[$detail->cargoKey] = "SUCCESS";
            }
        });

        return response()->json([
            'error'  => (count($errorRecords) > 0 ? $errorRecords : false),
            'status' => (count($successRecords) > 0 ? 'success' : 'nothing'),
        ]);
    }

    public function QueryShipmentYkBulk()
    {
        $params = Order::select('order_no')
            ->where('shipping_id', 6)
            ->whereIn('status', [1, 2, 7])
            ->where('created_at', '>', Carbon::now()->subDays(10))
            ->pluck('order_no')
            ->toArray();

        $response = $this->yurticiKargo->QueryShipment($params);

        if ($response->ShippingDeliveryVO->outFlag == 0) {

            if ($response->ShippingDeliveryVO->count == 1) {
                $response->ShippingDeliveryVO->shippingDeliveryDetailVO = [$response->ShippingDeliveryVO->shippingDeliveryDetailVO];
            }

            foreach ($response->ShippingDeliveryVO->shippingDeliveryDetailVO as $key => $value) {

                if (isset($value->operationCode)) {

                    try {
                        $order = Order::where('order_no', $value->cargoKey)
                            ->with('shippingAddress')
                            ->first();

                        switch ($value->operationCode) {
                            case '1': // kargo teslimatta
                                    if ($order->status != 2) {
                                        $shippingInfo = $order->shippingAddress;

                                        // Takip numarasını ve kargoya verildi durumunu kaydet
                                        $order->update([
                                            'shipping_no' => $value->shippingDeliveryItemDetailVO->docId, 
                                            'status' => 2
                                        ]);

                                        // Mail Gönder
                                        $this->sendOrderMail($order);

                                        // Sms Gönder
                                        $order->sendSms(null, true);

                                        LogActivity::addToLog('KARGO API: Sipariş takip numarası eklendi ve durumu "Kargoya Verildi" olarak değiştirildi. Sipariş No => ' . $value->cargoKey);
                                    }
                                break;
                            // kargo teslim edildi
                            case '5':
                                    // Kargo Teslim edildi olarak güncelle
                                    $order->update([
                                        'shipping_no' => $value->shippingDeliveryItemDetailVO->docId,
                                        'status' => 4
                                    ]);

                                    // Mail Gönder
                                    $this->sendOrderMail($order);

                                    LogActivity::addToLog('KARGO API: Sipariş durumu "Teslim Edildi" olarak değiştirildi. Sipariş No => ' . $value->cargoKey);
                                break;
                            default:
                                LogActivity::addToLog('KARGO API: Hata! Beklenmeyen operasyon kodu. Sipariş No => ' . $value->cargoKey);
                                break;
                        }
                    } catch (Exception $e) {
                        LogActivity::addToLog('KARGO API: Hata! Kargo durumu api tarafından düzenlenemedi. Sipariş No => ' . $value->cargoKey);
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function createShipment(Request $request)
    {
        $order = Order::find($request->get('order_id'));

        if ($order) {

            $order->billing_no = $request->get('orderBillingNo');
            $order->save();

            switch ($order->shipping_id) {
                case 5:
                    $resp = $this->createShipmentSk($order);
                    break;

                case 6:
                    $resp = $this->createShipmentYk($order);
                    break;

                default:
                    $resp = json_encode(["Kargo firması için entegrasyon bulunmamaktadır"]);
                    break;
            }
        } else {
            $resp = json_encode(["Sipariş bulunamadı."]);
        }

        return $resp;
    }

    public function createShipmentYk($order)
    {
        $data   = ['username' => 'OZKORUGO', 'password' => '3BA99D4304874F'];
        $result = new YurticiKargo($data);

        $searchArr  = ["+90", "+", " ", "(", ")"];
        $replaceArr = ["", "", "", "", ""];

        $number = str_replace($searchArr, $replaceArr, $order->shippingAddress->phoneGsm);

        $params = [
            "cargoKey"         => $order->order_no,
            "invoiceKey"       => $order->order_no,
            "receiverCustName" => $order->shippingAddress->name . " " . $order->shippingAddress->surname,
            "taxOfficeId"      => "",
            "cargoCount"       => "",
            "ttDocumentId"     => "",
            "dcSelectedCredit" => "",
            "dcCreditRule"     => "",
            "receiverAddress"  => substr(trim($order->shippingAddress->address), 0, 490), // min:10-max:500 chars
            "receiverPhone1"   => $number,
        ];

        return $result->CreateShipment($params);
    }

    public function createShipmentSk($order)
    {
        $data   = ['username' => 'test', 'password' => '1234'];
        $result = new SuratKargo($data);
        $params = [
            "IrsaliyeSeriNo"           => "75899",
            "IrsaliyeSiraNo"           => "4158589",
            "KisiKurum"                => "idris",
            "Il"                       => "GAZİANTEP",
            "Ilce"                     => "Nizip",
            "KisiKurum"                => "Mustafa Öztürk",
            "AliciAdresi"              => "Api testtir dikkate almayınız.",
            "TelefonCep"               => "+90 (544) 537 19 93",
            "AliciKodu"                => "47585",
            "KargoTuru"                => "2",
            "Odemetipi"                => "1",
            "TeslimSekli"              => "1",
            "TasimaSekli"              => "1",
            "ReferansNo"               => "54585896",
            "OzelKargoTakipNo"         => "748858969",
            "Adet"                     => "1",
            "BirimDesi"                => "1",
            "BirimKg"                  => "1",
            "KargoIcerigi"             => "ilac",
            "KapidanOdemeTahsilatTipi" => 1,
            "KapidanOdemeTutari"       => 65,
            //"ttCollectionType"=>"0",
            //"ttInvoiceAmount"=>"0.0"

        ];
        return response()->json($result->CreateShipment($params));
    }

    public function stats(Request $request)
    {
        $expire_date = Carbon::now();
        switch ($request->get('dateOpt')) {
            case '0':
                $created_at  = new Carbon($request->get('start_date'));
                $expire_date = new Carbon($request->get('expire_date'));
                break;
            case '1':
                $created_at = Carbon::now()->subWeek();
                break;
            case '2':
                $created_at = Carbon::now()->subMonth();
                break;
            case '3':
                $created_at = Carbon::now()->startOfYear();
                break;
            default:
                $created_at = Carbon::now()->subMonth();
                break;
        }

        $myPrice = new Price();
        $now     = Carbon::now();
        $months  = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

        $chart2 = collect(DB::table('orders')
                ->select(
                    DB::raw('SUM(CASE WHEN status = 9 THEN 0 WHEN status = 3 THEN 0 ELSE grand_total END) AS total'),
                    DB::raw('SUM(CASE WHEN status = 1 THEN 1 WHEN status = 2 THEN 1 WHEN status = 4 THEN 1 WHEN status = 7 THEN 1 ELSE 0 END) AS onay'),
                    DB::raw('SUM(CASE WHEN status = 9 THEN 0 ELSE 1 END) AS tum'),
                    DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                    DB::raw('YEAR(created_at) year, MONTH(created_at) month')
                )
                ->groupby('year', 'month')
                ->whereYear('created_at', '=', date('Y'))
                ->get()
        )->keyBy('month');

        for ($i = 1; $i <= 12; $i++) {
            if (isset($chart2[$i])) {
                $chart2[$i]->monthText = $months[$i - 1];
                $montly[]              = (array) $chart2[$i];
            } else {
                $montly[] = ["total" => 0, "onay" => 0, "tum" => 0, "new_date" => $i . "-" . $now->year, "year" => $now->year, "month" => $i, "monthText" => $months[$i - 1]];
            }
        }

        $chart = DB::table('orders')
            ->select([
                DB::raw('DATE(created_at) AS date'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") AS dateformt'),
                DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) AS iptal'),
                DB::raw('SUM(CASE WHEN status = 9 THEN 0 WHEN status = 3 THEN 0 ELSE grand_total END) AS total'),
                DB::raw('SUM(CASE WHEN status = 1 THEN 1 WHEN status = 2 THEN 1 WHEN status = 4 THEN 1 WHEN status = 7 THEN 1 ELSE 0 END) AS onay'),
                //DB::raw('(CASE WHEN COUNT(id) = 0 THEN 0 ELSE 0 END) AS count'),
                //DB::raw('IF(COUNT(id) IS NULL, COUNT(id), 0)  AS count'),
                DB::raw('COUNT(id) AS count'),
            ])
            ->where('created_at', '>=', $created_at)
            ->where('created_at', '<=', $expire_date)
            ->where('status', '!=', '9')
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();

        $donut = DB::table('orders')
            ->select([
                DB::raw('SUM(CASE WHEN status = 1 THEN 1 WHEN status = 2 THEN 1 WHEN status = 4 THEN 1 WHEN status = 7 THEN 1 ELSE 0 END) AS value'),
                DB::raw('(CASE WHEN payment_type = 1 THEN "Havale/EFT" WHEN payment_type = 2 THEN "Kapıda Ödeme (Nakit)" WHEN payment_type = 3 THEN "Kredi Kartı" WHEN payment_type = 4 THEN "Kapıda Ödeme (Kredi Kartı)" ELSE "Tanımsız" END) AS label'),
            ])
            ->groupBy('label')
            ->get();

        $average = DB::table('orders')
            ->select([
                DB::raw('DATE(created_at) AS date'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") AS dateformt'),
                DB::raw('AVG(CASE WHEN status = 1 THEN grand_total WHEN status = 2 THEN grand_total WHEN status = 4 THEN grand_total WHEN status = 7 THEN grand_total ELSE 0 END) AS value'),
            ])
            ->where('created_at', '>=', $created_at)
            ->where('created_at', '<=', $expire_date)
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();

        $response = [
            "total"              => DB::table('orders')->where('created_at', '>=', $created_at)->where('created_at', '<=', $expire_date)->where('status', '!=', 9)->count(),
            "success"            => DB::table('orders')->where('created_at', '>=', $created_at)->where('created_at', '<=', $expire_date)->where('status', '!=', 9)
                ->where(function ($query) {
                    $query->where('status', '=', 1);
                    $query->orWhere('status', '=', 2);
                    $query->orWhere('status', '=', 4);
                    $query->orWhere('status', '=', 7);
                })->count(),
            "fail"               => DB::table('orders')->where('created_at', '>=', $created_at)->where('created_at', '<=', $expire_date)->where('status', '=', 3)->count(),
            "revenue"            => $myPrice->currencyFormat(DB::table('orders')->where('created_at', '>=', $created_at)->where('created_at', '<=', $expire_date)->where('status', '!=', 9)->where('status', '!=', 3)->sum('grand_total')),
            "chart"              => $chart,
            "chart2"             => $montly,
            "yearlyOrderSumOnay" => array_sum(array_column($montly, 'onay')),
            "yearlyOrderSumTum"  => array_sum(array_column($montly, 'tum')),
            "yearlyRevenueSum"   => $myPrice->currencyFormat(array_sum(array_column($montly, 'total'))),
            "donut"              => $donut,
            "average"            => $average,
        ];

        return $response;
    }

    public function repeatOrder($orderId)
    {
        $order = Order::with('items')->findOrfail($orderId);

        return $order->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity'   => $item->qty,
            ];
        });
    }
}
