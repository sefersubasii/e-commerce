<?php
/**
 * Created by PhpStorm.
 * User: emre
 * Date: 11.05.2017
 * Time: 12:23
 */

namespace App\Services;

class Price
{

    public function currencyFormat($deger)
    {
        $tl_formati = number_format($deger, 2, ',', '.');
        return $tl_formati;
    }

    public function moneyFormat($price)
    {
        return number_format($price, 2, '.', '.');
    }

    public function discountedPrice($price, $type, $discount)
    {
        switch ($type) {
            case 0:
                return $price;
                break;
            case 1:
                return $price - (($price * $discount) / 100);
                break;
            case 2:
                return $discount;
                break;
            case 3:
                return $price - $discount;
                break;
        }

    }

    public function withTax($price, $tax_status, $tax)
    {
        switch ($tax_status) {
            case 0:
                return $price + (($price * $tax) / 100);
                break;
            case 1:
                return $price;
                break;

        }
    }

    public function withoutTax($price, $tax_status, $tax)
    {
        switch ($tax_status) {
            case 0:
                return $price;
                break;
            case 1:
                //return $price-(($price*$tax)/100);
                if ($tax < 10) {
                    $tax = "0" . $tax;
                }
                return $price / ("1." . $tax);
                break;

        }
    }

