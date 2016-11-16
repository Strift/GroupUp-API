<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseMigrations;
    
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
}
