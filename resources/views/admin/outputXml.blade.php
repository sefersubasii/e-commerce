{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <{!! $data->rootElementName !!}>
    <title>Marketpaketi.com.tr</title>
    @foreach($pro->chunk(3000) as $items)
        @foreach ($items->toArray() as $item)
            <{!! $data->loopElementName !!}>
            @for($i=0; $i < count($selectedColumns);$i++)
                @if($selectedColumns[$i]=="brand")
                    <{{@$names[$selectedColumns[$i]]}}><![CDATA[{!!@$item[$selectedColumns[$i]]["name"]!!}]]></{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="categoryTree")
                    <{{@$names[$selectedColumns[$i]]}}>
                    <![CDATA[@foreach(@$item["categori"] as $key => $cat) {!! @$cat["title"] !!} {{ $key == count(@$item['categori'])-1 ? '' : '&gt;' }} @endforeach]]>
                    </{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="multipleOptions1")
                    <{{$names[$selectedColumns[$i]]}}>
                        @foreach($item["variant"] as $var)
                        {!! $var["name"] !!} ,
                        @endforeach
                    </{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="isOptionedProduct")
                    <{{@$names[$selectedColumns[$i]]}}>{!! count(@$item["variant"]) > 0 ? 1 : 0 !!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="categoryId")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][0]["id"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="category")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][0]["title"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="categoryId2")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][1]["id"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="category2")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][1]["title"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="categoryId3")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][2]["id"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="category3")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item["categori"][2]["title"]!!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="brandCode")
                    <{{@$names[$selectedColumns[$i]]}}>{{@$item["brand"]["code"]}}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="slug")
                    <{{$names[$selectedColumns[$i]]}}>{{ url($item["slug"].'-p-'.$item["id"]) }}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="discountedPriceTL")
                    <{{$names[$selectedColumns[$i]]}}>{{$price->moneyFormat($price->discountedPrice($price->withTax($item["price"], $item["tax_status"], $item["tax"]), $item["discount_type"], $item["discount"]))}} TRY</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="discountedPrice")
                    @php($discountedPriceTax = $price->withTax($item["price"], $item["tax_status"], $item["tax"]))
                    @php($discountedPrice = $price->discountedPrice($discountedPriceTax, $item["discount_type"], $item["discount"]))

                    @if(isset($data->additionalPrice['discountedPrice']) && $data->additionalPrice['discountedPrice'] > 0)
                        @php($discountedAdditionalPrice = additionalPriceCalc($discountedPrice, $data->additionalPrice['discountedPrice']))
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat($discountedAdditionalPrice) }}</{{$names[$selectedColumns[$i]]}}>
                    @else
                        <{{$names[$selectedColumns[$i]]}}>{{$price->moneyFormat($discountedPrice)}}</{{$names[$selectedColumns[$i]]}}>
                    @endif
                @elseif($selectedColumns[$i]=="rebatedPriceWithoutTax")
                    <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat($price->discountedPrice($price->withoutTax($item["price"], $item["tax_status"], $item["tax"]), $item["discount_type"], $item["discount"])) }}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="priceTaxWithCur")
                    <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat($price->withTax($item["price"],$item["tax_status"],$item["tax"])) }} TRY</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="price")
                    @if(isset($data->additionalPrice['price']) && $data->additionalPrice['price'] > 0)
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat(additionalPriceCalc($item[$selectedColumns[$i]], $data->additionalPrice['price'])) }}</{{$names[$selectedColumns[$i]]}}>
                    @else
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat($item[$selectedColumns[$i]]) }}</{{$names[$selectedColumns[$i]]}}>
                    @endif
                @elseif($selectedColumns[$i]=="priceWithTaxTL")
                    @if(isset($data->additionalPrice['priceWithTaxTL']) && $data->additionalPrice['priceWithTaxTL'] > 0)
                        @php($priceWithTax = $price->withTax($item["price"], $item["tax_status"], $item["tax"]))
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat(additionalPriceCalc($priceWithTax, $data->additionalPrice['priceWithTaxTL'])) }} TRY</{{$names[$selectedColumns[$i]]}}>
                    @else
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat(($price->withTax($item["price"], $item["tax_status"], $item["tax"]))) }} TRY</{{$names[$selectedColumns[$i]]}}>
                    @endif
                @elseif($selectedColumns[$i]=="priceWithTax")
                    @if(isset($data->additionalPrice['priceWithTax']) && $data->additionalPrice['priceWithTax'] > 0)
                        @php($priceWithTax = $price->withTax($item["price"], $item["tax_status"], $item["tax"]))
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat(additionalPriceCalc($priceWithTax, $data->additionalPrice['priceWithTax'])) }} TRY</{{$names[$selectedColumns[$i]]}}>
                    @else
                        <{{$names[$selectedColumns[$i]]}}>{{ $price->moneyFormat($price->withTax($item["price"], $item["tax_status"], $item["tax"])) }}</{{$names[$selectedColumns[$i]]}}>
                    @endif
                @elseif($selectedColumns[$i]=="stockType")
                    <{{$names[$selectedColumns[$i]]}}>{!! $item["stockTypeString"] !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="stockStatus")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->stockStatus($item["stock"],$item["variant"]) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="stockAmount")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->stockAmount($item["stock"],$item["variant"]) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->baseImg($item["images"],$item["id"]) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image1")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],2) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image2")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],3) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image3")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],4) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image4")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],5) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image5")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],6) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="image6")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->getImg($item["images"],7) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="seo")
                    <{{$names[$selectedColumns[$i]]}}><![CDATA[{!! json_decode(@$item["seo"])->seo_description !!}]]></{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="desi")
                    <{{$names[$selectedColumns[$i]]}}>{!! $item["shippings"]["desi"] !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="seoTitle")
                    <{{$names[$selectedColumns[$i]]}}>{!! json_decode($item["seo"])->seo_title !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="keywords")
                    <{{$names[$selectedColumns[$i]]}}>{!! json_decode($item["seo"])->seo_keywords !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="rebatePercent")
                    <{{$names[$selectedColumns[$i]]}}>{!! $product->rebatePercent($item["discount"],$item["discount_type"],$item["price"]) !!}</{{$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="name")
                    <{{@$names[$selectedColumns[$i]]}}><![CDATA[{!!@$item[$selectedColumns[$i]]!!}]]></{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="stock_code")
                    <{{@$names[$selectedColumns[$i]]}}><![CDATA[{!!@$item[$selectedColumns[$i]]!!}]]></{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="categoryMap")
                    <{{@$names[$selectedColumns[$i]]}}>{!!@isset($catMaps[end($item["categori"])["id"]]) ? $catMaps[end($item["categori"])["id"]] : "" !!}</{{@$names[$selectedColumns[$i]]}}>
                @elseif($selectedColumns[$i]=="condition")
                    <g:condition>new</g:condition>
                    <description><![CDATA[{!! @$item['content'] != '' ? @$item['content'] : @$item['name'] !!}]]></description>
                @else
                    <{{@$names[$selectedColumns[$i]]}}>{!!@$item[$selectedColumns[$i]]!!}</{{@$names[$selectedColumns[$i]]}}>
                @endif
            @endfor
            </{!! $data->loopElementName !!}>
        @endforeach
    @endforeach
    </{!! $data->rootElementName !!}>
</rss>