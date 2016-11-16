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
        $this->actingAs($user, 'api')
            ->get('api/users')
            ->seeJsonStructure([
                '*' => ['id', 'name', 'email']
                ]);
    }
}
