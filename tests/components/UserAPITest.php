<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAPITest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testAdminUserCanList()
    {
        $user = App\User::findByEmail('admin@group-up.com');
        $this->get('api/users?api_token=' . $user->api_token)
            ->seeJsonStructure([
                'errors',
                'data' => [
                    '*' => ['id', 'username', 'email']
                    ]
                ])
            ->seeStatusCode(200);
    }

    public function testStandardUserCannotList()
    {
        $user = factory(App\User::class)->create([]);
        $this->get('api/users?api_token=' . $user->api_token)
            ->seeStatusCode(403);
    }

    public function testAdminUserCanView()
    {
        $adminUser = App\User::findByEmail('admin@group-up.com');
        $user = factory(App\User::class)->create();
        $this->get('api/users/' . $user->id . '?api_token=' . $adminUser->api_token)
            ->seeJsonStructure([
                'errors',
                'data' => ['id', 'username', 'email']
                ])
            ->seeStatusCode(200);
    }

    public function testUserCanViewHimself()
    {
        $user = factory(App\User::class)->create([]);
        $this->get('api/users/' . $user->id . '?api_token=' . $user->api_token)
            ->seeJsonStructure([
                'errors',
                'data' => ['id', 'username', 'email']
                ])
            ->seeStatusCode(200);
    }

    public function testUserCannotViewOthers()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $this->get('api/users/' . $user1->id . '?api_token=' . $user2->api_token)
            ->seeStatusCode(403);
    }

    public function testUserCanDeleteHimself()
    {
        $user = factory(App\User::class)->create([]);
        $this->delete('api/users/' . $user->id . '?api_token=' . $user->api_token)
            ->seeStatusCode(200);
    }

    public function testUserCannotDeleteOthers()
    {
        $user1 = factory(App\User::class)->create([]);
        $user2 = factory(App\User::class)->create([]);
        $this->delete('api/users/' . $user1->id . '?api_token=' . $user2->api_token)
            ->seeStatusCode(403);
    }
}
