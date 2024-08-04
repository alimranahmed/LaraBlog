<?php

namespace Tests\Feature\Livewire\Backend\Category;

use App\Livewire\Backend\Category\Index;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testRender(): void
    {
        Livewire::test(Index::class)
            ->assertViewIs('livewire.backend.category.index')
            ->assertViewHas('categories')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testStartAdding()
    {
        Livewire::test(Index::class)
            ->set('adding', false)
            ->call('startAdding')
            ->assertSet('adding', true);
    }

    public function testStore()
    {
        Livewire::test(Index::class)
            ->set('category', [
                'name' => $name = Str::random(),
                'alias' => $alias = Str::random(),
            ])
            ->call('store');

        $this->assertDatabaseHas('categories', [
            'name' => $name,
            'alias' => $alias,
        ]);
    }
}
