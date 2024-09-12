<?php

namespace Tests\Feature\Livewire\Backend\Feedback;

use App\Livewire\Backend\Feedback\Index;
use App\Models\Feedback;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testRender(): void
    {
        Livewire::test(Index::class)
            ->assertStatus(Response::HTTP_OK);
    }

    public function testPlaceholder()
    {
        Livewire::test(Index::class)
            ->call('placeholder')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.feedback.index')
            ->assertViewHas('feedbacks');
    }

    public function testToggleResolvedTrue()
    {
        $feedback = Feedback::factory()->create(['is_resolved' => false]);
        Livewire::test(Index::class)
            ->call('toggleResolved', ['feedback' => $feedback->id]);

        $this->assertDatabaseHas('feedbacks', ['id' => $feedback->id, 'is_resolved' => 1]);
    }

    public function testToggleResolvedFalse()
    {
        $feedback = Feedback::factory()->create(['is_resolved' => true]);

        Livewire::test(Index::class)
            ->call('toggleResolved', ['feedback' => $feedback->id]);

        $this->assertDatabaseHas('feedbacks', ['id' => $feedback->id, 'is_resolved' => 0]);
    }

    public function testClose()
    {
        $feedback = Feedback::factory()->create(['is_closed' => false]);

        Livewire::test(Index::class)
            ->call('close', ['feedback' => $feedback->id]);

        $this->assertDatabaseHas('feedbacks', ['id' => $feedback->id, 'is_closed' => 1]);
    }
}
