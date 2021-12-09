<?php

namespace App\Services\Sms;

use App\Services\Sms;

class Netgsm extends Sms
{
    /**
     * Mesaj gönderimi için sistem tarafından çağırılacak method
     *
     * @return mixed
     */
    public function run()
    {
        return $this->sendXmlPost(
            'http://api.netgsm.com.tr/xmlbulkhttppost.asp',
            $this->createMessageSendXML()
        );
    }

    /**
     * SMS Message Send XML
     *
     * @return string
     */
    public function createMessageSendXML()
    {
        return "<?xml version='1.0' encoding='utf-8'?>
            <mainbody>
                <header>
                    <company dil='TR'>NETGSM</company>
                    <msgheader>" . $this->sender . "</msgheader>
                    <usercode>" . $this->username . "</usercode>
                    <password>" . $this->password . "</password>
                    <startdate></startdate>
                    <stopdate></stopdate>
                    <type>1:n</type>
                </header>
                <body>
                    <msg><![CDATA[" . $this->message . "]]></msg>
                    <no>" . $this->number . "</no>
                </body>
            </mainbody>";
    }

}
