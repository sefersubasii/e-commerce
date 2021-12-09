@extends('frontEnd.layout.master')

@section('content')
<div class="container">
	<div class="container_ic">
		<div class="navigasyon">
			<div class="navigasyon_ic">
				<a href="{{url('/')}}">Sanal Market</a>
				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<span>Siparişi Tekrarla</span>
			</div>
		</div>
		
		<div class="bilgi_left">
			<div class="bilgi_left_blok">
				<div class="blb_baslik">HESABIM</div>
				<ul class="blb_icerik">
					<li><a href="{{url('hesabim')}}">Hesabım</a></li>
					<li><a href="{{url('hesabim/siparisler')}}">Siparişlerim</a></li>
					<li><a href="{{url('hesabim/sifre-degistir')}}">Şifremi Değiştir</a></li>
				</ul>
			</div>
			<div class="bilgi_left_blok">
				<div class="blb_baslik">DİĞER BİLGİ SAYFALARI</div>
				<ul class="blb_icerik">
					<li><a href="{{url('mesafeli-satis-sozlesmesi')}}">Mesafeli Satış Sözleşmesi</a></li>
					<li><a href="{{url('odeme-ve-teslimat')}}">Ödeme ve Teslimat</a></li>
					<li><a href="{{url('gizlilik-ve-guvenlik')}}">Gizlilik ve Güvenlik</a></li>
					<li><a href="{{url('iade-sartlari')}}">İade Şartları</a></li>
				</ul>
			</div>
        </div>
        
		<div class="bilgi_icerik">
			<div class="bilgi_icerik_baslik">SİPARİŞİ TEKRARLA</div>
			<div class="bilgi_icerik_ic">
				<div class="siparis_tab_alan">
					{{-- <div class="siparis_tab">
						<span class="siparis_link"><a >ÜRÜN SEÇ</a></span>
                    </div> --}}
                    <p style="text-align:center;">
                        Sepete eklemek istediğiniz ürünleri seçin ve miktarlarını belirleyin.
                    </p>
                    <hr style="margin-top: 10px; margin-bottom:10px; border:none; border-top:1px solid #ddd">
                    <div class="clear"></div>

                    <style>
                        #repeat-order {
                            width:100%; 
                            border:1px solid #ddd;
                            border-collapse: collapse;
                        }
                        #repeat-order tr,
                        #repeat-order td{
                            border:1px solid #ddd;
                            padding:5px;
                        }

                        #repeat-order th {
                            padding: 10px 0;
                            border: 1px solid #fff;
                        }

                        #repeat-order .add_cart{
                            width: 100%;
                            padding: 7px 0;
                            background: #009f25;
                            display: block;
                            color: #fff;
                            font-size: 16px;
                            text-align: center;
                            -webkit-transition: all .35s ease;
                            transition: all .35s ease;
                            overflow: hidden;
                            cursor: pointer;
                        }

                        #repeat-order .add_cart:hover{
                            background: #02c02e;
                        }

                        #repeat-order .add_cart:active{
                            background: #1fb842;
                        }

                        #repeat-order .add_qty {
                            width: calc(100% - 13px);
                            text-align: center;
                            border: 1px solid #ddd;
                            padding: 3px 5px;
                            font-size:16px;
                        }
                        #repeat-order .add_qty:focus{
                            outline: none;
                        }                     

                    </style>
                    
                    <table id="repeat-order">
                        <thead>
                            <tr style="background: #ddd;">
                                <th width="5%">SEÇ</th>
                                <th>Ürün</th>
                                <th width="10%">Miktar</th>
                                <th width="10%">İşlem</th>
                            </tr>
                            @foreach($order->items as $item)
                                <tr>
                                    <td width="5%" style="text-align:center;">
                                        <input type="checkbox" checked>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td width="10%">
                                        <input class="add_qty" type="text" value="{{ $item->qty }}">
                                    </td>
                                    <td width="10%">
                                        <span class="add_cart">Ekle</span>
                                    </td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<div class="clear"></div>
	<div class="container_ic">
		@include('frontEnd.include.footerTop')
		<div class="clear"></div>
	</div>
</div>
@endsection