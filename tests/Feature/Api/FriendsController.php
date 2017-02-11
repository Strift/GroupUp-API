<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class FriendAPITest extends TestCase
{
	use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testAdminCanViewAnyoneFriends()
    {
    	$admin = User::findByEmail('admin@group-up.com');
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $user1->addFriend($user2);
        $this->json('GET',
                    'api/friends/' . $user1->id . '?api_token=' . $admin->api_token)
            ->assertJson([
                'errors' => false,
                'data' => [/* Unsupported in Laravel 5.4
                	'*' => ['id', 'username']
                	*/]
                ])
			->assertStatus(200);
    }

    public function testUserCanViewHisFriends()
    {
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $user1->addFriend($user2);
        $this->json('GET',
                    'api/friends/' . $user1->id . '?api_token=' . $user1->api_token)
            ->assertJson([
                'errors' => false,
                'data' => [/* Unsupported in Laravel 5.4
                	'*' => ['id', 'username']
                	*/]
                ])
			->assertStatus(200);
    }

    public function testUserCanAddFriend()
    {
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $this->json('POST',
                    'api/friends/' . $user1->id . '?api_token=' . $user1->api_token,
                    ['username' => $user2->username])
            ->assertJson([
                'errors' => false,
                'data' => [
                    'id' => $user2->id,
                    'username' => $user2->username
                    ]
                ])
            ->assertStatus(200);
    }
}
