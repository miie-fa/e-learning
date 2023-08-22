<?php
namespace App\Traits;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

trait Ipaymu {
    public $va;
    public $apiKey;

    public function __construct(){
        $this->va = config('ipaymu.va');
        $this->apiKey = config('ipaymu.api_key');
    }

    public function signature($body, $method){
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $this->apiKey);
    
        return $signature;
    }

    protected function balance()
    {
        $va           = $this->va; 
        $url          = 'https://sandbox.ipaymu.com/api/v2/balance';  
        $method       = 'POST';    
        $timestamp    = Date('YmdHis');

        $body['account']    = $va;
        $signature = $this->signature($body, $method);

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'va' => $va,
            'signature' => $signature,
            'timestamp' => $timestamp
        );

        $data_request = Http::withHeaders(
            $headers
        )->post($url, [
            'account' => $va
        ]);

        $responser = $data_request->object();

        return $responser;
    }

    public function call_back(HttpRequest $request){
        $va           = $this->va; 
        $url          = 'https://sandbox.ipaymu.com/api/v2/balance';  
        $method       = 'POST';    
        $timestamp    = Date('YmdHis');

        $body['account']    = $va;
        $signature = $this->signature($body, $method);

        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'va' => $va,
            'signature' => $signature,
            'timestamp' => $timestamp
        );

        $data_request = Http::withHeaders(
            $headers
        )->post($url, [
            'account' => $va
        ]);
        
        $data =[
            'sid' => $request->sid,
            'status' => $request->status,
        ];
    }
}