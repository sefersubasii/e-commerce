<?php

namespace App\Services;

use SoapClient;

class yurticiKargo
{

    private $url = 'http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl';
    //private $url = 'http://testwebservices.yurticikargo.com:9090/KOPSWebServices/ShippingOrderDispatcherServices?wsdl';
    private $client;
    private $conf;
    private $connectionError = false;

    public function __construct($conf)
    {
        if (!isset($conf['username']) || !isset($conf['password'])) {
            return "Yurtiçi Kargo Ayarları Girilmedi";
        }
        $this->conf = $conf;

        ini_set('default_socket_timeout', 5000);

        try {
            $this->client = new SoapClient($this->url, array(
                'trace' => true,
                'connection_timeout' => 5000,
                // 'cache_wsdl' => WSDL_CACHE_NONE,
                'keep_alive' => false,
            ));
        } catch (SoapFault $sf) {
            $this->connectionError = true;
        }
    }

    public function CreateShipment($params)
    {
        try {
            $data = array_merge(
                array(
                    "wsUserName" => $this->conf['username'],
                    "wsPassword" => $this->conf['password'],
                    "userLanguage" => "TR",
                ),
                array("ShippingOrderVO" => $params)
            );

            $CreateShipmentData = $this->client->createShipment($data);

            if (isset($CreateShipmentData->ShippingOrderResultVO)) {
                return $CreateShipmentData->ShippingOrderResultVO;
            } else {
                return "Gönderdiğiniz parametreleri kontrol ediniz!";
            }
        } catch (SoapFault $sf) {
            return $sf;
        }
    }

    public function QueryShipment($params)
    {
        try {

            /*$data = array_merge(
            array("wsUserName" => $this->conf['username'],
            "wsPassword" => $this->conf['password'],
            "userLanguage" => "TR",
            ),
            array("ShippingOrderVO" => $params)
            );*/
            //$keys = "5b2a4c2f51b11";
            $data = [
                "wsUserName" => $this->conf['username'],
                "wsPassword" => $this->conf['password'],
                "wsLanguage" => "TR",
                "keyType" => 0,
                "keys" => $params,
                "onlyTracking" => false,
                "addHistoricalData" => false,
                //"keys" => json_encode($keys),
            ];

            $QueryShipmentData = $this->client->queryShipment($data);

            if (isset($QueryShipmentData)) {
                return $QueryShipmentData;
            } else {
                return "Gönderdiğiniz parametreleri kontrol ediniz!";
            }
        } catch (SoapFault $sf) {
            return $sf;
        }
    }

    /**
     * Gönderimi karşı taraftan iptal eder
     */
    public function cancelShipment($params)
    {
        try {
            $data = [
                "wsUserName" => $this->conf['username'],
                "wsPassword" => $this->conf['password'],
                "userLanguage" => "TR",
                "cargoKeys" => $params,
            ];

            $response = $this->client->cancelShipment($data);

            return isset($response->ShippingOrderResultVO) ? $response->ShippingOrderResultVO : "Gönderdiğiniz parametreleri kontrol ediniz!";
        } catch (SoapFault $sf) {
            return $sf;
        }
    }
}
