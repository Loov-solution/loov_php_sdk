<?php

namespace Src;
const BASEURL  ='https://api.loov-solutions.com/api/';
const ACCEPT = 'application/x-www-form-urlencoded';
const CONTENT_TYPE = 'application/json';
const COOKIE = "XSRF-TOKEN=eyJpdiI6InR4ZXJVM0tBZmlveDM3VkNPeTNXM0E9PSIsInZhbHVlIjoibWNTTndlS3J5dU5QTnpsNDVENWZJdklvOWx4bk5Od3FIVXZyVEkzdmlDS2V0T04veUdST3FTU053em0yOXZ3OG1ja1N1MzdqYzBzUndrOGc1NHBvVVdwOXhwMWNxOHBvVG45VmMzNXE3MzFUaGRsNncydDVya3VpTzhmWmVNU2kiLCJtYWMiOiIyNDcwY2IwZmM0MzJkNzc0OGVlNGYyM2E4NmYwMTBhODViMWU3N2YzNWZmZjY5OTk2ZWRiMmE0MTQxMzBjOTAyIiwidGFnIjoiIn0%3D; loov_solutions_session=eyJpdiI6ImhxTWZpYmc5S25nY2dvRWpnSVhhMUE9PSIsInZhbHVlIjoiV0FjS1pxR1lOcXBCc2FWWmFPcjgvWnJTMkZwYmZNanNldzJhTVppUTlQTzlTazJYV1pVVm4zeW1tMFZNL2tUWnczQ2dQcWEvamtyM2ZITlFaT0llNnQ1S2FEV29leGZhaVcyTHl4c0VIcU5MSUlLa2MrcDhOZzI3V0pTTUtseDgiLCJtYWMiOiI2NDE5NTNkZTNhZDFlMTNkODg1YjYzZTQwN2U1NjMzNTk1N2ZhODNiNmZjODZlMjkzNGE4MjA5NjVmYmI5YjM1IiwidGFnIjoiIn0%3D";


class LoovPay{
    public $amount=0;
    public $sender_curency='';
    public $return_url='';
    public $cancel_url ='';
    public $notify_url ='';
    public $header = array();
    public $curl;

    public function __constructor($app_key,$marchant_key){
        $this->app_key=$app_key;
        $this->marchant_key = $marchant_key;
        $this->header=[
            'Accept'=>  ACCEPT,
            'Cookie'=>COOKIE,
            'Content_Type'=>CONTENT_TYPE,
            'marchant_key'=>$this->marchant_key,
            'api_key'=>$this->api_key
        ];
        $this->curl= curl_init();
    }

    public function initpayment(array $array){
        if($array[$this->amount] <= 100) throw new Exception("Error: amount must be greather than 100");
        if (gettype(!array_key_exists($this->amount,$array))!== 'number') throw new Exception('amount must be of type number');
        if(!array_key_exists($this->return_url,$array)) throw new Exception("Error: return url not define");
        if (gettype(!array_key_exists($this->return_url,$array))!== 'string') throw new Exception('return url must be of type string');
        if(!array_key_exists($this->cancel_url,$array)) throw new Exception("Error: cancel url not define");
        if (gettype(!array_key_exists($this->cancel_url,$array))!== 'string') throw new Exception('cancel url must be of type string');

        try{
            curl_setopt_array($this->curl,array(
                CURLOPT_URL => BASEURL.'payments/init',
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $array,
                CURLOPT_HTTPHEADER =>$this->header
            ));
            $response = curl_exec($this->curl);
            curl_close($this->curl);
            return $response;
        }catch(exception $exception){
            return $exception;
        }

    }
    public function  check_status($reference){
        if (!$reference) throw new Exception("Error: refrence is required");
        if (gettype($reference)!== 'string') throw new Exception('transaction refrence is required to be a string');

        try{
            curl_setopt_array($this->curl,array(
                CURLOPT_URL => BASEURL.'payments/status/'.$reference,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER =>$this->header
            ));
            $response = curl_exec($this->curl);
            curl_close($this->curl);
            return $response;
        }catch(exception $exception){
            return $exception;
        }
    }

}
