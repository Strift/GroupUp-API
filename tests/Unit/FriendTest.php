<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Friend;

class FriendTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasRelationships()
    {
    	$owner = factory(User::class)->create([]);
    	$user = factory(User::class)->create([]);
    	$friend = factory(Friend::class)->create(['owner_id' => $owner->id, 'user_id' => $user->id]);
        $this->assertEquals($friend->owner->id, $owner->id);
        $this->assertEquals($friend->user->id, $user->id);
    }
}
