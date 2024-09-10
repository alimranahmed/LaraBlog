<?php

namespace Tests\Feature\Livewire\Backend;

use App\Livewire\Backend\Dashboard;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testRender()
    {
        Livewire::test(Dashboard::class)
            ->assertOk()
            ->assertViewIs('livewire.backend.dashboard')
            ->assertViewHas('categories')
            ->assertViewHas('latestComments')
            ->assertViewHas('latestFeedbacks');
    }
}
