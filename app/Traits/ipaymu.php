<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ipaymu {
    protected function balance()
    {
        $va           = '0000002142719548'; //get on iPaymu dashboard
        $apiKey       = 'SANDBOX3C5BEDC6-1552-45E1-B350-43A399FF123A'; //get on iPaymu dashboard
        $url          = 'https://sandbox.ipaymu.com/api/v2/balance'; // for development mode     
        $method       = 'POST'; //method     
        //Request Body//
        $body['account']    = $va;
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = Date('YmdHis');
        //End Generate Signature


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

        // $balance = json_decode($responser);

        return $responser;
    }
}