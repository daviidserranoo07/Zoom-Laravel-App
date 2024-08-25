<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use GuzzleHttp\Client;

class ZoomServiceProvider extends ServiceProvider
{
    protected $client, $clientId, $clientSecret, $accountId, $accessToken;

    protected $url_base = 'https://zoom.us/oauth/token';
    protected $url_create_meeting = 'https://api.zoom.us/v2/users/me/meetings';
    protected $url_get_meeting = 'https://api.zoom.us/v2/meetings/';

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = env('ZOOM_CLIENT_ID');
        $this->clientSecret = env('ZOOM_CLIENT_SECRET');
        $this->accountId = env('ZOOM_ACCOUNT_ID');
        $this->accessToken = $this->generateAccessToken();
    }

    public function generateAccessToken()
    {
        $response = $this->client->post($this->url_base,[
            'form_params' => [
                'grant_type' => 'account_credentials',
                'account_id' => $this->accountId,
            ],
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ],
        ]);

        return json_decode($response->getBody(), true)['access_token'];
    }

    public function getToken(){
        return $this->accessToken;
    }

    public function generateSignature($meetingNumber, $role = 0)
    {
        $apiKey = env('ZOOM_CLIENT_ID');
        $apiSecret = env('ZOOM_CLIENT_SECRET');
        $time = time() * 1000 - 30000;

        $data = [
            'sdkKey' => $apiKey,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $time,
            'exp' => $time + 60 * 60 * 2,
            'appKey' => $apiKey,
            'tokenExp' => $time + 60 * 60 * 2,
        ];

        return rtrim(strtr(base64_encode(hash_hmac('sha256', json_encode($data), $apiSecret, true)), '+/', '-_'), '=');
    }

    public function createMeeting($data)
    {
        $response = $this->client->post($this->url_create_meeting,[
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody(),true);
    }


    public function getMeeting($meetingId)
    {
        $response = $this->client->get($this->url_get_meeting . $meetingId,[
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(),true);
    }

    public function deleteMeeting($meetingId)
    {
        $response = $this->client->delete($this->url_get_meeting . $meetingId,[
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->getStatusCode() == 204;
    }
  
}
