<?php

namespace App\Services;

use App\Services\EstPosHelpersTrait;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;

/**
 * Est 3D Model Post İşlem Sınıfı
 */
class EstPos
{
    use EstPosHelpersTrait;

    /**
     * Ayarlar
     *
     * @var array
     */
    protected $config;

    /**
     * API Account
     *
     * @var array
     */
    protected $account;

    /**
     * Transaction Types
     *
     * @var array
     */
    protected $types = [
        'pay'   => 'Auth',
        'pre'   => 'PreAuth',
        'post'  => 'PostAuth',
    ];

    /**
     * Active Transaction Type
     *
     * @var string
     */
    protected $type;

    /**
     * Currencies
     *
     * @var array
     */
    protected $currencies = [
        'TRY' => '949',
        'YTL' => '949',
        'TRL' => '949',
        'TL'  => '949',
        'USD' => '840',
        'EUR' => '978',
        'GBP' => '826',
        'JPY' => '392',
    ];

    /**
     * Response Codes
     *
     * @var array
     */
    protected $codes = [
        '00'    => 'approved',
        '01'    => 'bank_call',
        '02'    => 'bank_call',
        '05'    => 'reject',
        '09'    => 'try_again',
        '12'    => 'invalid_transaction',
        '28'    => 'reject',
        '51'    => 'insufficient_balance',
        '54'    => 'expired_card',
        '57'    => 'does_not_allow_card_holder',
        '62'    => 'restricted_card',
        '77'    => 'request_rejected',
        '99'    => 'general_error',
    ];

    /**
     * Order Details
     *
     * @var array
     */
    protected $order;

    /**
     * Card Detail
     *
     * @var array
     */
    protected $card;

    /**
     * Request
     *
     * @var mixed
     */
    protected $request;

    /**
     * Response Raw Data
     *
     * @var object
     */
    protected $data;

    /**
     * Processed Response Data
     *
     * @var mixed
     */
    public $response;

    /**
     * EstPos Contructor
     *
     * @param array $account
     * @param array $configs
     */
    public function __construct(array $account, array $configs)
    {
        $this->account = (object) $account;

        $this->config = (object) $configs;

        $request = Request::createFromGlobals();
        if ($request->getMethod() === 'POST') {
            $this->request = $request;
        }
    }

    /**
     * Create 3D Hash
     *
     * @return string
     */
    private function create3DHash()
    {
        $hash_str = $this->account->clientId . $this->order->id . $this->order->amount . $this->config->okUrl . $this->config->failUrl . $this->order->rnd . $this->account->storekey;

        return base64_encode(pack('H*', sha1($hash_str)));
    }

    /**
     * Check 3D Hash
     *
     * @return string
     */
    public function check3DHash()
    {
        $hashparams = $this->request->get("HASHPARAMS");
        $hashparamsval = $this->request->get("HASHPARAMSVAL");
        $hashparam = $this->request->get("HASH");
        $paramsval = "";
        $index1 = 0;
        $index2 = 0;

        while ($index1 < strlen($hashparams)) {
            $index2 = strpos($hashparams, ":", $index1);
            $vl = $this->request->get(substr($hashparams, $index1, $index2 - $index1));
            if ($vl == null)
                $vl = "";
            $paramsval = $paramsval . $vl;
            $index1 = $index2 + 1;
        }
        $storekey = $this->account->storekey;
        $hashval = $paramsval . $storekey;

        $hash = base64_encode(pack('H*', sha1($hashval)));

        return ($paramsval == $hashparamsval && $hashparam == $hash);
    }

    /**
     * Get 3D Form Data
     *
     * @return array
     */
    public function get3dFormData()
    {
        if ($this->order) {
            $this->order->hash = $this->create3DHash();

            $cardType = null;
            if (isset($this->card->type)) {
                if ($this->card->type == 'visa') {
                    $cardType = '1';
                } elseif ($this->card->type == 'master') {
                    $cardType = '2';
                } elseif ($this->card->type == '1' || $this->card->type == '2') {
                    $cardType = $this->card->type;
                }
            }

            $inputs = [
                'clientid'                          => $this->account->clientId,
                'storetype'                         => $this->account->storeType,
                'hash'                              => $this->order->hash,
                'cardType'                          => $cardType,
                'pan'                               => $this->card->number,
                'Ecom_Payment_Card_ExpDate_Month'   => $this->card->month,
                'Ecom_Payment_Card_ExpDate_Year'    => $this->card->year,
                'cv2'                               => $this->card->cvv,
                'firmaadi'                          => $this->order->name,
                'oid'                               => $this->order->id,
                'amount'                            => $this->order->amount,
                'okUrl'                             => $this->config->okUrl,
                'failUrl'                           => $this->config->failUrl,
                'rnd'                               => $this->order->rnd,
                'lang'                              => $this->config->lang,
                'currency'                          => $this->order->currency,
            ];

            return [
                'gateway'   => $this->config->gateway,
                'okUrl'     => $this->config->okUrl,
                'failUrl'   => $this->config->failUrl,
                'rnd'       => $this->order->rnd,
                'hash'      => $this->order->hash,
                'inputs'    => $inputs
            ];
        }

        return null;
    }

