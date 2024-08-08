<?php

namespace App\ProvidersIntegration\Zid;

use App\ProvidersIntegration\HttpClient;

class Zid
{
    protected $clientId;

    protected $clientSecret;

    protected $authUrl;

    protected $baseUrl;

    protected $nowDate;

    protected $nowTime;

    protected $httpClient;

    public function __construct()
    {
        $this->clientId = config('zid.client_id');
        $this->clientSecret = config('zid.client_secret');
        $this->authUrl = config('zid.auth_url');
        $this->baseUrl = config('zid.base_url');
        $this->nowDate = now()->format('Y-m-d');
        $this->nowTime = now()->format('H-i-s');
        $this->httpClient = new HttpClient();
    }

    protected function getAccessToken($merchantUser)
    {
        return $merchantUser->provider_access_token;
    }
}
