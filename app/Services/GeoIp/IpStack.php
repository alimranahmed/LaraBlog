<?php


namespace App\Services\GeoIp;

use GuzzleHttp\Client;

class IpStack extends GeoIp
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
           'base_uri' => 'http://api.ipstack.com/',
        ]);
    }

    public function getGeo(string $ip)
    {
        $response = $this->client->get("$ip?access_key=".config('services.ipstack.API_KEY'));

        return json_decode($response->getBody()->getContents());
    }
}
