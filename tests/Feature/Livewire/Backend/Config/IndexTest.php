<?php

namespace Tests\Feature\Livewire\Backend\Config;

use App\Livewire\Backend\Config\Index;
use App\Models\Config;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testRender(): void
    {
        Livewire::test(Index::class)
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.config.index')
            ->assertViewHas('configs');
    }

    public function testStartEditing()
    {
        $config = Config::query()->create(['name' => 'test_config', 'value' => Str::random()]);

        Livewire::test(Index::class)
            ->call('startEditing', ['config' => $config->id])
            ->assertSee('editingConfig')
            ->assertReturned(null);
    }

    public function testUpdate()
    {
        $config = Config::query()->create(['name' => $name = 'test_config', 'value' => Str::random()]);

        Livewire::test(Index::class, ['editingConfig' => []])
            ->set('editingConfig', ['id' => $config->id, 'value' => $value = Str::random()])
            ->call('update', ['config' => $config->id])
            ->assertReturned(null);

        $this->assertDatabaseHas('configs', [
            'id' => $config->id,
            'name' => $name,
            'value' => $value,
        ]);
    }
}
