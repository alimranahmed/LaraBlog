<?php


namespace App\Services\GeoIp;

class FakeGeoIp extends GeoIp
{
    public function getGeo(string $ip)
    {
        $location = new \stdClass();
        $location->country_name = 'United Kingdom';
        $location->city = 'London';
        return $location;
    }
}
