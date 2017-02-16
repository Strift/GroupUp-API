<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Game;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    public function testHasInterestedUsersRelationship()
    {
    	$game = factory(Game::class)->create([]);
        $this->assertNotNull($game->interestedUsers);
    }

    public function testFindByName()
    {
    	$createGame = factory(Game::class)->create(['name' => 'Overwatch']);
    	$found = Game::findByName('Overwatch');
    	$this->assertEquals($createGame->id, $found->id);
    }
}
