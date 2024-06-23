<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get('contact')
            ->assertStatus(200)
            ->assertViewIs('frontend.contact.create');

        $response->assertStatus(200);
    }
}
