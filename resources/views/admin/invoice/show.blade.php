<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Fatura Önizleme</title>
        <style type="text/css">
        /* Firefox 46+ için */
            @page {
                margin: 0;
            }

            body {
                color:#232323;
                font-family: courier,"courier new",monospace;
                font-size:15px;
                margin:0;
                padding:0;
                letter-spacing:0.4pt;
            }
            h1, p{
                border:0;
                margin:0;
                padding:0;
            }
            .green_handler5 {
                display:none;
            }
            .listItem {
                height:33px;
            }
            .listItemPrice{
                height:33px;
                text-align: right;
            }
            .window{
                width:200px;
                height:150px;
                display:none;
            }
            .window h1{
                font-size:15px;
                height:16px;
                line-height:16px;
                padding-bottom:6px;
            }
            .window p{
                font-size:15px;
            }
            .msg{
                float:right;
                display: none;
                font-weight:normal;
                font-size:15px;
            }
            .form{
                width:21cm;
                height:28cm;
                display:block;
                z-index:1;
            }
            .form h1{
                font-size:15px;
                height:16px;
                line-height:16px;
                padding-bottom:6px;
            }
            .form p{
                font-size:15px;
                padding:8px;
            }
            .msg{
                float:right;
                font-weight:normal;
                font-size:15px;
            }
        </style>
        <script type="text/javascript" src="{{ asset('src/admin/js/invoiceCreatorJquery.js') }}"></script>
        <script language="javascript">
            function printDesign(){
                $("#print").css('display','none');
                $("h1").css('display','none');
                window.print();
            }
            jQuery(document).ready(function(){
                jQuery(".numberX,.numberY,.linex,.liney").remove();
                {!! $ek !!}
            });
        </script>
    </head>
    <body>
        <a href='javascript:void(0);' style='position: absolute;right: 0px; top: 0px; z-index:2;' id='print' onclick='printDesign()'>Faturayı Yazdır</a>
        <div style='position:relative;width:21cm'>
        <script>
            var item = new Object();
            item = new Array();
            item = {!! json_encode($order->items) !!}
        </script>
        <div style="left: 0px; top: 0px; position: absolute;display:none;" class="form" id="form_w">
            <span class="linex" style="left:1cm"></span>
            <span class="linex" style="left:2cm"></span>
            <span class="linex" style="left:3cm"></span>
            <span class="linex" style="left:4cm"></span>
            <span class="linex" style="left:5cm"></span>
            <span class="linex" style="left:6cm"></span>
            <span class="linex" style="left:7cm"></span>
            <span class="linex" style="left:8cm"></span>
            <span class="linex" style="left:9cm"></span>
            <span class="linex" style="left:10cm"></span>
            <span class="linex" style="left:11cm"></span>
            <span class="linex" style="left:12cm"></span>
            <span class="linex" style="left:13cm"></span>
            <span class="linex" style="left:14cm"></span>
            <span class="linex" style="left:15cm"></span>
            <span class="linex" style="left:16cm"></span>
            <span class="linex" style="left:17cm"></span>
            <span class="linex" style="left:18cm"></span>
            <span class="linex" style="left:19cm"></span>
            <span class="linex" style="left:20cm"></span>
            <span class="linex" style="left:21cm"></span>
            <span class="numberX" style="left:0.5cm"><span>1</span></span>
            <span class="numberX" style="left:1.5cm"><span>2</span></span>
            <span class="numberX" style="left:2.5cm"><span>3</span></span>
            <span class="numberX" style="left:3.5cm"><span>4</span></span>
            <span class="numberX" style="left:4.5cm"><span>5</span></span>
            <span class="numberX" style="left:5.5cm"><span>6</span></span>
            <span class="numberX" style="left:6.5cm"><span>7</span></span>
            <span class="numberX" style="left:7.5cm"><span>8</span></span>
            <span class="numberX" style="left:8.5cm"><span>9</span></span>
            <span class="numberX" style="left:9.5cm"><span>10</span></span>
            <span class="numberX" style="left:10.5cm"><span>11</span></span>
            <span class="numberX" style="left:11.5cm"><span>12</span></span>
            <span class="numberX" style="left:12.5cm"><span>13</span></span>
            <span class="numberX" style="left:13.5cm"><span>14</span></span>
            <span class="numberX" style="left:14.5cm"><span>15</span></span>
            <span class="numberX" style="left:15.5cm"><span>16</span></span>
            <span class="numberX" style="left:16.5cm"><span>17</span></span>
            <span class="numberX" style="left:17.5cm"><span>18</span></span>
            <span class="numberX" style="left:18.5cm"><span>19</span></span>
            <span class="numberX" style="left:19.5cm"><span>20</span></span>
            <span class="numberX" style="left:20.5cm"><span>21</span></span>
            <span class="liney" style="top:1cm"></span>
            <span class="liney" style="top:2cm"></span>
            <span class="liney" style="top:3cm"></span>
            <span class="liney" style="top:4cm"></span>
            <span class="liney" style="top:5cm"></span>
            <span class="liney" style="top:6cm"></span>
            <span class="liney" style="top:7cm"></span>
            <span class="liney" style="top:8cm"></span>
            <span class="liney" style="top:9cm"></span>
            <span class="liney" style="top:10cm"></span>
            <span class="liney" style="top:11cm"></span>
            <span class="liney" style="top:12cm"></span>
            <span class="liney" style="top:13cm"></span>
            <span class="liney" style="top:14cm"></span>
            <span class="liney" style="top:15cm"></span>
            <span class="liney" style="top:16cm"></span>
            <span class="liney" style="top:17cm"></span>
            <span class="liney" style="top:18cm"></span>
            <span class="liney" style="top:19cm"></span>
            <span class="liney" style="top:20cm"></span>
            <span class="liney" style="top:21cm"></span>
            <span class="liney" style="top:22cm"></span>
            <span class="liney" style="top:23cm"></span>
            <span class="liney" style="top:24cm"></span>
            <span class="liney" style="top:25cm"></span>
            <span class="liney" style="top:26cm"></span>
            <span class="liney" style="top:27cm"></span>
            <span class="liney" style="top:28cm"></span>
            <span class="numberY" style="top:-0.5cm"><span>0</span></span>
            <span class="numberY" style="top:0.5cm"><span>1</span></span>
            <span class="numberY" style="top:1.5cm"><span>2</span></span>
            <span class="numberY" style="top:2.5cm"><span>3</span></span>
            <span class="numberY" style="top:3.5cm"><span>4</span></span>
            <span class="numberY" style="top:4.5cm"><span>5</span></span>
            <span class="numberY" style="top:5.5cm"><span>6</span></span>
            <span class="numberY" style="top:6.5cm"><span>7</span></span>
            <span class="numberY" style="top:7.5cm"><span>8</span></span>
            <span class="numberY" style="top:8.5cm"><span>9</span></span>
            <span class="numberY" style="top:9.5cm"><span>10</span></span>
            <span class="numberY" style="top:10.5cm"><span>11</span></span>
            <span class="numberY" style="top:11.5cm"><span>12</span></span>
            <span class="numberY" style="top:12.5cm"><span>13</span></span>
            <span class="numberY" style="top:13.5cm"><span>14</span></span>
            <span class="numberY" style="top:14.5cm"><span>15</span></span>
            <span class="numberY" style="top:15.5cm"><span>16</span></span>
            <span class="numberY" style="top:16.5cm"><span>17</span></span>
            <span class="numberY" style="top:17.5cm"><span>18</span></span>
            <span class="numberY" style="top:18.5cm"><span>19</span></span>
            <span class="numberY" style="top:19.5cm"><span>20</span></span>
            <span class="numberY" style="top:20.5cm"><span>21</span></span>
            <span class="numberY" style="top:21.5cm"><span>22</span></span>
            <span class="numberY" style="top:22.5cm"><span>23</span></span>
            <span class="numberY" style="top:23.5cm"><span>24</span></span>
            <span class="numberY" style="top:24.5cm"><span>25</span></span>
            <span class="numberY" style="top:25.5cm"><span>26</span></span>
            <span class="numberY" style="top:26.5cm"><span>27</span></span>
            <span class="numberY" style="top:27.5cm"><span>28</span></span>
        </div>

        <div style="display: block; left: 41px; top: 10px; position: absolute; width: 560px;height: 111px;" class="window" id="buyerInformation_w">
            <h1>
                <small>Alıcı Bilgileri</small>
            </h1>
            <p>
                {{ $billingAddress->name.' '.$billingAddress->surname }} <br/>
                {{ $billingAddress->address}}<br/>
                {{$billingAddress->state.' / '.$billingAddress->city }} / Türkiye<br><br/>
                {{ $billingAddress->phone }} / {{ $billingAddress->phoneGsm }}
            </p>
            <div style="left: 638px; top: 324px; position: absolute;" class="resizeable" id="resize22"></div>
        </div>
        <div style="display: block; left: 600px; top: 93px; position: absolute; width: 231px; height: 64px;" class="window" id="date_w">
            <h1>
                <small>Tarih</small>
            </h1>
            <p>{{ $billDate }}</p>
            <div style="left: 723px; top: 172px; position: absolute;" class="resizeable" id="resize2"></div>
        </div>
        <div style="display: block; left: 265px; top: 137px; position: absolute;" class="window" id="tcOrTaxId_w">
            <h1>
                <small>TC No veya Vergi No Ekle</small>
            </h1>
            <p>{{ $billingAddress->tax_no }}</p>
            <div style="left: 407px; top: 220px; position: absolute;" class="resizeable" id="resize26"></div>
        </div>
        <div style="display: block; left: 40px; top: 134px; position: absolute;" class="window" id="taxPlace_w">
            <h1>
                <small>Vergi Dairesi</small>
            </h1>
            <p>{{ $billingAddress->tax_place }}</p>
            <div style="left: 200px; top: 219px; position: absolute;" class="resizeable" id="resize23"></div>
        </div>
        <div style="display: block; width: 385px; height: 474px; left: 41px; top: 233px; position: absolute;" class="window" id="productLabel_w">
            <h1>
                <small>Ürün Adı</small>
            </h1>
            <p>
            {!! $names !!}
            </p>
            <div style="left: 370px; top: 687px; position: absolute;" class="resizeable" id="resize7"></div>
        </div>
        <div id="stockType_w" class="window" style="left: 429px; top: 233px; position: absolute; display: block; width: 34px; height: 474px;">
            <h1>
                <small>Birim</small>
            </h1>
            <p>
            {!! $units !!}
            </p>
            <div id="resize27" class="resizeable" style="left: 410px; top: 719px; position: absolute;"></div>
        </div>
        <div style="display: block; width: 39px; height: 473px; left: 478px; top: 234px; position: absolute;" class="window" id="quantity_w">
            <h1>
                <small>Miktar</small>
            </h1>
            <p>
            {!! $qty !!}
            </p>
            <div style="left: 363px; top: 761px; position: absolute;" class="resizeable" id="resize9"></div>
        </div>
        <div style="display: block; width: 51px; height: 459px; left: 654px; top: 234px; position: absolute;" class="window" id="unitPrice_w">
            <h1>
                <small>Birim Fiyatı</small>
            </h1>
            <p>
            {!! $one_price !!}
            </p>
            <div style="left: 450px; top: 747px; position: absolute;" class="resizeable" id="resize8"></div>
        </div>
        <div style="display: block; width: 48px; height: 459px; left: 714px; top: 234px; position: absolute;" class="window" id="price_w">
            <h1>
                <small>Fiyat</small>
            </h1>
            <p>
            {!! $ttl_price !!}
            </p>
            <div style="left: 641px; top: 748px; position: absolute;" class="resizeable" id="resize11"></div>
        </div>
        <div style="display: block; width: 31px; height: 473px; left: 523px; top: 235px; position: absolute;" class="window" id="kdv_w">
            <h1>
                <small>KDV</small>
            </h1>
            <p>
            {!! $taxes !!}
            </p>
            <div style="left: 525px; top: 761px; position: absolute;" class="resizeable" id="resize10"></div>
        </div>
        @if($lastPage)
            <div id="generalBillingDesign_w" class="window" style="left: 486px; top: 768px; position: absolute; display: block; width: 290px; height: 138px;">
                <h1>
                    <small>Genel Fatura Tutar Bilgisi</small>
                </h1>
                <p>
                    <table>
                        <tr>
                            <td>Ara Toplam</td>
                            <td>:</td>
                            <td>{!! $price->currencyFormat($grandTotalPrice - $order->tax_amount) !!} TL</td>
                        </tr>
                        <tr>
                            <td>Matrah</td>
                            <td>:</td>
                            <td>
                                {!! ($tax8 > 0 ? ' % 8 '.$price->currencyFormat($tax8).' TL <br>' : '') !!}
                            	{!! ($tax18 > 0 ? ' % 18 '.$price->currencyFormat($tax18).' TL <br>' : '') !!}
                            	{!! ($tax1 > 0 ? ' % 1 '.$price->currencyFormat($tax1).' TL <br>' : '') !!}
                            </td>
                        </tr>
                        {!! ($tax8amount  > 0 ? '<tr> <td>KDV %8</td>  <td> : </td> <td>'.$price->currencyFormat($tax8amount).' TL </td><tr>' : '') !!}
                        {!! ($tax18amount > 0 ? '<tr> <td>KDV %18</td> <td> : </td> <td>'.$price->currencyFormat($tax18amount).' TL </td><tr>' : '') !!}
                        {!! ($tax1amount  > 0 ? '<tr> <td>KDV %1</td>  <td> : </td> <td>'.$price->currencyFormat($tax1amount).' TL </td><tr>' : '') !!}
                        <tr>
                            <td>Genel Toplam</td>
                            <td>:</td>
                            <td>{!! $price->currencyFormat($grandTotalPrice - $order->discount_amount)  !!} TL</td>
                        </tr>
                    </table>
                </p>
                <div id="resize17" class="resizeable" style="left: 810px; top: 758px; position: absolute;"></div>
            </div>
            <div id="paymentType_w" class="window" style="left: 36px; top: 764px; position: absolute; display: block;">
                <h1>
                    <small>Ödeme Tipi</small>
                </h1>
                <p>{!! $order->payment !!}</p>
                <div id="resize28" class="resizeable" style="left: 209px; top: 832px; position: absolute;"></div>
            </div>
            <div style="display: block; width: 440px; height: 65px; left: 36px; top: 838px; position: absolute;" class="window" id="priceString_w">
                <h1>
                    <small>Yazı ile Fiyat</small>
                </h1>
                <p>{!! $price->convertToString($grandTotalPrice,2,'TL','Kr','#',null,null,null) !!}</p>
                <div style="left: 605px; top: 545px; position: absolute;" class="resizeable" id="resize16"></div>
            </div>
        @endif
        </div>
    </body>
</html>
