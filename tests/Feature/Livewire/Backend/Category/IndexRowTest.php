<?php

namespace Tests\Feature\Livewire\Backend\Category;

use App\Livewire\Backend\Category\IndexRow;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class IndexRowTest extends TestCase
{
    public function testRender()
    {
        $category = Category::factory()->create();

        Livewire::test(IndexRow::class, ['category' => $category])
            ->assertViewIs('livewire.backend.category.index-row');
    }

    public function testToggleActiveCanActivate()
    {
        $category = Category::factory()->create(['is_active' => false]);

        Livewire::test(IndexRow::class, ['category' => $category])
            ->call('toggleActive')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_active' => true,
        ]);
    }

    public function testToggleActiveCanDeactivate()
    {
        $category = Category::factory()->create(['is_active' => true]);

        Livewire::test(IndexRow::class, ['category' => $category])
            ->call('toggleActive')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_active' => false,
        ]);
    }

    public function testDestroy()
    {
        $category = Category::factory()->create(['is_active' => true]);

        Livewire::test(IndexRow::class, ['category' => $category])
            ->call('destroy', $category)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function testStartEditing()
    {
        $category = Category::factory()->create(['is_active' => true]);

        Livewire::test(IndexRow::class, ['category' => $category])
            ->call('startEditing')
            ->assertHasNoErrors()
            ->assertSet('editing', true);
    }

    public function testUpdate()
    {
        $category = Category::factory()->create(['is_active' => true]);
        Livewire::test(IndexRow::class, ['category' => $category])
            ->set('editing', true)
            ->set('categoryData', [
                'name' => $name = Str::random(),
                'alias' => $alias = Str::random(),
            ])
            ->call('update')
            ->assertSet('editing', false);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $name,
            'alias' => $alias,
        ]);
    }
}