    /**
     * Prepare Order and Card
     *
     * @param array $order
     * @param array $card
     * @return mixed
     */
    public function prepare(array $order, array $card = [])
    {
        // Ödeme tipi kontrolü
        $this->type = $this->types['pay'];
        if (isset($order->transaction)) {
            if (array_key_exists($order->transaction, $this->types)) {
                $this->type = $this->types[$order->transaction];
            } else {
                throw new Exception('Desteklenmeyen ödeme türü!');
            }
        }

        // Taksit
        $installment = 0;
        if (isset($order['installment'])) {
            $installment = $order['installment'] ? (int) $order['installment'] : 0;
        }

        // Para Birimi
        $currency = null;
        if (isset($order['currency'])) {
            $currency = (int) $this->currencies[$order['currency']];
        }

        // Sipariş Bilgileri
        $this->order = (object) array_merge($order, [
            'installment'   => $installment,
            'currency'      => $currency,
            'rnd'           => microtime()
        ]);

        // Kart Bilgileri
        if ($card) {
            $card = array_merge($card, [
                'month'     => str_pad((int) $card['month'], 2, 0, STR_PAD_LEFT),
                'year'      => str_pad((int) $card['year'], 2, 0, STR_PAD_LEFT),
            ]);
        }
        $this->card = $card ? (object) $card : null;

        return $this;
    }

    /**
     * Get ProcReturnCode
     *
     * @return string|null
     */
    protected function getProcReturnCode()
    {
        return isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null;
    }

    /**
     * Get Status Detail Text
     *
     * @return string|null
     */
    protected function getStatusDetail()
    {
        $procReturnCode = $this->getProcReturnCode();

        return $procReturnCode ? (isset($this->codes[$procReturnCode]) ? (string) $this->codes[$procReturnCode] : null) : null;
    }

    /**
     * Create 3D Payment XML
     *
     * @return string
     */
    protected function create3DPaymentXML()
    {
        $nodes = [
            'CC5Request'    => [
                'Name'                      => $this->account->username,
                'Password'                  => $this->account->password,
                'ClientId'                  => $this->account->clientId,
                'Type'                      => $this->type,
                'IPAddress'                 => $this->order->ip,
                'Email'                     => $this->order->email,
                'OrderId'                   => $this->order->id,
                'UserId'                    => isset($this->order->user_id) ? $this->order->user_id : null,
                'Total'                     => $this->order->amount,
                'Currency'                  => $this->order->currency,
                // 'Taksit'                    => $this->order->installment,
                'Number'                    => $this->request->get('md'),
                'Expires'                   => '',
                'Cvv2Val'                   => '',
                'PayerTxnId'                => $this->request->get('xid'),
                'PayerSecurityLevel'        => $this->request->get('eci'),
                'PayerAuthenticationCode'   => $this->request->get('cavv'),
                'CardholderPresentCode'     => '13',
                'Mode'                      => isset($this->account->mode) ? $this->account->mode : 'P',
                'GroupId'                   => '',
                'TransId'                   => '',
            ]
        ];
        if ($this->order->name) {
            $nodes['BillTo'] = [
                'Name'   => $this->order->name,
            ];
        }

        return $this->createXML($nodes, 'ISO-8859-9');
    }

