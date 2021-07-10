<?php

namespace Tests\Unit\Models;

use App\Models\Reader;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReaderTest extends TestCase
{
    use DatabaseTransactions;

    public function testVerifiedScope()
    {
        $user =  User::factory()->create();

        Reader::create([
            'user_id' => $user->id,
            'is_verified' => 1,
        ]);

        $this->assertEquals(1, Reader::verified()->value('is_verified'));
    }

    public function testSubscribedScope()
    {
        $user =  User::factory()->create();

        Reader::create([
            'user_id' => $user->id,
            'notify' => 1,
        ]);

        $this->assertEquals(1, Reader::subscribed()->value('notify'));
    }
}
