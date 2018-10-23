<?php

namespace Tests\Unit;

use App\Services\GeoIp\FakeGeoIp;
use App\Services\GeoIp\GeoIp;
use Tests\TestCase;

class GeoIpTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->app->bind(GeoIp::class, FakeGeoIp::class);

        $geoIp = app(GeoIp::class);

        $location = $geoIp->getGeo('35.176.231.251');

        $this->assertEquals('United Kingdom', $location->country_name);
    }
}
