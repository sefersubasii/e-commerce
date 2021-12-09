<?php
namespace App\Services;
use SoapClient;
use SOAPHeader;

class SuratKargo {
  private $url = 'http://www.suratkargo.com.tr/GonderiWebServiceGercek/Service.asmx?wsdl';
  private $client;
  private $conf;
  public function __construct($conf){
    if(!isset($conf['username']) || !isset($conf['password'])) {
      throw new SuratException("Surat Kargo Ayarları Girilmedi");
    }
    $this->conf = $conf;
    $this->client = new SoapClient($this->url);
  }

  public function CreateShipment($params){
    try {

      $CreateShipmentData = $this->client->GonderiyiKargoyaGonder(
        array("KullaniciAdi" => $this->conf['username'],
              "Sifre" => $this->conf['password'],
              "Gonderi" => $params));
      
      if(!empty($CreateShipmentData->GonderiyiKargoyaGonderResult)){
        return $CreateShipmentData->GonderiyiKargoyaGonderResult;
      } else {
        return "Gönderdiğiniz parametreleri kontrol ediniz!";
      }
    } catch (SoapFault $sf) {

      throw new SuratException($sf);
    }
  }
}