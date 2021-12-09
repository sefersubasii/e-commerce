<html>

    <!-- Horizontal alignment -->
    <tr>
        <td style="background-color: #ccc;" colspan="9" align="center"><strong>Sipariş Raporu {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</strong></td>
    </tr>

    <tr></tr>

    <tr>
        <td style="border:1px solid #000;background-color: #999;"><strong>ID</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş No</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Email</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş Tarihi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura İsim</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura Şehir</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura İlçe</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura Adresi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura Tel</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fatura CepTel</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Vergi Numarası</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Vergi Dairesi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat İsim</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat Şehir</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat İlçe</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat Adresi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat Tel</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Teslimat CepTel</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ödeme Türü</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Genel Toplam</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Kargo No</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Kargo Firması</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş Notu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş Durumu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>IP</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ürün Adı</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Stok Kodu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Miktar</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Toplam</strong></td>
    </tr>

    @foreach($data as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->order_no}}</td>
            <td>{{$order->customer->email}}</td>
            <td>{{$order->created_at}}</td>
            <td>{{@$order->billingAddress->name.' '.@$order->billingAddress->surname}}</td>
            <td>{{@$order->billingAddress->city}}</td>
            <td>{{@$order->billingAddress->state}}</td>
            <td>{{@$order->billingAddress->address}}</td>
            <td>{{@$order->billingAddress->phone}}</td>
            <td>{{@$order->billingAddress->phoneGsm}}</td>
            <td>{{@$order->billingAddress->tax_no}}</td>
            <td>{{@$order->billingAddress->tax_place}}</td>
            <td>{{@$order->shippingAddress->name.' '.@$order->shippingAddress->surname}}</td>
            <td>{{$order->shippingAddress->city}}</td>
            <td>{{$order->shippingAddress->state}}</td>
            <td>{{$order->shippingAddress->address}}</td>
            <td>{{$order->shippingAddress->phone}}</td>
            <td>{{$order->shippingAddress->phoneGsm}}</td>
            <td>{{$order->payment}}</td>
            <td>{{$order->grand_total}} TL</td>
            <td>{{$order->shipping_no}}</td>
            <td>{{@$order->shippingCompany->name}}</td>
            <td>{{@$order->customer_note}}</td>
            <td>{{@$order->statusText}}</td>
            <td>{{$order->ip}}</td>
            <td>{{@$order->items[0]->name}}</td>
            <td>{{@$order->items[0]->stock_code}}-s</td>
            <td>{{@$order->items[0]->qty}} Adet</td>
            <td>{{@$order->items[0]->qty*@$order->items[0]->price}} TL</td>
        </tr>
        @if(count($order->items)>1)
            @foreach($order->items as $key => $val)
                @if($key!=0)
                 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->stock_code}}-s</td>
                    <td>{{$val->qty}} Adet</td>
                    <td>{{$val->qty*$val->price}} TL</td>
                </tr>
                @endif
            @endforeach
        @endif
        <tr></tr>
    @endforeach

    <?php /*
    <!--  Vertical alignment -->
    <td valign="middle">Bold cell</td>

    <!-- Rowspan -->
    <td rowspan="3">Bold cell</td>

    <!-- Colspan -->
    <td colspan="6">Italic cell</td>

    <!-- Width -->
    <td width="100">Cell with width of 100</td>

    <!-- Height -->
    <td height="100">Cell with height of 100</td>
    */ ?>
</html>
