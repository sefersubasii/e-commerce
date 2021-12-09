<?php

namespace App\Services;

class Finansbank extends EstPos
{

    protected $test = false;

    private $productionConfig = [
        'gateway'   => 'https://www.fbwebpos.com/fim/est3Dgate',
        'url'       => 'https://www.fbwebpos.com/fim/api',
        'clientId'  => '601604294',
        'storekey'  => 'DARK1986',
        'username'  => 'marketpaketiapi',
        'password'  => '*mK17eR@',
        'storeType' => '3d',
        'mode'      => 'T' // T = TEST, P = PRODUCTION,
    ];

    private $testConfig = [
        'gateway'   => 'https://entegrasyon.asseco-see.com.tr/fim/est3Dgate',
        'url'       => 'https://entegrasyon.asseco-see.com.tr/fim/api',
        'clientId'  => '600100000',
        'storekey'  => '123456BDR',
        'username'  => 'BDRTEST',
        'password'  => 'BDRTEST1021**',
        'storeType' => '3d',
        'mode'      => 'T' // T = TEST, P = PRODUCTION
    ];

    public function __construct()
    {
        parent::__construct($this->getConfig(), [
            'gateway'   => $this->gateway(),
            'url'       => $this->url(),
            'okUrl'     => url('finansbank/callback'),
            'failUrl'   => url('finansbank/callback'),
            'lang'      => 'tr'
        ]);
    }

    protected function getConfig()
    {
        return ($this->test ? $this->testConfig : $this->productionConfig);
    }

    protected function gateway()
    {
        return ($this->test ? $this->getConfig()['gateway'] : $this->getConfig()['gateway']);
    }

    protected function url()
    {
        return ($this->test ? $this->getConfig()['url'] : $this->getConfig()['url']);
    }
}
