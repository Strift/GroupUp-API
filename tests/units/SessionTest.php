<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasGame()
    {
    	$game = factory(App\Game::class)->create([]);
    	$session = factory(App\Session::class)->create(['game_id' => $game->id]);
        $this->assertNotNull($session->game);
    }
}
