<?php

namespace App;

use App\Contracts\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Order extends Model
{
    use SoftDeletes;

    public $fillable = [
        "id", "shipping_id", "shipping_no", "billing_no", "order_no", "member_id", "customer_email", "customer_note", "status", "payment_type", "bank_id", "billing_address_id", "shipping_address_id", "subtotal", "grand_total", "tax_amount", "shipping_amount", "pdAmount", "discount_amount", "promotionProducts", "coupon_code", "note", "ip", "billOutput", "statusMessage", "created_at",
    ];

    protected $appends = [
        'statusText', 'payment',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Send SMS By Order
     *
     * @param string|null $customStatusText
     * @param boolean $shippingInfo
     * @return mixed
     */
    public function sendSms(?string $customStatusText = null, bool $shippingInfo = false)
    {
        try {
            $shippingInfo = $shippingInfo
                ? " {$this->shippingCompany->name} Takip Numaranız: {$this->shipping_no}"
                : '';

            return (app('App\Contracts\Sms'))
                    ->number($this->shippingAddress->phoneGsm ?? $this->shippingAddress->phone)
                    ->message(sprintf(
                        'Sn. %s, %s referans numaralı siparişiniz %s%s',
                        $this->shippingAddress->full_name,
                        $this->order_no,
                        ($customStatusText ?: $this->status_text_sms),
                        $shippingInfo
                    ))
                    ->send();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    public function customer()
    {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }

    public function shippingCompany()
    {
        return $this->belongsTo('App\Shipping', 'shipping_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo('App\ShippingAddress', 'shipping_address_id', 'id');
    }

    public function billingAddress()
    {
        return $this->belongsTo('App\BillingAddress', 'billing_address_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Order_item', 'order_id');
    }

    public function getpaymentAttribute()
    {
        switch ($this->attributes["payment_type"]) {
            case 1:
                return "Havale/EFT";
                break;
            case 2:
                return "Kapıda Ödeme (Nakit)";
                break;
            case 3:
                return "Kredi Kartı";
                break;
            case 4:
                return "Kapıda Ödeme (Kredi Kartı)";
                break;

            default:
                return "Tanımsız";
                break;
        }
    }

    public function getStatusTextAttribute()
    {
        switch ($this->attributes["status"]) {
            case 0:
                return "Onay Bekliyor";
                break;
            case 1:
                return "Onaylandı";
                break;
            case 2:
                return "Kargoya Verildi";
                break;
            case 3:
                return "İptal Edildi";
                break;
            case 4:
                return "Teslim Edildi";
                break;
            case 5:
                return "Tedarik sürecinde";
                break;
            case 6:
                return "Ödeme Bekleniyor";
                break;
            case 7:
                return "Hazırlanıyor";
                break;
            case 8:
                return "İade Edildi";
                break;
            case 9:
                return "Ödeme Başarısız.";
                break;
        }
    }

    public function getStatusTextSmsAttribute()
    {
        switch ($this->attributes["status"]) {
            case 0:
                return "onay bekliyor";
                break;
            case 1:
                return "onaylandı";
                break;
            case 2:
                return "kargoya verildi";
                break;
            case 3:
                return "iptal edildi";
                break;
            case 4:
                return "teslim edildi";
                break;
            case 5:
                return "tedarik sürecinde";
                break;
            case 6:
                return "için ödeme bekleniyor";
                break;
            case 7:
                return "hazırlanıyor";
                break;
            case 8:
                return "iade edildi";
                break;
            case 9:
                return "için ödeme başarısız.";
                break;
        }
    }

    public function refundRequest()
    {
        return $this->hasOne('App\RefundRequest');
    }

    public function slot()
    {
        return $this->hasOne('App\OrderSlot', 'order_id', 'id');
    }

    public function scopeFilterByRequest($query, Request $request)
    {
        if ($request->has('id')) {
            $query->where('id', '=', $request->get('id'));
        }
        if ($request->has('status')) {
            $query->where('status', '=', $request->get('status'));
        }

        if ($request->has('payment_type')) {
            $query->where('payment_type', '=', $request->get('payment_type'));
        }

        if ($request->has('shipping')) {
            $query->where('shipping_id', '=', $request->get('shipping'));
        }

        if ($request->has('price1') && $request->has('price2')) {
            $query->whereBetween('grand_total', [$request->get('price1'), $request->get('price2')]);
        }

        // Tarih ve Saate göre, Sadece tarih göre, Sadece Saate göre sorgula
        if ($request->has('date1') && $request->has('date2') && $request->has('time1') && $request->has('time2')) {
            $query->where('created_at', '>=', sprintf('%s %s:00', date('Y-m-d', strtotime($request->get('date1'))), $request->get('time1')));
            $query->where('created_at', '<=', sprintf('%s %s:59', date('Y-m-d', strtotime($request->get('date2'))), $request->get('time2')));
        } else if ($request->has('date1') && $request->has('date2')) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->get('date1'))));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->get('date2'))));
        } else if ($request->has('time1') && $request->has('time2')) {
            $query->where('created_at', '>=', sprintf('%s:00', $request->get('time1')));
            $query->where('created_at', '<=', sprintf('%s:59', $request->get('time2')));
        }

        if ($request->has('orderNo')) {
            $query->where('order_no', 'like', '%' . $request->get("orderNo") . '%');
        }

        if ($request->has('city')) {

            $city = $request->get('city');
            $query->whereHas('billingAddress', function ($query) use ($city) {
                $query->where('city', $city);
            });

        }

        if ($request->has('billingName')) {

            $billingName = $request->get('billingName');

            $query->whereHas('billingAddress', function ($query) use ($billingName) {
                $query->where(\DB::raw("CONCAT(`name`, ' ', `surname`)"), 'LIKE', "%" . $billingName . "%")->orWhere(\DB::raw("CONCAT(`name`, ' ', `surname`)"), '=', $billingName);
            });

        }

        if ($request->has('shippingName')) {
            $shippingName = ltrim(mb_convert_case(str_replace(array(' I', ' ı', ' İ', ' i'), array(' I', ' I', ' İ', ' İ'), ' ' . $request->get('shippingName')), MB_CASE_TITLE, "UTF-8"));
            $query->whereHas('shippingAddress', function ($query) use ($shippingName) {
                $query->where(\DB::raw("CONCAT(`name`, ' ', `surname`)"), 'LIKE', "%" . $shippingName . "%")->orWhere(\DB::raw("CONCAT(`name`, ' ', `surname`)"), '=', $shippingName);
            });
        }

        if ($request->has('productKey')) {
            $productKey   = $request->get('productKey');
            $productValue = $request->get('productValue');

            switch ($productKey) {
                case 'sku':
                    $query->whereHas('items', function ($query) use ($productValue) {
                        $query->where('stock_code', $productValue);
                    });
                    break;
                case 'id':
                    $query->whereHas('items', function ($query) use ($productValue) {
                        $query->where('product_id', $productValue);
                    });
                    break;
                case 'name':
                    $searchValues = preg_split('/\s+/', $productValue, -1, PREG_SPLIT_NO_EMPTY);
                    $query->whereHas('items', function ($query) use ($searchValues) {
                        foreach ($searchValues as $value) {
                            $query->Where('name', 'like', "%{$value}%");
                        }
                    });

                    break;
                default:
                    # code...
                    break;
            }
        }

        if ($request->has('phone')) {

            $phone = $request->get('phone');
            $query->whereHas('billingAddress', function ($query) use ($phone) {
                $query->where('phoneGsm', $phone)
                    ->orWhere('phone', $phone);
            });

        }

        if ($request->has('mail')) {

            $mail = $request->get('mail');
            $query->whereHas('customer', function ($query) use ($mail) {
                $query->where('email', $mail);
            });

        }

        if ($request->get('status') != 9) {
            $query->where('status', '!=', 9);
        }
    }

}
