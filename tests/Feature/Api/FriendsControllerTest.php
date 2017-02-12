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
                    'api/users/' . $user1->id . '/friends?api_token=' . $admin->api_token)
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
                    'api/users/' . $user1->id . '/friends?api_token=' . $user1->api_token)
            ->assertJson([
                'errors' => false,
                'data' => [/* Unsupported in Laravel 5.4
                	'*' => ['id', 'username']
                	*/]
                ])
			->assertStatus(200);
    }

    public function testUserCanAdd()
    {
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $this->json('POST',
                    'api/users/' . $user1->id . '/friends?api_token=' . $user1->api_token,
                    ['username' => $user2->username])
            ->assertJson([
                'errors' => false,
                'data' => [
                    'username' => $user2->username
                    ]
                ])
            ->assertStatus(200);
    }

    public function testUserCannotAddWithWrongUsername()
    {
        $user1 = factory(User::class)->create([]);
        $this->json('POST',
                    'api/users/' . $user1->id . '/friends?api_token=' . $user1->api_token,
                    ['username' => 'wrongusername'])
            ->assertJson([
                'errors' => true,
                'data' => []
                ])
            ->assertStatus(422);
    }

    public function testUserCanRemove()
    {
        $user1 = factory(User::class)->create([]);
        $user2 = factory(User::class)->create([]);
        $user1->addFriend($user2);
        $this->delete('api/users/' . $user1->id . '/friends?api_token=' . $user1->api_token,
                    ['username' => $user2->username])
            ->assertJson([
                'errors' => false,
                'data' => [
                    'username' => $user2->username
                    ]
                ])
            ->assertStatus(200);
    }

    public function testUserCannotRemoveWithWrongUsername()
    {
        $user1 = factory(User::class)->create([]);
        $this->delete('api/users/' . $user1->id . '/friends?api_token=' . $user1->api_token,
                    ['username' => 'wrongusername'])
            ->assertJson([
                'errors' => true,
                'data' => []
                ])
            ->assertStatus(422);
    }
}
