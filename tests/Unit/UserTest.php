<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasApiToken()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->api_token);
    }
    
    public function testHasInterestsRelationship()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->interests);
    }

    public function testAddInterest()
    {
        $user = factory(App\User::class)->create([]);
        $game = factory(App\Game::class)->create([]);
        $user->addInterest($game);
        $this->seeInDatabase('game_user', ["game_id" => $game->id, "user_id" => $user->id]);
    }

    public function testRemoveInterest()
    {
        $user = factory(App\User::class)->create([]);
        $game = factory(App\Game::class)->create([]);
        $user->addInterest($game);
        $user->removeInterest($game);
        $this->missingFromDatabase('game_user', ["game_id" => $game->id, "user_id" => $user->id]);
    }

    public function testHasScheduleRelationship()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->schedule);
    }

    public function testHasSessionsThroughScheduleRelationship()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->sessions);
        $this->assertEquals($user->sessions, $user->schedule->sessions);
    }

    public function testFindByEmail()
    {
        $createdUser = factory(App\User::class)->create([
            'email' => 'test@email.com'
            ]);
        $foundUser = App\User::findByEmail('test@email.com');
        $this->assertEquals($createdUser->id, $foundUser->id);
    }

    public function testHasFriendsRelationship()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->friends);
    }

    public function testAddFriend()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $user1->addFriend($user2);
        $this->seeInDatabase('friends', ['user1_id' => $user1->id, 'user2_id' => $user2->id]);
        $this->seeInDatabase('friends', ['user2_id' => $user2->id, 'user1_id' => $user1->id]);
    }

    public function testRemoveFriend()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $user1->addFriend($user2);
        $user1->removeFriend($user2);
        $this->missingFromDatabase('friends', ['user1_id' => $user1->id, 'user2_id' => $user2->id]);
        $this->missingFromDatabase('friends', ['user2_id' => $user2->id, 'user1_id' => $user1->id]);
    }

    public function testHasFriendz()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $user1->addFriend($user2);
        $this->assertTrue($user1->hasFriend($user2));
        $this->assertTrue($user2->hasFriend($user1));
        $user1->removeFriend($user2);
        $this->assertFalse($user1->hasFriend($user2));
        $this->assertFalse($user2->hasFriend($user1));
    }
}
