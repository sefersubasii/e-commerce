<html>
    <!-- Horizontal alignment -->
    <tr style="background-color: ##00c292; color:#fff; height:25px; verticle-align:middle;">
        <td colspan="10" align="center"><strong>Sipariş Raporu {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</strong></td>
    </tr>

    <tr>
        <td style="border:1px solid #000;background-color: #999;"><strong>ID</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Email</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş Tarihi</strong></td>
        <td style="border:1px solid #000;background-color: #999;" colspan="2"><strong>Fatura Bilgileri</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Genel Toplam</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ödeme Türü</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş Durumu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sipariş İli</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Sepet Detayları</strong></td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #999;border:1px solid #000;"><strong>Adı Soyadı</strong></td>
        <td style="background-color: #999;border:1px solid #000;"><strong>T.C Kimlik No</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #999;border:1px solid #000;"><strong>Ürün Adı</strong></td>

        <td style="background-color: #999;border:1px solid #000;"><strong>Stok Kodu</strong></td>
        <td style="background-color: #999;border:1px solid #000;"><strong>Miktar</strong></td>
        <td style="background-color: #999;border:1px solid #000;"><strong>Toplam</strong></td>
    </tr>

    @foreach($data as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->customer->email}}</td>
            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s')}}</td>
            <td>{{$order->customer->fullname}}</td>
            <td></td>
            <td>{{$order->grand_total}} TL</td>
            <td>{{$order->payment}}</td>
            <td>{{$order->statusText}}</td>
            <td>{{$order->shippingAddress->city}} / {{ @$order->shippingAddress->state }}</td>
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
