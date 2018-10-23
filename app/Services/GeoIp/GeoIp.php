<?php


namespace App\Services\GeoIp;


abstract class GeoIp
{
    abstract function getGeo(string $ip);
}