<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasGame()
    {
    	$user = factory(App\User::class)->create([]);
    	$game = factory(App\Game::class)->create([]);
    	$session = factory(App\Session::class)->create(['schedule_id' => $user->schedule->id, 'game_id' => $game->id]);
        $this->assertNotNull($session->game);
    }

    public function testIsDeletedOnScheduleDeletion()
    {
    	$user = factory(App\User::class)->create([]);
    	$game = factory(App\Game::class)->create([]);
    	$session = factory(App\Session::class)->create(['schedule_id' => $user->schedule->id, 'game_id' => $game->id]);
    	$session_id = $session->id;
    	$this->seeInDatabase('sessions', ['id' => $session_id]);
    	$user->schedule->delete();
    	$this->missingFromDatabase('sessions', ['id' => $session_id]);
    }
}
