<?php


namespace App\Services\GeoIp;

abstract class GeoIp
{
    abstract public function getGeo(string $ip);
}
