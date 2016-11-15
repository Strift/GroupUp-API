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
}
