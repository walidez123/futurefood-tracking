<?php

namespace App\ProvidersIntegration;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class HttpClient
{
    public $nowDate;

    public $nowTime;

    public function __construct()
    {
        $this->nowDate = Carbon::now()->format('Y-m-d');
        $this->nowTime = Carbon::now()->format('H-i-s');
    }

    public function buildHeaders($token = null, $contentType = 'application/json')
    {
        $headers = [
            'Content-Type: '.$contentType,
            'Accept: application/json',
        ];

        if (! is_null($token)) {
            $headers = array_merge($headers, [
                'Authorization: Bearer '.$token,
            ]);
        }

        return $headers;
    }

    public function prepareCall($baseUrl, $callType, $path, $request, $token = null, $contentType = 'application/json')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $callType);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);

        $headers = $this->buildHeaders($token, $contentType);

        switch ($callType) {
            case 'GET':
                $url = $baseUrl.$path;
                if ($request != null) {
                    $url = $baseUrl.$path.'?'.http_build_query($request);
                }

                curl_setopt($ch, CURLOPT_URL, $url);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_URL, $baseUrl.$path);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_URL, $baseUrl.$path);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_PUT, true);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $ch;
    }

    public function executeGetCall($baseUrl, $path, $request, $token)
    {
        $prepareCall = $this->prepareCall($baseUrl, 'GET', $path, $request, $token);
        $result = curl_exec($prepareCall);
        $error = curl_errno($prepareCall);
        Storage::put('curlErrors/'.$this->nowDate.'.txt', $error);

        return $result;
    }

    public function executePostCall($baseUrl, $path, $request, $token = null, $contentType = 'application/json')
    {
        $prepareCall = $this->prepareCall($baseUrl, 'POST', $path, $request, $token, $contentType);
        $result = curl_exec($prepareCall);
        $httpCode = curl_getinfo($prepareCall, CURLINFO_HTTP_CODE);
        $responseCode = curl_errno($prepareCall);

        Storage::append('curlErrors/'.$this->nowDate.'.txt', $responseCode);

        return $result;
    }

    public function executePutCall($baseUrl, $path, $request, $token = null, $contentType = 'application/json')
    {
        $prepareCall = $this->prepareCall($baseUrl, 'PUT', $path, $request, $token, $contentType);
        $result = curl_exec($prepareCall);
        $httpCode = curl_getinfo($prepareCall, CURLINFO_HTTP_CODE);
        $responseCode = curl_errno($prepareCall);

        Storage::append('curlErrors/'.$this->nowDate.'.txt', $responseCode);

        return $result;
    }
}
