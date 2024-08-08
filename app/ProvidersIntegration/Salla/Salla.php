<?php

namespace App\ProvidersIntegration\Salla;

use App\ProvidersIntegration\HttpClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Company_provider;
use Illuminate\Support\Facades\Log;


class Salla
{
    protected $clientId;
    protected $clientSecret;
    protected $authUrl;
    protected $baseUrl;
    protected $nowDate;
    protected $nowTime;
    protected $httpClient;

    public function __construct($app_id)
    {
        $config = Company_provider::where("app_id", $app_id)->where('provider_name', 'salla')->first();
        Log::info('salla_config_'. $config);


        if (!$config) {
            throw new \Exception("Configuration for app_id {$app_id} not found.");
        }

        $this->clientId = $config->client_id;
        $this->clientSecret = $config->client_secret;
        $this->authUrl = config('salla.auth_base_url');
        $this->baseUrl = config('salla.base_url');
        $this->nowDate = now()->format('Y-m-d');
        $this->nowTime = now()->format('H-i-s');
        $this->httpClient = new HttpClient();
    }

    protected function getAccessToken($merchantUser)
    {
        if ((Carbon::parse($merchantUser->provider_access_expiry))->gt(now())) {
            $accessToken = $merchantUser->provider_access_token;
        } else {
            $accessToken = $this->refreshToken($merchantUser);
        }

        return $accessToken;
    }

    private function refreshToken($merchantUser)
    {
        $requestData = http_build_query([
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $merchantUser->provider_refresh_token,
        ]);

        Storage::put('sallaRequests/' . $this->nowDate . '/refreshToken/' . $this->nowTime . 'refreshTokenRQ.txt', $requestData);

        $response = $this->httpClient->executePostCall($this->authUrl, '/token', $requestData, null, 'application/x-www-form-urlencoded');

        Storage::put('sallaRequests/' . $this->nowDate . '/refreshToken/' . $this->nowTime . 'refreshTokenRS.json', $response);

        $decodedResponse = json_decode($response);

        if (!isset($decodedResponse->access_token)) {
            // Log the error response for debugging
            Storage::put('sallaRequests/' . $this->nowDate . '/refreshToken/' . $this->nowTime . 'refreshTokenErrorRS.json', $response);
            throw new \Exception("Failed to refresh token: " . $response);
        }

        $accessToken = $decodedResponse->access_token;
        $expireIn = $decodedResponse->expires_in;
        $refreshToken = $decodedResponse->refresh_token;

        $merchantUser->update([
            'provider_access_token' => $accessToken ?? '',
            'provider_refresh_token' => $refreshToken ?? '',
            'provider_access_expiry' => now()->addSeconds($expireIn),
        ]);

        return $accessToken;
    }
}