    public function convertToString($sayi, $kurusbasamak, $parabirimi, $parakurus, $diyez, $bb1, $bb2, $bb3)
    {
        // kurusbasamak virgülden sonra gösterilecek basamak sayısı
        // parabirimi = TL gibi , parakurus = Kuruş gibi
        // diyez başa ve sona kapatma işareti atar # gibi

        $b1 = array("", "bir", "iki", "üç", "dört", "beş", "altı", "yedi", "sekiz", "dokuz");
        $b2 = array("", "on", "yirmi", "otuz", "kırk", "elli", "altmış", "yetmiş", "seksen", "doksan");
        $b3 = array("", "yüz", "bin", "milyon", "milyar", "trilyon", "katrilyon");

        if ($bb1 != null) { // farklı dil kullanımı yada farklı yazım biçimi için
            $b1 = $bb1;
        }
        if ($bb2 != null) { // farklı dil kullanımı
            $b2 = $bb2;
        }
        if ($bb3 != null) { // farklı dil kullanımı
            $b3 = $bb3;
        }

        $say1  = "";
        $say2  = ""; // say1 virgül öncesi, say2 kuruş bölümü
        $sonuc = "";

        $sayi = str_replace(",", ".", $sayi); //virgül noktaya çevrilir

        $nokta = strpos($sayi, "."); // nokta indeksi

        if ($nokta > 0) { // nokta varsa (kuruş)

            $say1 = substr($sayi, 0, $nokta); // virgül öncesi
            $say2 = substr($sayi, $nokta, strlen($sayi)); // virgül sonrası, kuruş

        } else {
            $say1 = $sayi; // kuruş yoksa
        }

        $son;
        $w        = 1; // işlenen basamak
        $sonaekle = 0; // binler on binler yüzbinler vs. için sona bin (milyon,trilyon...) eklenecek mi?
        $kac      = strlen($say1); // kaç rakam var?
        $sonint; // işlenen basamağın rakamsal değeri
        $uclubasamak = 0; // hangi basamakta (birler onlar yüzler gibi)
        $artan       = 0; // binler milyonlar milyarlar gibi artışları yapar
        $gecici;

        if ($kac > 0) { // virgül öncesinde rakam var mı?

            for ($i = 0; $i < $kac; $i++) {

                $son    = $say1[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
                $sonint = $son; // işlenen rakam Integer.parseInt(

                if ($w == 1) { // birinci basamak bulunuyor

                    $sonuc = $b1[$sonint] . $sonuc;

                } else if ($w == 2) { // ikinci basamak

                    $sonuc = $b2[$sonint] . $sonuc;

                } else if ($w == 3) { // 3. basamak

                    if ($sonint == 1) {
                        $sonuc = $b3[1] . $sonuc;
                    } else if ($sonint > 1) {
                        $sonuc = $b1[$sonint] . $b3[1] . $sonuc;
                    }
                    $uclubasamak++;
                }

                if ($w > 3) { // 3. basamaktan sonraki işlemler

                    if ($uclubasamak == 1) {

                        if ($sonint > 0) {
                            $sonuc = $b1[$sonint] . $b3[2 + $artan] . $sonuc;
                            if ($artan == 0) { // birbin yazmasını engelle
                                if ($kac - 1 == $i) {
                                    $sonuc = str_replace($b1[1] . $b3[2], $b3[2], $sonuc);
                                }
                            }
                            $sonaekle = 1; // sona bin eklendi
                        } else {
                            $sonaekle = 0;
                        }
                        $uclubasamak++;

                    } else if ($uclubasamak == 2) {

                        if ($sonint > 0) {
                            if ($sonaekle > 0) {
                                $sonuc = $b2[$sonint] . $sonuc;
                                $sonaekle++;
                            } else {
                                $sonuc = $b2[$sonint] . $b3[2 + $artan] . $sonuc;
                                $sonaekle++;
                            }
                        }
                        $uclubasamak++;

                    } else if ($uclubasamak == 3) {

                        if ($sonint > 0) {
                            if ($sonint == 1) {
                                $gecici = $b3[1];
                            } else {
                                $gecici = $b1[$sonint] . $b3[1];
                            }
                            if ($sonaekle == 0) {
                                $gecici = $gecici . $b3[2 + $artan];
                            }
                            $sonuc = $gecici . $sonuc;
                        }
                        $uclubasamak = 1;
                        $artan++;
                    }

                }

                $w++; // işlenen basamak

            }
        } // if(kac>0)

        if ($sonuc == "") { // virgül öncesi sayı yoksa para birimi yazma
            $parabirimi = "";
        }

        $say2  = str_replace(".", "", $say2);
        $kurus = "";

        if ($say2 != "") { // kuruş hanesi varsa

            if ($kurusbasamak > 3) { // 3 basamakla sınırlı
                $kurusbasamak = 3;
            }
            $kacc = strlen($say2);
            if ($kacc == 1) { // 2 en az
                $say2         = $say2 . "0"; // kuruşta tek basamak varsa sona sıfır ekler.
                $kurusbasamak = 2;
            }
            if (strlen($say2) > $kurusbasamak) { // belirlenen basamak kadar rakam yazılır
                $say2 = substr($say2, 0, $kurusbasamak);
            }

            $kac = strlen($say2); // kaç rakam var?
            $w   = 1;

            for ($i = 0; $i < $kac; $i++) { // kuruş hesabı

                $son    = $say2[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
                $sonint = $son; // işlenen rakam Integer.parseInt(

                if ($w == 1) { // birinci basamak

                    if ($kurusbasamak > 0) {
                        $kurus = $b1[$sonint] . $kurus;
                    }

                } else if ($w == 2) { // ikinci basamak
                    if ($kurusbasamak > 1) {
                        $kurus = $b2[$sonint] . $kurus;
                    }

                } else if ($w == 3) { // 3. basamak
                    if ($kurusbasamak > 2) {
                        if ($sonint == 1) { // 'biryüz' ü engeller
                            $kurus = $b3[1] . $kurus;
                        } else if ($sonint > 1) {
                            $kurus = $b1[$sonint] . $b3[1] . $kurus;
                        }
                    }
                }
                $w++;
            }
            if ($kurus == "") { // virgül öncesi sayı yoksa para birimi yazma
                $parakurus = "";
            } else {
                $kurus = $kurus . " ";
            }
            $kurus = $kurus . $parakurus; // kuruş hanesine 'kuruş' kelimesi ekler
        }

        $sonuc = $diyez . $sonuc . " " . $parabirimi . " " . $kurus . $diyez;
        return $sonuc;
    }

}
