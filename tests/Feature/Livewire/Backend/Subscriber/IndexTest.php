<?php

namespace Tests\Feature\Livewire\Backend\Subscriber;

use App\Livewire\Backend\Subscriber\Index;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testRender()
    {
        Livewire::test(Index::class)->assertOk();
    }

    public function testPlaceholder()
    {
        Livewire::test(Index::class)
            ->call('placeholder')
            ->assertOk()
            ->assertViewIs('livewire.backend.subscriber.index');
    }
}
