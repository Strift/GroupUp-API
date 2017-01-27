<?php

namespace Tests\Unit;

use Tests\BrowserKitTest as TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Game;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasInterestedUsers()
    {
    	$game = factory(Game::class)->create([]);
        $this->assertNotNull($game->interestedUsers);
    }
}
