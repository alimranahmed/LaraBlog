<?php

namespace App\Helpers;

use App\Models\ApplicationLog;
use Illuminate\Auth\Access\Response;

class HttpClient {
    public $curlSession;
    public function __construct() {
        //$this->curlSession = curl_init();
    }

    public function send($url, $method = 'GET', $data = [], $headers = ["content-type: text/xml"]){
        $this->curlSession = curl_init();

        Utility::saveLog("[HttpClient][send] requesting to $url ...");
        Utility::saveLog("[HttpClient][send] headers: ".json_encode($headers)." data: ".(is_array($data) ? json_encode($data): $data));
        curl_setopt_array($this->curlSession, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
        ));

        if(!empty($headers)){
            curl_setopt($this->curlSession,CURLOPT_HTTPHEADER,$headers);
        }
        if(!empty($data) && in_array($method, ["POST", "PUT"])){
            curl_setopt($this->curlSession,CURLOPT_POSTFIELDS,$data);
        }

        $content = curl_exec($this->curlSession);
        $response = new Response();
        $response->body = new \stdClass();
        if (!curl_errno($this->curlSession)) {
            $httpCode = curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE);
            $response->body = $content;
            $response->statusCode = $httpCode;
            Utility::saveLog("[HttpClient][send] response status: $httpCode content: ".json_encode($content));
            if($httpCode != 200){
                $response->body->error = $content;
            }
        }else{
            $response->body = curl_error($this->curlSession);
            Utility::saveLog("[HttpClient][send][FAILED] response ".json_encode($response));
            return false;
        }

        curl_close($this->curlSession);

        return $response;
    }
}