    /**
     * Make 3D Payment
     *
     * @return $this
     */
    protected function make3DPayment()
    {
        $status = 'declined';
        if ($this->check3DHash()) {
            $xmlContent = $this->create3DPaymentXML();
            $this->send($xmlContent);
        }

        $transaction_security = 'MPI fallback';
        if ($this->getProcReturnCode() == '00') {
            if ($this->request->get('mdStatus') == '1') {
                $transaction_security = 'Full 3D Secure';
            } elseif (in_array($this->request->get('mdStatus'), [2, 3, 4])) {
                $transaction_security = 'Half 3D Secure';
            }
            $status = 'approved';
        }

        $this->response = (object) [
            'id'                    => isset($this->data->AuthCode) ? $this->data->AuthCode : null,
            'order_id'              => isset($this->data->OrderId) ? $this->data->OrderId : null,
            'group_id'              => isset($this->data->GroupId) ? $this->data->GroupId : null,
            'trans_id'              => isset($this->data->TransId) ? $this->data->TransId : null,
            'response'              => isset($this->data->Response) ? $this->data->Response : null,
            'transaction_type'      => $this->type,
            'transaction'           => $this->order->transaction,
            'transaction_security'  => $transaction_security,
            'auth_code'             => isset($this->data->AuthCode) ? $this->data->AuthCode : null,
            'host_ref_num'          => isset($this->data->HostRefNum) ? $this->data->HostRefNum : null,
            'proc_return_code'      => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'code'                  => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'status'                => $status,
            'status_detail'         => $this->getStatusDetail(),
            'error_code'            => isset($this->data->Extra->ERRORCODE) ? $this->data->Extra->ERRORCODE : null,
            'error_message'         => isset($this->data->ErrMsg) ? $this->data->ErrMsg : null,
            'md_status'             => $this->request->get('mdStatus'),
            'hash'                  => (string) $this->request->get('HASH'),
            'rnd'                   => (string) $this->request->get('rnd'),
            'hash_params'           => (string) $this->request->get('HASHPARAMS'),
            'hash_params_val'       => (string) $this->request->get('HASHPARAMSVAL'),
            'masked_number'         => (string) $this->request->get('maskedCreditCard'),
            'month'                 => (string) $this->request->get('Ecom_Payment_Card_ExpDate_Month'),
            'year'                  => (string) $this->request->get('Ecom_Payment_Card_ExpDate_Year'),
            'amount'                => (string) $this->request->get('amount'),
            'currency'              => (string) $this->request->get('currency'),
            'tx_status'             => (string) $this->request->get('txstatus'),
            'eci'                   => (string) $this->request->get('eci'),
            'cavv'                  => (string) $this->request->get('cavv'),
            'xid'                   => (string) $this->request->get('xid'),
            'md_error_message'      => (string) $this->request->get('mdErrorMsg'),
            'name'                  => (string) $this->request->get('firmaadi'),
            'campaign_url'          => null,
            'email'                 => (string) $this->request->get('Email'),
            'extra'                 => isset($this->data->Extra) ? $this->data->Extra : null,
            'all'                   => $this->data,
            '3d_all'                => $this->request->request->all(),
        ];

        return $this;
    }

    /**
     * Send XML Contents to WebService
     *
     * @param string $xmlContent
     * @return $this
     * @throws GuzzleException
     */
    protected function send($xmlContent)
    {
        $client = new Client();

        $response = $client->request('POST', $this->config->url, [
            'body' => $xmlContent
        ]);

        $xml = new SimpleXMLElement($response->getBody());

        return $this->data = (object) json_decode(json_encode($xml));
    }

    /**
     * Make Payment
     *
     * @param array $card
     * @return $this
     */
    public function payment(array $card = [])
    {
        $this->card = (object) $card;

        $this->make3DPayment();

        return $this;
    }

    /**
     * Refund Ordser
     *
     * @param array $meta
     * @return $this
     */
    public function refund(array $meta)
    {
        $nodes = [
            'CC5Request'    => [
                'Name'      => $this->account->username,
                'Password'  => $this->account->password,
                'ClientId'  => $this->account->clientId,
                'OrderId'   => $meta['order_id'],
                'Type'      => 'Credit',
            ]
        ];

        if (isset($meta['amount'])) $nodes['Total'] = $meta['amount'];

        $xml = $this->createXML($nodes, 'ISO-8859-9');

        $this->send($xml);

        $status = 'declined';
        if ($this->getProcReturnCode() == '00') {
            $status = 'approved';
        }

        $this->response = (object) [
            'order_id'          => isset($this->data->OrderId) ? $this->data->OrderId : null,
            'group_id'          => isset($this->data->GroupId) ? $this->data->GroupId : null,
            'response'          => isset($this->data->Response) ? $this->data->Response : null,
            'auth_code'         => isset($this->data->AuthCode) ? $this->data->AuthCode : null,
            'host_ref_num'      => isset($this->data->HostRefNum) ? $this->data->HostRefNum : null,
            'proc_return_code'  => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'trans_id'          => isset($this->data->TransId) ? $this->data->TransId : null,
            'error_code'        => isset($this->data->Extra->ERRORCODE) ? $this->data->Extra->ERRORCODE : null,
            'error_message'     => isset($this->data->ErrMsg) ? $this->data->ErrMsg : null,
            'status'            => $status,
            'status_detail'     => $this->getStatusDetail(),
            'all'               => $this->data,
            'xml'               => $xml,
        ];

        return $this;
    }

