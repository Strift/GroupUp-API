<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class AdminSeederTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testAdministratorRoleSeeded()
    {
        $this->assertDatabaseHas('roles', [
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);
    }

    public function testAdminUserSeeded()
    {
        $this->assertDatabaseHas('users', ['email' => 'admin@group-up.com']);
    }

    public function testAdminUserHasAdminRole()
    {
        $this->assertTrue(User::first()->hasRole('administrator'));
    }
}
