<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapTest extends TestCase
{
    public function test_sitemap()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200)
            ->assertHeader('content-type', 'text/xml; charset=utf-8');
    }
}
