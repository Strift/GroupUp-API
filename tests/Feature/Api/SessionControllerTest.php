<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Game;

class SessionsControllerTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();
		$this->artisan('db:seed');
	}

    public function testUserCanSetHisSession()
    {
        $user = factory(User::class)->create([]);
        $game = Game::findByName('Overwatch');
        $durationInMinutes = 120;
        $this->json('POST',
                    'api/users/' . $user->id . '/sessions?api_token=' . $user->api_token,
                    ['game' => $game->name, 'duration' => $durationInMinutes])
            ->assertJson([
                'errors' => false,
                ])
            ->assertStatus(200);
    }
}
