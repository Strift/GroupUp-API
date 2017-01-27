<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $admin = App\User::findByEmail('admin@group-up.com');
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $user1->addFriend($user2);
        $this->json(
            'GET',
            'api/friends/' . $user1->id . '?api_token=' . $admin->api_token
        )
            ->seeJsonStructure([
                'errors',
                'data' => [
                    '*' => ['id', 'username']]
                ])
            ->seeStatusCode(200);
    }

    public function testUserCanViewHisFriends()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $user1->addFriend($user2);
        $this->json(
            'GET',
            'api/friends/' . $user1->id . '?api_token=' . $user1->api_token
        )
            ->seeJsonStructure([
                'errors',
                'data' => [
                    '*' => ['id', 'username']]
                ])
            ->seeStatusCode(200);
    }
}
