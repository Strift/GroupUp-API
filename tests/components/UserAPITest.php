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
                '*' => ['id', 'name', 'email']
                ]);
    }

    public function testStandardUserCannotList()
    {
        $user = factory(App\User::class)->create([]);
        $this->get('api/users?api_token=' . $user->api_token)
            ->seeStatusCode(403);
    }
}
