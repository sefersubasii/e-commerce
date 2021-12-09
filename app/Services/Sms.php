<?php

namespace App\Services;

use App\Contracts\Sms as ContractsSms;
use Illuminate\Support\Str;

abstract class Sms implements ContractsSms
{
    /**
     * SMS Sender Title
     *
     * @var string
     */
    protected $sender;

    /**
     * API Username
     *
     * @var string
     */
    protected $username;

    /**
     * API Password
     *
     * @var string
     */
    protected $password;

    /**
     * SMS Send Status
     *
     * @var boolean
     */
    protected $enabled   = false;

    /**
     * Replace Turkish Characters
     *
     * @var boolean
     */
    protected $replaceTr = false;

    /**
     * SMS Message
     *
     * @var string
     */
    protected $message;

    /**
     * SMS Number
     *
     * @var string
     */
    protected $number;

    /**
     * Set Configurations
     */
    public function __construct()
    {
        $this->sender   = config('sms.sender');
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->enabled  = config('sms.enabled');
    }

    /**
     * Child Class Abstract Method
     *
     * @return mixed
     */
    abstract public function run();

    /**
     * Set Message
     *
     * @param string $message
     * @return self
     */
    public function message(string $message)
    {
        if ($this->replaceTr) {
            $this->message = $this->replaceTr($message);
        } else {
            $this->message = $message;
        }

        return $this;
    }

    /**
     * Set Number
     *
     * @param string $number
     * @return self
     */
    public function number(string $number)
    {
        $this->number = str_replace(['+', '(', ')', ' '], ['', '', '', ''], $number);

        if (Str::startsWith($this->number, '9')) {
            $this->number = str_replace_first('9', '', $this->number);
        }

        if (!Str::startsWith($this->number, '0')) {
            $this->number = '0' . $this->number;
        }

        return $this;
    }

    /**
     * Send SMS
     *
     * @return mixed
     */
    public function send()
    {
        if (!$this->enabled) {
            return null;
        }

        $result = $this->run();

        $this->message = $this->number = null;

        return $result;
    }

    /**
     * Replace Turkish Characters
     *
     * @param string $text
     * @return string
     */
    public function replaceTr(string $text)
    {
        return trim(str_replace([
            'Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü',
        ], [
            'C', 'c', 'G', 'g', 'i', 'I', 'O', 'o', 'S', 's', 'U', 'u',
        ], $text));
    }

    /**
     * Send XML Data
     *
     * @param string $postUrl
     * @param string $xmlData
     * @return mixed
     */
    public function sendXmlPost(string $postUrl, string $xmlData)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
