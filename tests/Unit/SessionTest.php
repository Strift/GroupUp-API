<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Game;
use App\Session;

class SessionTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasGame()
    {
    	$user = factory(User::class)->create([]);
    	$game = factory(Game::class)->create([]);
    	$session = factory(Session::class)->create(['schedule_id' => $user->schedule->id, 'game_id' => $game->id]);
        $this->assertNotNull($session->game);
    }

    public function testIsDeletedOnScheduleDeletion()
    {
    	$user = factory(User::class)->create([]);
    	$game = factory(Game::class)->create([]);
    	$session = factory(Session::class)->create(['schedule_id' => $user->schedule->id, 'game_id' => $game->id]);
    	$session_id = $session->id;
    	$this->assertDatabaseHas('sessions', ['id' => $session_id]);
    	$user->schedule->delete();
    	$this->assertDatabaseMissing('sessions', ['id' => $session_id]);
    }
}
