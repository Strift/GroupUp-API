<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Game;

class UserTest extends TestCase
{
	use DatabaseMigrations;

    public function testHasApiToken()
    {
        $user = factory(User::class)->create([]);
        $this->assertNotNull($user->api_token);
    }
    
    public function testHasInterestsRelationship()
    {
    	$user = factory(User::class)->create([]);
        $this->assertNotNull($user->interests);
    }

    public function testAddInterest()
    {
    	$user = factory(User::class)->create([]);
    	$game = factory(Game::class)->create([]);
    	$user->addInterest($game);
    	$this->assertDatabaseHas('game_user', ["game_id" => $game->id, "user_id" => $user->id]);
    }

    public function testRemoveInterest()
    {
    	$user = factory(User::class)->create([]);
    	$game = factory(Game::class)->create([]);
    	$user->addInterest($game);
    	$user->removeInterest($game);
    	$this->assertDatabaseMissing('game_user', ["game_id" => $game->id, "user_id" => $user->id]);
    }

    public function testHasScheduleRelationship()
    {
        $user = factory(User::class)->create([]);
        $this->assertNotNull($user->schedule);
    }

    public function testHasSessionsThroughScheduleRelationship()
    {
        $user = factory(User::class)->create([]);
        $this->assertNotNull($user->sessions);
        $this->assertEquals($user->sessions, $user->schedule->sessions);
    }

    public function testFindByEmail()
    {
        $createdUser = factory(User::class)->create([
            'email' => 'test@email.com'
            ]);
        $foundUser = User::findByEmail('test@email.com');
        $this->assertEquals($createdUser->id, $foundUser->id);
    }

    public function testHasFriendsRelationship()
    {
        $user = factory(User::class)->create([]);
        $this->assertNotNull($user->friends);
    }

    public function testAddFriend()
    {
        $owner = factory(User::class)->create([]);
        $user = factory(User::class)->create([]);
        $this->assertTrue($owner->addFriend($user));
        $this->assertFalse($owner->addFriend($user));
        $this->assertDatabaseHas('friends', ['owner_id' => $owner->id, 'user_id' => $user->id]);
    }

    public function testRemoveFriend()
    {
        $owner = factory(User::class)->create([]);
        $user = factory(User::class)->create([]);
        $owner->addFriend($user);
        $this->assertTrue($owner->removeFriend($user));
        $this->assertFalse($owner->removeFriend($user));
        $this->assertDatabaseMissing('friends', ['owner_id' => $owner->id, 'user_id' => $user->id]);
    }

    public function testHasFriend()
    {
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $user1->addFriend($user2);
        $this->assertTrue($user1->hasFriend($user2));
        $user1->removeFriend($user2);
        $this->assertFalse($user1->hasFriend($user2));
    }

    public function testCanBeVerified()
    {
        $user = factory(User::class)->create([]);
        $this->assertTrue($user->verifyAccount());
        $this->assertFalse($user->verifyAccount());
        $this->assertTrue($user->isVerifiedAccount());
    }
}
