<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasInterestedUsers()
    {
        $game = factory(App\Game::class)->create([]);
        $this->assertNotNull($game->interestedUsers);
    }
}
