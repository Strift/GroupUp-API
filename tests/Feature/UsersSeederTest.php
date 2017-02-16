<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UsersSeederTest extends TestCase
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
        $this->assertTrue(User::findByEmail('admin@group-up.com')->hasRole('administrator'));
    }

    public function testDefaultUsersSeeded()
    {
    	$this->assertDatabaseHas('users', ['username' => 'Strift', 'password' => 'secret']);
    	$this->assertDatabaseHas('users', ['username' => 'MOPZ', 'password' => 'azerty']);
    	$this->assertDatabaseHas('users', ['username' => 'quentin', 'password' => 'quentin']);
    }
}
