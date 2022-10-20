<?php

namespace Loov\PhpSdk;

use Exception;

class LoovPay {

    const BASEURL  ='https://api.loov-solutions.com/api/';
    const ACCEPT = 'application/x-www-form-urlencoded';
    const CONTENT_TYPE = 'application/json';
    const COOKIE = "XSRF-TOKEN=eyJpdiI6InR4ZXJVM0tBZmlveDM3VkNPeTNXM0E9PSIsInZhbHVlIjoibWNTTndlS3J5dU5QTnpsNDVENWZJdklvOWx4bk5Od3FIVXZyVEkzdmlDS2V0T04veUdST3FTU053em0yOXZ3OG1ja1N1MzdqYzBzUndrOGc1NHBvVVdwOXhwMWNxOHBvVG45VmMzNXE3MzFUaGRsNncydDVya3VpTzhmWmVNU2kiLCJtYWMiOiIyNDcwY2IwZmM0MzJkNzc0OGVlNGYyM2E4NmYwMTBhODViMWU3N2YzNWZmZjY5OTk2ZWRiMmE0MTQxMzBjOTAyIiwidGFnIjoiIn0%3D; loov_solutions_session=eyJpdiI6ImhxTWZpYmc5S25nY2dvRWpnSVhhMUE9PSIsInZhbHVlIjoiV0FjS1pxR1lOcXBCc2FWWmFPcjgvWnJTMkZwYmZNanNldzJhTVppUTlQTzlTazJYV1pVVm4zeW1tMFZNL2tUWnczQ2dQcWEvamtyM2ZITlFaT0llNnQ1S2FEV29leGZhaVcyTHl4c0VIcU5MSUlLa2MrcDhOZzI3V0pTTUtseDgiLCJtYWMiOiI2NDE5NTNkZTNhZDFlMTNkODg1YjYzZTQwN2U1NjMzNTk1N2ZhODNiNmZjODZlMjkzNGE4MjA5NjVmYmI5YjM1IiwidGFnIjoiIn0%3D";

    public $header = [];
    public $curl;
    public $app_key;
    public $merchant_key;

    public function __constructor(string $app_key, string $merchant_key){
        $this->app_key = $app_key;
        $this->merchant_key = $merchant_key;
        $this->header = [
            'Accept' => self::ACCEPT,
            'Content-Type' => self::CONTENT_TYPE,
            'merchant-key' => $this->marchant_key,
            'api-key' => $this->api_key
        ];
    }

    /**
     * @param array $array
     * @return bool|\Exception|string
     * @throws Exception
     */
    public function initPayment(array $array)
    {
        if (!array_key_exists('amount', $array)) throw new Exception('amount is not define');

        if($array['amount'] <= 100) throw new Exception("Error: amount must be greather than 100");

        if(!array_key_exists('return_url', $array)) throw new Exception("Error: return url not define");

        if(!array_key_exists('cancel_url', $array)) throw new Exception("Error: cancel url not define");

        $curl = curl_init();

        try {
            curl_setopt_array($curl, array(
                CURLOPT_URL => self::BASEURL.'payments/init',
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $array,
                CURLOPT_HTTPHEADER => $this->header
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        } catch(exception $exception) {
            return $exception;
        }

    }

    /**
     * @throws Exception
     */
    public function checkStatus(string $reference)
    {
        $curl = curl_init();

        try {
            curl_setopt_array($curl, array(
                CURLOPT_URL => self::BASEURL.'payments/status/'.$reference,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $this->header
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        } catch(exception $exception) {
            return $exception;
        }
    }

}
