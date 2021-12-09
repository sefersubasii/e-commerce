<html>

    <!-- Horizontal alignment -->
    <tr>
        <td style="background-color: #ccc;" colspan="9" align="center"><strong>Ürün Raporu {{ now()->format('d/m/Y H:i:s') }}</strong></td>
    </tr>

    <tr></tr>

    <tr>
        <td style="border:1px solid #000;background-color: #999;"><strong>Stok Kodu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Barkod</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ürün Adı</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Kategori</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Marka</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Stok Adedi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Durumu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Fiyat</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>KDV</strong></td>
        <td style="border:1px solid #000;background-color: #999;">İndirim Türü</td>
        <td style="border:1px solid #000;background-color: #999;">İndirim</td>
        <td style="border:1px solid #000;background-color: #999;">Maliyet</td>
        <td style="border:1px solid #000;background-color: #999;">Karlılık</td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Oluşturulma Tarihi</strong></td>
    </tr>

    @foreach($data as $key => $pro)
        <tr>
            <td>{{@$pro->stock_code}}-s</td>
            <td>{{@$pro->barcode}}-b</td>
            <td>{{@$pro->name}}</td>
            <td>{{@$pro->categori[0]->title}}</td>
            <td>{{@$pro->brand->name}}</td>
            <td>{{@$pro->stock}}</td>
            <td>{{@$pro->status}}</td>
            <td>{{@$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($pro->price,$pro->tax_status,$pro->tax),$pro->discount_type,$pro->discount))}} TL</td>
            <td>{{@$pro->tax}}</td>
            <td>{{ @$pro->discount_type == 0 ? 'İndirim Yok' : ( @$pro->discount_type == 1 ? 'Yüzdeli İndirim' : 'İndirimli Fiyat' ) }}</td>
            <td>{{@$pro->discount}}</td>
            <td style="text-align:center">{{ @$pro->costprice ? @$pro->costprice.' TL' : ' '}} </td>
            {{-- Karlılık Yüzdesini Hesapla --}}
            @php
                $costPercent = 0.00;
                if($pro->costprice && $pro->costprice > 0){
                    $costPercent = ($pro->final_price - $pro->costprice) / $pro->final_price * 100;
                }
            @endphp
            <td style="text-align:center">{{ (round($costPercent, 3)) }}%</td>
            <td>{{ $pro->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
    @endforeach
</html>