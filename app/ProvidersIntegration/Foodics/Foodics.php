<?php

namespace App\ProvidersIntegration\Foodics;

class Foodics
{
    protected $clientId;

    protected $clientSecret;

    //  protected $authUrl;
    protected $baseUrl;

    protected $nowDate;

    protected $nowTime;

    protected $tokenType = 'Bearer';

    public function __construct()
    {
        $this->clientId = config('foodics.client_id');
        $this->clientSecret = config('foodics.client_secret');
        // $this->authUrl = config('foodics.auth_url');
        $this->baseUrl = config('foodics.base_url');
        $this->nowDate = now()->format('Y-m-d');
        $this->nowTime = now()->format('H-i-s');
    }
}
