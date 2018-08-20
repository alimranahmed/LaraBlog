<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

abstract class WebTestCase extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();
    }
}