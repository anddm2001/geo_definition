<?php

namespace App\Service;

class ApiClient{

    private $url = "https://cleaner.dadata.ru/api/v1/clean/phone";
    private $headers = array("Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Token 633777f5418703301d5b41daea1d39384493270c",
        "X-Secret: a9a3d77bffade424e2c3d789e6e063e00733a6c2");
    private $ch;
    private $result = ["country" => "", "region" => "", "timezone" => ""];

    public function __construct(){
        $this->ch = curl_init($this->url);
    }

    protected function file_get_contents_curl($tel) {

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $tel);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        $responseBody = curl_exec($this->ch);
        $statusCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($this->ch);
        $error = curl_error($this->ch);

        if($responseBody){

            return $responseBody;
        }
        $error_arr = ["statusCode" => $statusCode, "errno" => $errno, "error" => $error];

        return $error_arr;
    }

    public function newAPI($tel){

        $tel = "[" . $tel . "]";

        $responseBody = $this->file_get_contents_curl($tel);

        if($responseBody){
            $res_arr = json_decode($responseBody);
            if(is_array($res_arr)){
                if(!empty($res_arr[0]->region))
                    $this->result["region"] = $res_arr[0]->region;
                if(!empty($res_arr[0]->country))
                    $this->result["country"] = $res_arr[0]->country;
                if(!empty($res_arr[0]->timezone))
                    $this->result["timezone"] = $res_arr[0]->timezone;

                return $this->result;
            }

            return $responseBody;
        }
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}