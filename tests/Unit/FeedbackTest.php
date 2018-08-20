<?php

namespace Tests\Unit;

use App\Models\Feedback;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackTest extends TestCase
{
    public function testCreatedAtHumanAttribute()
    {
        $feedback = Feedback::create([
            'email' => 'foo@bar.com',
            'content' => 'test content',
        ]);
        $this->assertEquals('1 second ago', $feedback->createdAtHuman);
    }
}
