<?php

use Carbon\Carbon;

define('CND_DOMAIN', "https://d23ic3f0nw4szy.cloudfront.net/marketpaketi");

function getCdnImage($id, $fileName = null)
{
    return CND_DOMAIN . "/products/" . $id . "/" . $fileName;
}

function getCdnMinImage($id, $fileName = null)
{
    return CND_DOMAIN . "/products/min/" . $id . "/" . $fileName;
}

function remoteImageDelete($id, $fileName)
{
    $remoteData = array(
        'fileName' => $fileName,
        'fileDir'  => 'marketpaketi',
        'fileId'   => $id,
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://data.tekkilavuz.com.tr/deletepost.php');
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $remoteData);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function remoteImageUpload($id, $filename, $filePath, $minFilePath)
{
    $fileRemoteServerName = $filename;
    $imgcont              = file_get_contents($filePath);
    $imgcontMin           = file_get_contents($minFilePath);

    $remoteData = array(
        'fileName'    => $fileRemoteServerName,
        'fileData'    => base64_encode($imgcont),
        'fileDataMin' => base64_encode($imgcontMin),
        'fileDir'     => 'marketpaketi',
        'fileId'      => $id,
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://data.tekkilavuz.com.tr/datapost.php');
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $remoteData);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

if (!function_exists('optional')) {
    function optional($value = null)
    {
        return new class($value) {
            protected $value;

            public function __construct($value = null)
            {
                $this->value = $value;
            }

            public function __get($key)
            {
                if (is_object($this->value)) {
                    return $this->value->{$key} ?? null;
                }
            }

            public function __isset($name)
            {
                if (is_object($this->value)) {
                    return isset($this->value->{$name});
                }
                if (is_array($this->value) || $this->value instanceof ArrayObject) {
                    return isset($this->value[$name]);
                }
                return false;
            }
        };
    }
}

function additionalPriceCalc($price, $percentage)
{
    return ($price + (($price * $percentage) / 100));
}

/**
 * Popup string helper
 *
 * @param string $string
 * @return void
 */
function popup_str($string = null)
{
    if (!$string) {
        return '';
    }

    return str_replace(["\r", "\n"], '', addslashes($string));
}

function isOffice($ip = '88.236.232.64')
{
    return (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == $ip);
}

if (!function_exists('mix')) {
    function mix($path, $manifest = false, $shouldHotReload = false)
    {
        if (!$manifest) {
            static $manifest;
        }

        if (!$shouldHotReload) {
            static $shouldHotReload;
        }

        if (!$manifest) {
            $manifestPath    = public_path('mix-manifest.json');
            $shouldHotReload = file_exists(public_path('hot'));

            if (!file_exists($manifestPath)) {
                throw new Exception(
                    'The Laravel Mix manifest file does not exist. ' .
                    'Please run "npm run webpack" and try again.'
                );
            }

            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (!starts_with($path, '/')) {
            $path = "/{$path}";
        }

        if (!array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unknown Laravel Mix file path: {$path}. Please check your requested " .
                "webpack.mix.js output path, and try again."
            );
        }

        return $manifest[$path];

        // return $shouldHotReload
        //     ? "http://localhost:8080{$manifest[$path]}"
        //     : url($manifest[$path]);
    }
}

if (!function_exists('now')) {
    function now()
    {
        return new class()
        {
            protected $now;
            protected $defaultFormat = 'd.m.Y H:i:s';

            public function __construct()
            {
                $this->now = Carbon::now();

                $this->now->format($this->defaultFormat);
            }

            public function __call($method, $params)
            {
                return $this->now->{$method}(...$params);
            }

            public function __toString()
            {

                return strval($this->now);
            }
        };
    }
}

function tr2en($text)
{
    $search  = array('ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü');
    $replace = array('c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U');
    $output  = str_replace($search, $replace, $text);
    return mb_strtolower(trim($output), 'UTF-8');
}