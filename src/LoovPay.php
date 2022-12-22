<?php

namespace Loov\PhpSdk;

use Exception;
use Illuminate\Support\Facades\Http;

class LoovPay {

    const BASEURL  ='https://api.loov-solutions.com/api/';

    public $header = [];
    public $curl;
    public $app_key;
    public $merchant_key;

    public function __constructor(){

    }

    public function setKeys(string $app_key, string $merchant_key){
        $this->header = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'merchant-key' => $merchant_key,
            'app-key' => $app_key
        );
        return $this;
    }


    /**
     * @param array $array
     * @return bool|\Exception|string
     * @throws Exception
     */
    public function initPayment(array $array)
    {
        if (!array_key_exists('amount', $array)) throw new Exception('amount is not define');

        if (!array_key_exists('sender_currency', $array)) throw new Exception('sender_currency is not define');

        if($array['amount'] <= 100) throw new Exception("Error: amount must be greather than 100");

        if(!array_key_exists('return_url', $array)) throw new Exception("Error: return url not define");

        if(!array_key_exists('cancel_url', $array)) throw new Exception("Error: cancel url not define");

        $response = Http::withHeaders($this->header)->post('https://api.loov-solutions.com/api/payments/generate', $array);

        return json_decode($response->body());

    }

    /**
     * @throws Exception
     */
    public function checkStatus(string $reference)
    {
        $response = Http::withHeaders($this->header)->get('https://api.loov-solutions.com/api/payments/status/'.$reference);

        return json_decode($response->body());

    }

}
