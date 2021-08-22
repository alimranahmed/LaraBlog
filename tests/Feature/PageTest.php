<?php

namespace Tests\Feature;

use App\Models\Config;
use Tests\TestCase;

class PageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::updateOrCreate(['name' => 'site_title'], ['value' => 'Site title']);
    }

    public function testHomePage()
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(Config::get('site_title'));
    }

    public function testLoginPage()
    {
        $this->get('admin/login')
            ->assertOk()
            ->assertSee('Welcome')
            ->assertSee('Login');
    }
}
