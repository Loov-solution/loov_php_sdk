<?php

namespace Loov\PhpSdk;

use Exception;

class LoovPay {

    const BASEURL  ='https://api.loov-solutions.com/api/';
    const ACCEPT = 'application/x-www-form-urlencoded';
    const CONTENT_TYPE = 'application/json';

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
            'merchant-key' => $this->merchant_key,
            'app-key' => $this->app_key
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
