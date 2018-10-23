<?php

namespace Tests\Unit;

use App\Services\GeoIp\GeoIp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeoIpTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $geoIp = app(GeoIp::class);

        $location = $geoIp->getGeo('35.176.231.251');

        $this->assertEquals('United Kingdom', $location->country_name);
    }
}
