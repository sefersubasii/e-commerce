<html>

    <!-- Horizontal alignment -->
    <tr>
        <td style="background-color: #ccc;" colspan="9" align="center"><strong>Ürün Raporu {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</strong></td>
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
        <td style="border:1px solid #000;background-color: #999;"><strong>Oluşturulma Tarihi</strong></td>
    </tr>

    @foreach($data as $key => $pro)
    @php
    if($pro->status = 0){$status = 'Onay Bekliyor';}
    else if($pro->status = 1){$status = 'Onaylandı';}
    else if($pro->status = 2){$status = 'Kargoya Verildi';}
    else if($pro->status = 3){$status = 'İptal Edildi';}
    else if($pro->status = 4){$status = 'Teslim Edildi';}
    else if($pro->status = 5){$status = 'Tedarik sürecinde';}
    else if($pro->status = 6){$status = 'Ödeme Bekleniyor';}
    else if($pro->status = 7){$status = 'Hazırlanıyor';}
    else if($pro->status = 8){$status = 'İade Edildi';}
    @endphp

        <tr>
            <td>{{@$pro->stock_code}}-s</td>
            <td>{{@$pro->barcode}}-b</td>
            <td>{{@$pro->name}}</td>
            <td>{{@$pro->categori[0]->title}}</td>
            <td>{{@$pro->brand->name}}</td>
            <td>{{@$pro->stock}}</td>
            <td>{{@$status}}</td>
            <td>{{@$myPrice->currencyFormat($myPrice->discountedPrice($myPrice->withTax($pro->price,$pro->tax_status,$pro->tax),$pro->discount_type,$pro->discount))}} TL</td>
            <td>{{@$pro->tax}}</td>
            <td>{{@$pro->created_at}}</td>
        </tr>
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
