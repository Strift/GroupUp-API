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
    }

    public function testAdminUserCanList()
    {
        $this->artisan('db:seed');
        $user = App\User::findByEmail('admin@group-up.com');
        $this->get('api/users?api_token=' . $user->api_token)
            ->seeJsonStructure([
                'errors',
                'data' => [
                    '*' => ['id', 'name', 'email']
                    ]
                ]);
    }

    public function testStandardUserCannotList()
    {
        $user = factory(App\User::class)->create([]);
        $this->get('api/users?api_token=' . $user->api_token)
            ->seeStatusCode(403);
    }

    public function testAdminUserCanView()
    {
        $this->artisan('db:seed');
        $adminUser = App\User::findByEmail('admin@group-up.com');
        $user = factory(App\User::class)->create();
        $this->get('api/users/' . $user->id . '?api_token=' . $adminUser->api_token)
            ->seeJsonStructure(['id', 'name', 'email']);
    }

    public function testUserCanViewHimself()
    {
        $user = factory(App\User::class)->create([]);
        $this->get('api/users/' . $user->id . '?api_token=' . $user->api_token)
            ->seeJsonStructure(['id', 'name', 'email']);
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
