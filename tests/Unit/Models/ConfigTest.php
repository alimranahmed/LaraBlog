<?php

namespace Tests\Unit\Models;

use App\Models\Config;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    use DatabaseTransactions;

    public function testGet()
    {
        Config::create(['name' => 'test_name', 'value' => 'Test Value']);

        $this->assertEquals('Test Value', Config::get('test_name'));

        $this->assertNull(Config::get('abc_xyz'));
    }

    public function testAllFormatted()
    {
        $name1 = 'test_name1';
        $name2 = 'test_name2';
        $value1 = 'Test Value1';
        $value2 = 'Test Value2';

        Config::create(['name' => $name1, 'value' => $value1, 'is_active' => 1]);
        Config::create(['name' => $name2, 'value' => $value2, 'is_active' => 0]);

        $config = Config::allFormatted(1);

        $this->assertEquals($value1, $config->$name1);

        try {
            $this->assertNotEquals('Test Value1', $this->$name2);
        } catch (\ErrorException $e) {
            $this->expectExceptionMessage('Undefined property: stdClass::$test_name1');
        }


        $config = Config::allFormatted(0);

        $this->assertEquals($value1, $config->$name1);
        $this->assertEquals($value2, $this->$name2);
    }
}