    /**
     * Cancel Order
     *
     * @param array $meta
     * @return $this
     */
    public function cancel(array $meta)
    {
        $xml = $this->createXML([
            'CC5Request'    => [
                'Name'      => $this->account->username,
                'Password'  => $this->account->password,
                'ClientId'  => $this->account->clientId,
                'OrderId'   => $meta['order_id'],
                'Type'      => 'Void',
            ]
        ], 'ISO-8859-9');

        $this->send($xml);

        $status = 'declined';
        if ($this->getProcReturnCode() == '00') {
            $status = 'approved';
        }

        $this->response = (object) [
            'order_id'          => isset($this->data->OrderId) ? $this->data->OrderId : null,
            'group_id'          => isset($this->data->GroupId) ? $this->data->GroupId : null,
            'response'          => isset($this->data->Response) ? $this->data->Response : null,
            'auth_code'         => isset($this->data->AuthCode) ? $this->data->AuthCode : null,
            'host_ref_num'      => isset($this->data->HostRefNum) ? $this->data->HostRefNum : null,
            'proc_return_code'  => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'trans_id'          => isset($this->data->TransId) ? $this->data->TransId : null,
            'error_code'        => isset($this->data->Extra->ERRORCODE) ? $this->data->Extra->ERRORCODE : null,
            'error_message'     => isset($this->data->ErrMsg) ? $this->data->ErrMsg : null,
            'status'            => $status,
            'status_detail'     => $this->getStatusDetail(),
            'all'               => $this->data,
            'xml'               => $xml,
        ];

        return $this;
    }

    /**
     * Order Status
     *
     * @param array $meta
     * @return $this
     */
    public function status(array $meta)
    {
        $xml = $this->createXML([
            'CC5Request'    => [
                'Name'      => $this->account->username,
                'Password'  => $this->account->password,
                'ClientId'  => $this->account->clientId,
                'OrderId'   => $meta['order_id'],
                'Extra'     => [
                    'ORDERSTATUS'   => 'QUERY',
                ],
            ]
        ], 'ISO-8859-9');

        $this->send($xml);

        $status = 'declined';
        if ($this->getProcReturnCode() == '00') {
            $status = 'approved';
        }

        $first_amount   = isset($this->data->Extra->ORIG_TRANS_AMT) ? $this->data->Extra->ORIG_TRANS_AMT : null;
        $capture_amount = isset($this->data->Extra->CAPTURE_AMT) ? $this->data->Extra->CAPTURE_AMT : null;
        $capture = ($first_amount == $capture_amount ? true : false);

        $this->response = (object) [
            'order_id'          => isset($this->data->OrderId) ? $this->data->OrderId : null,
            'response'          => isset($this->data->Response) ? $this->data->Response : null,
            'proc_return_code'  => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'trans_id'          => isset($this->data->TransId) ? $this->data->TransId : null,
            'error_message'     => isset($this->data->ErrMsg) ? $this->data->ErrMsg : null,
            'host_ref_num'      => isset($this->data->Extra->HOST_REF_NUM) ? $this->data->Extra->HOST_REF_NUM : null,
            'order_status'      => isset($this->data->Extra->ORDERSTATUS) ? $this->data->Extra->ORDERSTATUS : null,
            'process_type'      => isset($this->data->Extra->CHARGE_TYPE_CD) ? $this->data->Extra->CHARGE_TYPE_CD : null,
            'pan'               => isset($this->data->Extra->PAN) ? $this->data->Extra->PAN : null,
            'num_code'          => isset($this->data->Extra->NUMCODE) ? $this->data->Extra->NUMCODE : null,
            'first_amount'      => $first_amount,
            'capture_amount'    => $capture_amount,
            'status'            => $status,
            'status_detail'     => $this->getStatusDetail(),
            'capture'           => $capture,
            'all'               => $this->data,
            'xml'               => $xml,
        ];

        return $this;
    }

    /**
     * Order History
     *
     * @param array $meta
     * @return $this
     */
    public function history(array $meta)
    {
        $xml = $this->createXML([
            'CC5Request'    => [
                'Name'      => $this->account->username,
                'Password'  => $this->account->password,
                'ClientId'  => $this->account->clientId,
                'OrderId'   => $meta['order_id'],
                'Extra'     => [
                    'ORDERHISTORY'   => 'QUERY',
                ],
            ]
        ], 'ISO-8859-9');

        $this->send($xml);

        $status = 'declined';
        if ($this->getProcReturnCode() == '00') {
            $status = 'approved';
        }

        $this->response = (object) [
            'order_id'          => isset($this->data->OrderId) ? $this->data->OrderId : null,
            'response'          => isset($this->data->Response) ? $this->data->Response : null,
            'proc_return_code'  => isset($this->data->ProcReturnCode) ? $this->data->ProcReturnCode : null,
            'error_message'     => isset($this->data->ErrMsg) ? $this->data->ErrMsg : null,
            'num_code'          => isset($this->data->Extra->NUMCODE) ? $this->data->Extra->NUMCODE : null,
            'trans_count'       => isset($this->data->Extra->TRXCOUNT) ? $this->data->Extra->TRXCOUNT : null,
            'status'            => $status,
            'status_detail'     => $this->getStatusDetail(),
            'all'               => $this->data,
            'xml'               => $xml,
        ];

        return $this;
    }
}
