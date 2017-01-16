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
    
    public function testHasInterests()
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

    public function testHasSchedule()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->schedule);
    }

    public function testHasSessionsThroughSchedule()
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

    public function testHasFriends()
    {
        $user = factory(App\User::class)->create([]);
        $this->assertNotNull($user->friends);
    }
}
