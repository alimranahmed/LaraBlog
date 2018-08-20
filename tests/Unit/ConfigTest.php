<?php

namespace Tests\Unit;

use App\Models\Config;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigTest extends TestCase
{
    use DatabaseTransactions;

    public function testGet()
    {
        Config::create(['name' => 'test_name', 'value' => 'Test Value']);

        $this->assertEquals('Test Value', Config::get('test_name'));

        $this->assertNull(Config::get('abc_xyz'));
    }
}
