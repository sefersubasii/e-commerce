<html>

    <!-- Horizontal alignment -->
    <tr>
        <td style="background-color: #ccc;" colspan="9" align="center"><strong>Ürün Satış Raporu {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</strong></td>
    </tr>

    <tr></tr>

    <tr>
        <td style="border:1px solid #000;background-color: #999;"><strong>Stok Kodu</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Barkod</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ürün Adı</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Kategori</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Marka</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Satış Adedi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Toplam</strong></td>
    </tr>

    @foreach($data as $key => $pro)
        <tr>
            <td>{{@$pro->stock_code}}-s</td>
            <td>{{@$pro->barcode}}-b</td>
            <td>{{@$pro->name}}</td>
            <td>{{@$pro->categori->last()->title}}</td>
            <td>{{@$pro->brand->name}}</td>
            <td>{{@$pro->count}}</td>
            <td>{{ @$myPrice->discountedPrice($myPrice->withTax($pro->price,$pro->tax_status,$pro->tax),$pro->discount_type,$pro->discount) * @$pro->count}}</td>
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
