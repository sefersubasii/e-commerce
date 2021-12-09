
<table width="600" border="0" cellspacing="5" style="color: #666; font-size: 14px; font-family: arial; border: solid 2px #ed1d24;text-align: center; font-weight: 100; ">
  <tbody>
    <tr>
      <th><img src="https://marketpaketi.com.tr/images/market-paketi-gorsel.jpg" width="700" height="150" alt=""/></th></tr>
    <tr>
     <tr><th>Sipariş Dekontu <strong style="color: #ed1d24; font-size: 18px">Marketpaketi.com.tr</strong></th></tr>
     
      <th scope="col">
       <table width="700" height="50" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100">
         <tbody>
          <tr width="80%">
            <td width="76%"></td>
            <td width="24%" style="text-align: left;"><strong style="width: 40px; display: inline-block;">Tarih</strong> : {{$date}} <br>
              <strong style="width: 40px; display: inline-block;">Saat</strong> : {{$time}}</td>
          </tr>
        </tbody>
    </table>
        <table width="700" height="50" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr width="60%">
              <td width="60%"><strong style=" width: 98%; height: 40px; line-height: 40px; background: #ed1d24; display: block;color: #fff; text-align: left; padding-left: 2%">Merhaba {{$name}} {{$surname}};</strong>
                <br>
                {!!$mailText!!}
                <br>
                <?php /*
                Siparişiniz sisteme aşağıdaki bilgiler ile kaydedilmiştir. @if($created["payment_type"]==1) Ödemeniz gereken tutar<strong> {{$myPrice->currencyFormat($created["grand_total"])}} TL </strong>'dir. @endif<br>
                */ ?>
                <br>
                <strong style="width: 220px; display: inline-block">Ödeme Türü</strong>: {{$created["payment"]}} <br>
                @if($created["payment_type"]==1)
                <strong style="width: 220px; display: inline-block">Havale No </strong>: {{$created["order_no"]}}<br>
                <strong style="width: 220px; display: inline-block">Ödeme Yapılan Banka Hesabı </strong>: {{$bank->name}} - {{$bank->owner}} - {{$bank->iban}} - {{$bank->currency}}<br>
                @endif
                <strong style="width: 220px; display: inline-block">Sipariş No </strong>:{{$created["order_no"]}}</td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <tr>
              <td><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">Teslimat Bilgileri</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Adı Soyadı<strong> </strong></strong></td>
                    <td width="5" valign="top">: </td>
                    <td valign="top">{{$shippingAddress->name}} {{$shippingAddress->surname}}</td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Adres</strong> </td>
                    <td width="5" valign="top">: </td>
                    <td valign="top">{{$shippingAddress->address}}<br>
                      {{$shippingAddress->state}} / {{$shippingAddress->city}}<br>
                      <a href="tel:{{str_replace(' ','',$shippingAddress->phone)}}" value="{{str_replace(' ','',$shippingAddress->phone)}}" target="_blank">+90 {{$shippingAddress->phone}}</a> / <a href="tel:{{str_replace(' ','',$shippingAddress->phoneGsm)}}" value="{{str_replace(' ','',$shippingAddress->phoneGsm)}}" target="_blank">{{$shippingAddress->phoneGsm}}</a></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <tr>
              <td><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">Fatura Bilgileri</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">{{$billingAddress->type== 2 ? 'Ticari Ünvanı' : 'Adı Soyadı' }}</strong> </td>
                    <td width="5" valign="top">: </td>
                    <td valign="top">{{$billingAddress->name}} {{$billingAddress->surname}}</td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Adres</strong> </td>
                    <td width="5" valign="top">: </td>
                    <td valign="top">{{$billingAddress->address}}<br>
                      {{$billingAddress->state}} / {{$billingAddress->city}}<br>
                      <a href="tel:{{str_replace(' ','',$billingAddress->phone)}}" value="{{str_replace(' ','',$billingAddress->phone)}}" target="_blank">{{$billingAddress->phone}}</a> / <a href="tel:{{str_replace(' ','',$billingAddress->phoneGsm)}}" value="{{str_replace(' ','',$billingAddress->phoneGsm)}}" target="_blank">{{$billingAddress->phoneGsm}}</a></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            @if($billingAddress->type==2)
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Vergi Dairesi</strong> </td>
                    <td width="5" valign="top">: {{$billingAddress->tax_place}}</td>
                    <td valign="top"></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Vergi No</strong> </td>
                    <td width="5" valign="top">: {{$billingAddress->tax_no}}</td>
                    <td valign="top"></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            @endif
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <tr>
              <td><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">Kargo Bilgileri</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td><table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Kargo Firması</strong> </td>
                    <td width="5" valign="top">: </td>
                    <td valign="top">{{$shippingCompany}} {{$slot}}</td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr style="background: #999; color: #fff; font-size: 12px">
              <td width="31%"><strong>Ürün</strong></td>
              <td width="19%"><strong>Stok Kodu</strong></td>
              <td width="13%"><strong>Birim Fiyatı</strong></td>
              <td width="7%"><strong>Miktar</strong></td>
              <td width="15%"><strong>Ara Toplam</strong></td>
              <td width="15%"><strong>Havale ile</strong></td>
            </tr>
          </tbody>
        </table>
        {!!$mailItems!!}
        <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="50%"> </td>
              <td width="20%"><strong>KDV:</strong></td>
              <td width="15%">  {{$taxAmount}} TL</td>
              <td width="15%">  {{$taxAmount}} TL</td>
            </tr>
          </tbody>
        </table>
        {!!$discountInfo!!}
        <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="50%"> </td>
              <td width="20%"><strong>Kargo Ücreti:</strong></td>
              <td width="15%">  {{$shippingAmount}} TL</td>
              <td width="15%">  {{$shippingAmount}} TL</td>
            </tr>
          </tbody>
        </table>
        @if($created["payment_type"]==2 || $created["payment_type"]==4)
        <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="50%"> </td>
              <td width="20%"><strong>{{$created["payment"]}} Ücreti:</strong></td>
              <td width="15%">  {{$pdAmount}} TL</td>
              <td width="15%">  {{$pdAmount}} TL</td>
            </tr>
          </tbody>
        </table>
        @endif
        <table width="700" height="25" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="50%"> </td>
              <td width="20%"><strong>Genel Toplam:</strong></td>
              <td width="15%">  {{$grandTotal}} TL</td>
              <td width="15%">  {{$grandTotal}} TL</td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">Sipariş Notu Detayları</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="180" valign="top"><strong style="width: 220px; display: inline-block">Sipariş Notu</strong></td>
              <td width="10" valign="top">:</td>
              <td width="510" valign="top">{{empty($created["customer_note"]) ? 'Hayır' : 'Evet' }}</td>
            </tr>
            @if(!empty($created["customer_note"]))
            <tr>
              <td valign="top"><strong style="width: 220px; display: inline-block">Sipariş Notu</strong></td>
              <td valign="top">:</td>
              <td valign="top">{{$created["customer_note"]}}</td>
            </tr>
            @endif
          </tbody>
        </table>
        <?php /*
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr style="background: #999; color: #fff; font-size: 12px">
              <td width="17%"><strong>Banka</strong></td>
              <td width="15%"><strong>Hesap Türü</strong></td>
              <td width="22%"><strong>Hesap Adı</strong></td>
              <td width="16%"><strong>Şube Adı</strong></td>
              <td width="15%"><strong>Şube Kodu</strong></td>
              <td width="15%"><strong>Hesap No</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr style="background: #f1f1f1; font-size: 12px">
              <td width="17%">T. İş Bankası</td>
              <td width="15%">TL</td>
              <td width="22%">Öz Koru Sanal Mağazacılık Gıda İnş. Paz. San. Dış Tic Ltd. Şti</td>
              <td width="16%">Nato Yolu</td>
              <td width="15%">4381</td>
              <td width="15%">0136158</td>
            </tr>
          </tbody>
        </table>
        */ ?>
        @foreach($settings["banks"] as $b)
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0"  style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr style="background: #999; color: #fff; font-size: 12px">
              <td width="25%"><strong>Banka</strong></td>
              <td width="13%"><strong>Hesap Türü</strong></td>
              <td width="27%"><strong>Hesap Sahibi</strong></td>
              <td width="35%"><strong>IBAN Numarası</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr style="background: #f1f1f1; font-size: 12px">
              <td width="25%">{{$b->name}}</td>
              <td width="13%">{{$b->currency}}</td>
              <td width="27%">{{$b->owner}}</td>
              <td width="35%">{{$b->iban}}</td>
            </tr>
          </tbody>
        </table>
        @endforeach
  
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="15%"><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">İade ve İptal Prosedürü</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="15%"><div>
                <p>İade ve cayma hakkı</p>
                <p> </p>
                <p>Web sitemiz üzerinden yapılan satışlar Tüketicinin Korunması Hakkında Kanun ile Mesafeli Sözleşmeler Yönetmeliğine tabi satışlardır ve bu kanun-yönetmelikteki hükümleri uygulamaktadır.İade edeceğiniz ürünlerin aşağıdaki şartlara uygun olması işlemlerin hızlı bir şekilde tamamlanmasını sağlayacaktır:</p>
                <p>İade edeceğiniz ürüne ilişkin web sayfamızda yeralan iletişim bilgileri doğrultusunda bizimle irtibata seçmeniz ve bildirimde bulunmanız gerekmektedir. İade bildiriminde bulunulmadan gönderilecek ürünler müşteriye geri gönderilecektir. Ürünlerin kutusu üzerindeki, ithalatçı veya üretici firma tarafından yapıştırılmış olan etiketlerin yırtılması, vakumlu veya jelatinli ambalajın açılması durumlarında, iade talepleri kabul edilmemektedir.</p>
                <p>İadenin, satın alınan ürünün ambalajı açılmadan, tahrip edilmeden, bozulmadan ve ürün kullanılmadan teslim tarihinden itibaren yedi (7) günlük süre içinde gerçekleştirilmesi gereklidir.</p>
                <p>Ürünler orijinal ambalajlarından çıkarılarak kullanıldıktan sonra iade edilme istekleri için 1 haftalık geri alım süresi işlememekte ve ürün kesinlikle geri kabul edilmemektedir.</p>
                <p> </p>
                <p>……………………………</p>
                <p> </p>
                <p>Tüketicinin Korunması Hakkında Kanun 'un 4.Maddesine göre, "Tanıtım ve kullanma kılavuzunda ya da reklam ve ilânlarında yer alan niteliklerine aykırı olan ya da kullanım amacı bakımından tüketicinin ondan beklediği faydaları azaltan maddi, hukuki veya ekonomik eksiklikler içeren mallar, ayıplı mal olarak kabul edilir. Müşteri, malın teslim tarihinden itibaren 30 gün içerisinde ayıplı mal bildiriminde bulunursa, ürünü iade etme, bedel indirimi, ücretsiz değişim ya da ücretsiz onarım haklarından birine sahiptir.&rdquo; .</p>
                <p>Ayıplı Mal bildiriminde bulunarak yukarıda belirtilen haklardan faydalanmak için; Ürünün özellikleri, tanıtımında belirtilen özelliklerden farklıysa ya da, müşterinin üründen beklediği faydayı azaltan eksiklikler varsa, ürün, ayıplı mal sınıfına girer.</p>
                <p>Müşteri, 30 gün içerisinde ayıplı mal bildiriminde bulunmalıdır.</p>
                <p>Ayıplı Mal bildiriminde, ürünün ithalatçısı düzenlenen bir raporla kullanım hatasının bulunup bulunmadığı belirlenir. Kullanıcı hatasının olduğu tespit edilirse, müşteri, haklardan faydalanamaz.</p>
                <p>Cayma hakkı Mesafeli Sözleşmeler Yönetmeliği 'nin 8. Maddesine göre, müşteri, "Ürünü teslim aldığı tarihten itibaren yedi gün içerisinde hiçbir sorumluluk üstlenmeksizin ve hiçbir gerekçe göstermeksizin malı reddederek sözleşmeden cayma hakkına sahiptir.&rdquo; . Buna göre, müşteri, ürünü aldıktan sonra, 7 gün içerisinde sebepsiz iade etme hakkına sahiptir.</p>
              </div></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="15%"><strong style=" width: 98%; height: 40px; line-height: 40px; background: #262262; display: block;color: #fff; text-align: left; padding-left: 2%; margin: 10px 0px">Satış Koşulları</strong></td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: left; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td width="15%"><p><br>
                MADDE 1 - KONU<br>
                <br>
                İşbu sözleşmenin konusu, SATICI'nın, ALICI'ya satışını yaptığı, internet sitesinde online satışa sunulmuş olan ürünlerin satışı ve teslimi ile ilgili olarak 4077 sayılı Tüketicilerin Korunması Hakkındaki Kanun hükümleri gereğince tarafların hak ve yükümlülüklerini kapsamaktadır.<br>
                <br>
                MADDE 2.1- SATICI BİLGİLERİ<br>
                <br>
                Unvan:Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi<br>
                Adres: Plevne Cad. No:272 Mamak/ANKARA<br>
                <br>
                MADDE 2.2 - ALICI BİLGİLERİ<br>
                <br>
                Müşteri <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a> alışveriş sitesine üye olan veya üye olmadan alışveriş seçeneğini kullanarak alışveriş yapan kişidir. Müşterinin üye olurken kullanılan adres ve iletişim bilgileri esas alınır.<br>
                <br>
                MADDE 3 - SÖZLEŞME KONUSU ÜRÜN BİLGİLERİ<br>
                <br>
                Malın / Ürünün / Hizmetin türü, miktarı, marka/modeli, rengi, adedi, satış bedeli, ödeme şekli, siparişin sonlandığı andaki bilgilerden oluşmaktadır.<br>
                <br>
                MADDE 4 - GENEL HÜKÜMLER<br>
                <br>
                4.1- ALICI, Madde 3'te belirtilen sözleşme konusu ürün veya ürünlerin temel nitelikleri, satış<br>
                fiyatı ve ödeme şekli ile teslimata ilişkin tüm ön bilgileri okuyup bilgi sahibi olduğunu ve elektronik ortamda gerekli teyidi verdiğini beyan eder.<br>
                <br>
                4.2- Sözleşme konusu ürün veya ürünler, sipariş sonunda belirlemiş olduğunuz teslimat tipine göre hazırlanmak üzere işleme alınacaktır. Ankara merkezli şirketimizden ürünleri direk kendiniz teslim alabilir veya kargo firmalarıyla gönderim yapılmasını talep edebilirsiniz.Siparişleriniz onaylandıktan sonra en geç 3 (üç) iş günü sonunda Kargo firmasına teslim edilir.<br>
                <br>
                4.3- Siparişe dayalı ürün veya ürünler, 7 günlük süreyi aşmamak koşulu ile her bir ürün için ALICI'nın yerleşim yerinin uzaklığına bağlı olarak ön bilgiler içinde açıklanan süre içinde ALICI veya gösterdiği adresteki kişi/kuruluşa teslim edilir. Bu süre ALICI&rsquo;ya daha önce bildirilmek kaydıyla en fazla 3 gün daha uzatılabilir.<br>
                <br>
              </p>
                <p>4.4- Sözleşme konusu ürün, ALICI'dan baska bir kişi/kuruluşa teslim edilecek ise, teslim edilecek kişi/kuruluşun teslimatı kabul etmemesinden Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi sorumlu tutulamaz.</p>
                <p> </p>
                <p>4.5- Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi, sözleşme konusu ürünün sağlam, eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri ve kullanım kılavuzları ile teslim edilmesinden sorumludur.</p>
                <p><br>
                  4.6- Sipariş konusu ürünün teslimatı için bedelinin ALICI'nın tercih ettiği ödeme şekli ile ödenmiş olması şarttır. Herhangi bir nedenle ürün bedeli ödenmez veya banka kayıtlarında<br>
                  iptal edilir ise, Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi ürünün teslimi yükümlülüğünden kurtulmuş kabul edilir.<br>
                  <br>
                  4.7- Ürünün tesliminden sonra ALICI'ya ait kredi kartının ALICI'nın kusurundan<br>
                  kaynaklanmayan bir şekilde yetkisiz kişilerce haksız veya hukuka aykırı olarak kullanılması<br>
                  nedeni ile ilgili banka veya finans kuruluşunun ürün bedelini Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya ödememesi halinde, ALICI'nın kendisine teslim edilmiş olması kaydıyla ürünün 3 gün içinde Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya gönderilmesi zorunludur. Bu takdirde nakliye giderleri ALICI'ya aittir.<br>
                  <br>
                  4.8- Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi mücbir sebepler veya nakliyeyi engelleyen hava muhalefeti, ulaşımın<br>
                  kesilmesi gibi olağanüstü durumlar nedeni ile sözleşme konusu ürünü süresi içinde teslim edemez ise, durumu ALICI'ya bildirmekle yükümlüdür. Bu takdirde ALICI siparişin iptal edilmesini, sözleşme konusu ürünün varsa emsali ile değiştirilmesini, ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasına kadar ertelenmesi haklarından birini kullanabilir. ALICI'nın siparişi iptal etmesi halinde ödediği tutar 10 gün içinde kendisine nakden ve defaten ödenir.<br>
                  <br>
                  4.9- Garanti belgesi ile satılan ürünlerden olan veya olmayan ürünlerin arızalı veya bozuk olanlar, garanti şartları içinde gerekli onarımın yapılması için Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya gönderilebilir, bu takdirde kargo giderleri ALICI tarafından karşılanacaktır.<br>
                  <br>
                  4.10- Sistem hatalarından meydana gelen fiyat yanlışlıklarından Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi sorumlu değildir. Buna istinaden satıcı, internet sitesindeki sistemden, dizayndan veya yasadışı yollarla internet sitesine yapılabilecek müdahaleler sebebiyle ortaya çıkabilecek tanıtım, fiyat hatalarından sorumlu değildir. Sistem hatalarına dayalı olarak alıcı satıcıdan hak iddiasında bulunamaz.<br>
                  <br>
                  4.11- 18 (on sekiz) yaşından küçük kişiler <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a> &lsquo;dan alışveriş yapamaz. Satıcı, alıcının sözleşmede belirttiği yaşının doğru olduğunu esas alacaktır. Ancak alıcının yanlış yazmasından dolayı satıcıya hiçbir şekilde sorumluluk yüklenemeyecektir.<br>
                  <br>
                  4.12- <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a>&lsquo;dan kredi karti (Visa, MasterCard, vs. ) ya da banka havalesi ile alışveriş yapılabilir. Sipariş tarihinden itibaren bir hafta içinde havalesi yapılmayan siparişler iptal edilir. Siparişlerin işleme alınma zamanı, siparişin verildiği an değil, kredi kartı hesabından gerekli tahsilatın yapıldığı ya da havalenin (EFT&rsquo;nin) banka hesaplarına ulaştığı belirlenen andır. Ödemeli gönderi ya da posta çeki gibi müşteri hizmetleri ile görüşülmeden gerçekleştirilen ödeme yöntemleri kabul edilmez.<br>
                  <br>
                  4.13- Alıcı, aldığı ürünü iade etmek istemesi durumunda ne surette olursa olsun ürüne ve ambalajına zarar vermemeyi, iade anında fatura aslını ve irsaliyesini iade etmeyi kabul ve taahhüt eder.<br>
                  <br>
                  4.14- Zarar görmüş paket durumunda; zarar görmüş paketler teslim alınmayarak Kargo Şirketi yetkilisine tutanak tutturulmalıdır. Eğer Kargo Şirketi yetkilisi paketin hasarlı olmadığı görüşünde ise, paketin orada açılarak ürünlerin hasarsız teslim edildiğini kontrol ettirme ve durumun yine bir tutanakla tespit edilmesini isteme hakki alıcıda vardır. Paket, alıcı tarafından teslim alındıktan sonra Kargo Şirketinin görevini tam olarak yaptığı kabul edilmiş olur. Paket kabul edilmemiş ve tutanak tutulmuş ise, durum, tutanağın alıcıda kalan kopyasıyla birlikte en kısa zamanda satıcının Müşteri Hizmetlerine bildirilmelidir.<br>
                  <br>
                  4.15- Alıcı, 14 gün içerisinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Alıcı cayma hakkini kullandığına dair bildirimi bu süre içinde yazılı olarak satıcıya bildirmek zorundadır. Cayma hakki süresi alıcıya malın teslim edildiği günden itibaren başlar. İade edilen ürün veya ürünlerin geri gönderim bedeli alıcı tarafından karşılanmalıdır.<br>
                  <br>
                  4.16- Alıcı tarafından işbu sözleşmede belirtilen bilgiler ile ödeme yapmak amacı ile satıcıya bildirdiği bilgiler satıcı tarafından 3. şahıslarla paylaşılmayacaktır. Satıcı bu bilgileri sadece idari / yasal zorunluluğun mevcudiyeti çerçevesinde açıklayabilecektir. Araştırma ehliyeti belgelenmiş her türlü adli soruşturma dahilinde satıcı kendisinden istenen bilgiyi elinde bulunduruyorsa ilgili makama sağlayabilir. Kredi Kartı bilgileri kesinlikle saklanmaz, Kredi Kartı bilgileri sadece tahsilat işlemi sırasında ilgili bankalara güvenli bir şekilde iletilerek provizyon alınması için kullanılır ve provizyon sonrası sistemden silinir. Alıcıya ait e-posta adresi, posta adresi ve telefon gibi bilgiler yalnızca satıcı tarafından standart ürün teslim ve bigilendirme prosedürleri için kullanılır. Bazı dönemlerde kampanya bilgileri, yeni ürünler hakkında bilgiler, promosyon bilgileri alıcıya onayı sonrasında gönderilebilir.<br>
                  <br>
                  MADDE 5 - CAYMA HAKKI<br>
                  <br>
                  Alıcı, 14 gün içerisinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Alıcı cayma hakkını kullandığına dair bildirimi bu süre içinde yazılı olarak satıcıya bildirmek zorundadır. Cayma hakkı süresi alıcıya malın teslim edildiği günden itibaren başlar. İade edilen ürün veya ürünlerin geri gönderim bedeli alıcı tarafından karşılanmalıdır. Alıcının istekleri ve/veya açıkça onun kişisel ihtiyaçları doğrultusunda hazırlanan mallar için cayma hakkı söz konusu değildir.Alıcının cayma hakkını kullanması hâlinde satıcı, cayma bildiriminin kendisine ulaştığı tarihten itibaren en geç 10 gün içerisinde almış olduğu toplam bedeli ve varsa tüketiciyi borç altına sokan her türlü belgeyi tüketiciye hiçbir masraf yüklemeksizin iade edip yirmi gün içerisinde de malı geri alacaktır.Teslim alınmış olan malın değerinin azalması veya iadeyi imkânsız kılan bir nedenin varlığı cayma hakkının kullanılmasına engel değildir. Ancak değer azalması veya iadenin imkânsızlaşması tüketicinin kusurundan kaynaklanıyorsa satıcıya malın değerini veya değerindeki azalmayı tazmin etmesi gerekir.Sehven alınan her ürün için de genel iade süresi 7 gündür. Bu süre içerisinde, ambalajı açılmış, kullanılmış, tahrif edilmiş vesaire şekildeki ürünlerin iadesi kabul edilmez. İade, orijinal ambalaj ile yapılmalıdır. Sehven alınan üründe ve ambalajında herhangi bir açılma, bozulma, kırılma, tahrip, yırtılma, kullanılma vesair durumlar tespit edildiği hallerde ve ürünün alıcıya teslim edildiği andaki hali ile iade edilememesi halinde ürün iade alınmaz ve bedeli iade edilmez.Ürün iadesi için, durum öncelikli olarak müşteri hizmetlerine iletilmelidir. Ürünün iade olarak gönderilme bilgisi, satıcı tarafından müşteriye iletilir. Bu görüşmeden sonra iade formu ile birlikte alıcı adresine teslimatı yapan Kargo Şirketi ile ürünü, ürün faturasını satıcıya ulaştırmalıdır. Satıcıya ulaşan iade ürün işbu sözleşmede belirtilen koşulları sağladığı takdirde iade olarak kabul edilir, geri ödemesi de alıcı kredi kartına/hesabın yapılır. Ürün iade edilmeden bedel iadesi yapılmaz. Kredi Kartına yapılan iadelerin kredi kartı hesaplarına yansıma süresi ilgili bankanın tasarrufundadır.Alışveriş kredi kartı ile ve taksitli olarak yapılmışsa, kredi kartına iade prosedürü şu şekilde uygulanacaktır: ALICI ürünü kaç taksit ile satın alma talebini iletmiş ise, Banka ALICI&rsquo;ya geri ödemesini taksitle yapmaktadır. SATICI bankaya ürün bedelinin tamamını tek seferde ödedikten sonra, Banka poslarından yapılan taksitli harcamaların ALICI&rsquo;nın kredi kartına iadesi durumunda, konuya müdahil tarafların mağdur duruma düşmemesi için talep edilen iade tutarları, yine taksitli olarak hamil taraf hesaplarına Banka tarafından aktarılır. ALICI&rsquo;nın satış iptaline kadar ödemiş olduğu taksit tutarları, eğer iade tarihi ile kartın hesap kesim tarihleri çakışmazsa her ay karta 1(bir) iade yansıyacak ve ALICI iade öncesinde ödemiş olduğu taksitleri satışın taksitleri bittikten sonra, iade öncesinde ödemiş olduğu taksit sayısı kadar ay daha alacak ve mevcut borçlarından düşmüş olacaktır.Kart ile alınmış mal ve hizmetin iadesi durumunda SATICI, Banka ile yapmış olduğu sözleşme gereği ALICI&rsquo;ya nakit para ile ödeme yapamaz. SATICI, bir iade işlemi söz konusu olduğunda ilgili yazılım aracılığı ile iadesini yapacak olup, SATICI ilgili tutarı bankaya nakden veya mahsuben ödemekle yükümlü olduğundan yukarıda detayları belirtilen prosedür gereğince ALICI&rsquo;ya nakit olarak ödeme yapılamamaktadır. Kredi kartına iade, ALICI&rsquo;nın bankaya bedeli tek seferde ödemesinden sonra, banka tarafından yukarıdaki prosedür gereğince yapılacaktır.<br>
                  <br>
                  İşbu sözleşmenin uygulanmasından doğacak olan ihtilaflarda Ankara Mahkemeleri / İcra Daireleri yetkilidir.</p>
                <br>
                MADDE 1 - KONU<br>
                <br>
                İşbu sözleşmenin konusu, SATICI'nın, ALICI'ya satışını yaptığı, internet sitesinde online satışa sunulmuş olan ürünlerin satışı ve teslimi ile ilgili olarak 4077 sayılı Tüketicilerin Korunması Hakkındaki Kanun hükümleri gereğince tarafların hak ve yükümlülüklerini kapsamaktadır.<br>
                <br>
                MADDE 2.1- SATICI BİLGİLERİ<br>
                <br>
                Unvan:Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi<br>
                Adres: Plevne Cad. No:272 Mamak/ANKARA<br>
                <br>
                MADDE 2.2 - ALICI BİLGİLERİ <br>
                <br>
                Müşteri <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a> alışveriş sitesine üye olan veya üye olmadan alışveriş seçeneğini kullanarak alışveriş yapan kişidir. Müşterinin üye olurken kullanılan adres ve iletişim bilgileri esas alınır.<br>
                <br>
                MADDE 3 - SÖZLEŞME KONUSU ÜRÜN BİLGİLERİ <br>
                <br>
                Malın / Ürünün / Hizmetin türü, miktarı, marka/modeli, rengi, adedi, satış bedeli, ödeme şekli, siparişin sonlandığı andaki bilgilerden oluşmaktadır. <br>
                <br>
                MADDE 4 - GENEL HÜKÜMLER<br>
                <br>
                4.1- ALICI, Madde 3'te belirtilen sözleşme konusu ürün veya ürünlerin temel nitelikleri, satış <br>
                fiyatı ve ödeme şekli ile teslimata ilişkin tüm ön bilgileri okuyup bilgi sahibi olduğunu ve elektronik ortamda gerekli teyidi verdiğini beyan eder.<br>
                <br>
                4.2- Sözleşme konusu ürün veya ürünler, sipariş sonunda belirlemiş olduğunuz teslimat tipine göre hazırlanmak üzere işleme alınacaktır. Ankara merkezli şirketimizden ürünleri direk kendiniz teslim alabilir veya kargo firmalarıyla gönderim yapılmasını talep edebilirsiniz.Siparişleriniz onaylandıktan sonra en geç 3 (üç) iş günü sonunda Kargo firmasına teslim edilir.<br>
                <br>
                4.3- Siparişe dayalı ürün veya ürünler, 7 günlük süreyi aşmamak koşulu ile her bir ürün için ALICI'nın yerleşim yerinin uzaklığına bağlı olarak ön bilgiler içinde açıklanan süre içinde ALICI veya gösterdiği adresteki kişi/kuruluşa teslim edilir. Bu süre ALICI&rsquo;ya daha önce bildirilmek kaydıyla en fazla 3 gün daha uzatılabilir.<br>
                <br>
                <div>4.4- Sözleşme konusu ürün, ALICI'dan baska bir kişi/kuruluşa teslim edilecek ise, teslim edilecek kişi/kuruluşun teslimatı kabul etmemesinden Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketisorumlu tutulamaz.</div>
                <div> </div>
                <div>4.5- Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi, sözleşme konusu ürünün sağlam, eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri ve kullanım kılavuzları ile teslim edilmesinden sorumludur.<br>
                </div>
                <br>
                4.6- Sipariş konusu ürünün teslimatı için bedelinin ALICI'nın tercih ettiği ödeme şekli ile ödenmiş olması şarttır. Herhangi bir nedenle ürün bedeli ödenmez veya banka kayıtlarında <br>
                iptal edilir ise, Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi ürünün teslimi yükümlülüğünden kurtulmuş kabul edilir.<br>
                <br>
                4.7- Ürünün tesliminden sonra ALICI'ya ait kredi kartının ALICI'nın kusurundan <br>
                kaynaklanmayan bir şekilde yetkisiz kişilerce haksız veya hukuka aykırı olarak kullanılması <br>
                nedeni ile ilgili banka veya finans kuruluşunun ürün bedelini Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya ödememesi halinde, ALICI'nın kendisine teslim edilmiş olması kaydıyla ürünün 3 gün içinde Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya gönderilmesi zorunludur. Bu takdirde nakliye giderleri ALICI'ya aittir.<br>
                <br>
                4.8- Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi mücbir sebepler veya nakliyeyi engelleyen hava muhalefeti, ulaşımın <br>
                kesilmesi gibi olağanüstü durumlar nedeni ile sözleşme konusu ürünü süresi içinde teslim edemez ise, durumu ALICI'ya bildirmekle yükümlüdür. Bu takdirde ALICI siparişin iptal edilmesini, sözleşme konusu ürünün varsa emsali ile değiştirilmesini, ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasına kadar ertelenmesi haklarından birini kullanabilir. ALICI'nın siparişi iptal etmesi halinde ödediği tutar 10 gün içinde kendisine nakden ve defaten ödenir.<br>
                <br>
                4.9- Garanti belgesi ile satılan ürünlerden olan veya olmayan ürünlerin arızalı veya bozuk olanlar, garanti şartları içinde gerekli onarımın yapılması için Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi 'ya gönderilebilir, bu takdirde kargo giderleri ALICI tarafından karşılanacaktır. <br>
                <br>
                4.10- Sistem hatalarından meydana gelen fiyat yanlışlıklarından Öz Koru Peyzaj Turizm İnşaat Gıda Sanayi ve Ticaret Limited Şirketi sorumlu değildir. Buna istinaden satıcı, internet sitesindeki sistemden, dizayndan veya yasadışı yollarla internet sitesine yapılabilecek müdahaleler sebebiyle ortaya çıkabilecek tanıtım, fiyat hatalarından sorumlu değildir. Sistem hatalarına dayalı olarak alıcı satıcıdan hak iddiasında bulunamaz.<br>
                <br>
                4.11- 18 (on sekiz) yaşından küçük kişiler <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a> &lsquo;dan alışveriş yapamaz. Satıcı, alıcının sözleşmede belirttiği yaşının doğru olduğunu esas alacaktır. Ancak alıcının yanlış yazmasından dolayı satıcıya hiçbir şekilde sorumluluk yüklenemeyecektir.<br>
                <br>
                4.12- <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">http://www.marketpaketi.com.tr</a>&lsquo;dan kredi karti (Visa, MasterCard, vs. ) ya da banka havalesi ile alışveriş yapılabilir. Sipariş tarihinden itibaren bir hafta içinde havalesi yapılmayan siparişler iptal edilir. Siparişlerin işleme alınma zamanı, siparişin verildiği an değil, kredi kartı hesabından gerekli tahsilatın yapıldığı ya da havalenin (EFT&rsquo;nin) banka hesaplarına ulaştığı belirlenen andır. Ödemeli gönderi ya da posta çeki gibi müşteri hizmetleri ile görüşülmeden gerçekleştirilen ödeme yöntemleri kabul edilmez.<br>
                <br>
                4.13- Alıcı, aldığı ürünü iade etmek istemesi durumunda ne surette olursa olsun ürüne ve ambalajına zarar vermemeyi, iade anında fatura aslını ve irsaliyesini iade etmeyi kabul ve taahhüt eder.<br>
                <br>
                4.14- Zarar görmüş paket durumunda; zarar görmüş paketler teslim alınmayarak Kargo Şirketi yetkilisine tutanak tutturulmalıdır. Eğer Kargo Şirketi yetkilisi paketin hasarlı olmadığı görüşünde ise, paketin orada açılarak ürünlerin hasarsız teslim edildiğini kontrol ettirme ve durumun yine bir tutanakla tespit edilmesini isteme hakki alıcıda vardır. Paket, alıcı tarafından teslim alındıktan sonra Kargo Şirketinin görevini tam olarak yaptığı kabul edilmiş olur. Paket kabul edilmemiş ve tutanak tutulmuş ise, durum, tutanağın alıcıda kalan kopyasıyla birlikte en kısa zamanda satıcının Müşteri Hizmetlerine bildirilmelidir.<br>
                <br>
                4.15- Alıcı, 14 gün içerisinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Alıcı cayma hakkini kullandığına dair bildirimi bu süre içinde yazılı olarak satıcıya bildirmek zorundadır. Cayma hakki süresi alıcıya malın teslim edildiği günden itibaren başlar. İade edilen ürün veya ürünlerin geri gönderim bedeli alıcı tarafından karşılanmalıdır. <br>
                <br>
                4.16- Alıcı tarafından işbu sözleşmede belirtilen bilgiler ile ödeme yapmak amacı ile satıcıya bildirdiği bilgiler satıcı tarafından 3. şahıslarla paylaşılmayacaktır. Satıcı bu bilgileri sadece idari / yasal zorunluluğun mevcudiyeti çerçevesinde açıklayabilecektir. Araştırma ehliyeti belgelenmiş her türlü adli soruşturma dahilinde satıcı kendisinden istenen bilgiyi elinde bulunduruyorsa ilgili makama sağlayabilir. Kredi Kartı bilgileri kesinlikle saklanmaz, Kredi Kartı bilgileri sadece tahsilat işlemi sırasında ilgili bankalara güvenli bir şekilde iletilerek provizyon alınması için kullanılır ve provizyon sonrası sistemden silinir. Alıcıya ait e-posta adresi, posta adresi ve telefon gibi bilgiler yalnızca satıcı tarafından standart ürün teslim ve bigilendirme prosedürleri için kullanılır. Bazı dönemlerde kampanya bilgileri, yeni ürünler hakkında bilgiler, promosyon bilgileri alıcıya onayı sonrasında gönderilebilir.<br>
                <br>
                MADDE 5 - CAYMA HAKKI<br>
                <br>
                Alıcı, 14 gün içerisinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Alıcı cayma hakkını kullandığına dair bildirimi bu süre içinde yazılı olarak satıcıya bildirmek zorundadır. Cayma hakkı süresi alıcıya malın teslim edildiği günden itibaren başlar. İade edilen ürün veya ürünlerin geri gönderim bedeli alıcı tarafından karşılanmalıdır. Alıcının istekleri ve/veya açıkça onun kişisel ihtiyaçları doğrultusunda hazırlanan mallar için cayma hakkı söz konusu değildir.Alıcının cayma hakkını kullanması hâlinde satıcı, cayma bildiriminin kendisine ulaştığı tarihten itibaren en geç 10 gün içerisinde almış olduğu toplam bedeli ve varsa tüketiciyi borç altına sokan her türlü belgeyi tüketiciye hiçbir masraf yüklemeksizin iade edip yirmi gün içerisinde de malı geri alacaktır.Teslim alınmış olan malın değerinin azalması veya iadeyi imkânsız kılan bir nedenin varlığı cayma hakkının kullanılmasına engel değildir. Ancak değer azalması veya iadenin imkânsızlaşması tüketicinin kusurundan kaynaklanıyorsa satıcıya malın değerini veya değerindeki azalmayı tazmin etmesi gerekir.Sehven alınan her ürün için de genel iade süresi 7 gündür. Bu süre içerisinde, ambalajı açılmış, kullanılmış, tahrif edilmiş vesaire şekildeki ürünlerin iadesi kabul edilmez. İade, orijinal ambalaj ile yapılmalıdır. Sehven alınan üründe ve ambalajında herhangi bir açılma, bozulma, kırılma, tahrip, yırtılma, kullanılma vesair durumlar tespit edildiği hallerde ve ürünün alıcıya teslim edildiği andaki hali ile iade edilememesi halinde ürün iade alınmaz ve bedeli iade edilmez.Ürün iadesi için, durum öncelikli olarak müşteri hizmetlerine iletilmelidir. Ürünün iade olarak gönderilme bilgisi, satıcı tarafından müşteriye iletilir. Bu görüşmeden sonra iade formu ile birlikte alıcı adresine teslimatı yapan Kargo Şirketi ile ürünü, ürün faturasını satıcıya ulaştırmalıdır. Satıcıya ulaşan iade ürün işbu sözleşmede belirtilen koşulları sağladığı takdirde iade olarak kabul edilir, geri ödemesi de alıcı kredi kartına/hesabın yapılır. Ürün iade edilmeden bedel iadesi yapılmaz. Kredi Kartına yapılan iadelerin kredi kartı hesaplarına yansıma süresi ilgili bankanın tasarrufundadır.Alışveriş kredi kartı ile ve taksitli olarak yapılmışsa, kredi kartına iade prosedürü şu şekilde uygulanacaktır: ALICI ürünü kaç taksit ile satın alma talebini iletmiş ise, Banka ALICI&rsquo;ya geri ödemesini taksitle yapmaktadır. SATICI bankaya ürün bedelinin tamamını tek seferde ödedikten sonra, Banka poslarından yapılan taksitli harcamaların ALICI&rsquo;nın kredi kartına iadesi durumunda, konuya müdahil tarafların mağdur duruma düşmemesi için talep edilen iade tutarları, yine taksitli olarak hamil taraf hesaplarına Banka tarafından aktarılır. ALICI&rsquo;nın satış iptaline kadar ödemiş olduğu taksit tutarları, eğer iade tarihi ile kartın hesap kesim tarihleri çakışmazsa her ay karta 1(bir) iade yansıyacak ve ALICI iade öncesinde ödemiş olduğu taksitleri satışın taksitleri bittikten sonra, iade öncesinde ödemiş olduğu taksit sayısı kadar ay daha alacak ve mevcut borçlarından düşmüş olacaktır.Kart ile alınmış mal ve hizmetin iadesi durumunda SATICI, Banka ile yapmış olduğu sözleşme gereği ALICI&rsquo;ya nakit para ile ödeme yapamaz. SATICI, bir iade işlemi söz konusu olduğunda ilgili yazılım aracılığı ile iadesini yapacak olup, SATICI ilgili tutarı bankaya nakden veya mahsuben ödemekle yükümlü olduğundan yukarıda detayları belirtilen prosedür gereğince ALICI&rsquo;ya nakit olarak ödeme yapılamamaktadır. Kredi kartına iade, ALICI&rsquo;nın bankaya bedeli tek seferde ödemesinden sonra, banka tarafından yukarıdaki prosedür gereğince yapılacaktır. <br>
                <br>
                İşbu sözleşmenin uygulanmasından doğacak olan ihtilaflarda Ankara Mahkemeleri / İcra Daireleri yetkilidir.</td>
            </tr>
          </tbody>
        </table>
        <table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: center; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td> </td>
            </tr>
          </tbody>
        </table>
        <table width="40%" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="text-align: center; font-weight: 100; line-height: 22px">
          <tbody>
            <tr>
              <td><strong>Öz Koru Sanal Mağazacılık Gıda İnş. Paz. San. Dış Tic Ltd. Şti</strong><br>
                Plevne Caddesi No:272/2 Mamak Ankara<br>0850 259 99 44
                <strong>Telefon 1 :</strong> 
                <a href="tel:08502599944" value="08502599944" target="_blank">0850 259 99 44</a> - <strong>Telefon 2 :</strong> <br>
                <a href="http://www.marketpaketi.com.tr/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=tr&q=http://www.marketpaketi.com.tr&source=gmail&ust=1506601653359000&usg=AFQjCNHppN7-C4mFFa_Nf304fgzo31-3jQ">www.marketpaketi.com.tr</a></td>
            </tr>
          </tbody>
      </table></th>
    </tr>
  </tbody>
</table>