<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class GamesControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanList()
    {
    	$user = factory(User::class)->create([]);
        $this->get('api/games?api_token=' . $user->api_token)
            ->assertJson([
                'errors' => false,
                'data' => []
                ])
            ->assertStatus(200);
    }
}
