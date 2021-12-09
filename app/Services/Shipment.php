<?php

namespace App\Services;

use \App\Order;

class Shipment
{

    public function createShipment($order)
    {
        if (!$order) return false;

        switch ($order->shipping_id) {
                // case 5:
                // 	$resp = $this->createShipmentSk($order);
                // 	break;
            case 6:
                $resp = $this->createShipmentYk($order);
                break;

            default:
                $resp = json_encode(["Kargo firması için entegrasyon bulunmamaktadır"]);
                break;
        }

        return $resp;
    }

    public function createShipmentYk($order = false)
    {
        $data = ['username' => 'OZKORUGO', 'password' => '3BA99D4304874F'];

        $yurticiKargo = new YurticiKargo($data);

        $shippingAddress = $order->shippingAddress;

        $phoneNumber1 = str_replace(["+", " ", "(", ")"], ["", "", "", ""], $shippingAddress->phoneGsm);
        $phoneNumber2 = str_replace(["+", " ", "(", ")"], ["", "", "", ""], $shippingAddress->phone);

        if ($shippingAddress->address) {
            $receiverAddress = $shippingAddress->address . '  ' . $shippingAddress->state . ' / ' . $shippingAddress->city;
        } else {
            $receiverAddress = $shippingAddress->address;
        }

        $params = [
            "cargoKey" => $order->order_no,
            "invoiceKey" => $order->order_no,
            "receiverCustName" => $shippingAddress->name . " " . $shippingAddress->surname,
            "receiverAddress" => $receiverAddress,
            "receiverPhone1" => $phoneNumber1,
            "receiverPhone2" => $phoneNumber2,
            "emailAddress" => $order->customer->email,
            "cityName" => $shippingAddress->city,
            "townName" => $shippingAddress->state,
            "taxOfficeId" => "",
            "cargoCount" => "",
            "ttDocumentId" => "",
            "dcSelectedCredit" => "",
            "dcCreditRule" => "",
        ];

        return $yurticiKargo->CreateShipment($params);
    }
}
