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
    	$this->assertDatabaseHas('users', ['username' => 'Strift']);
    	$this->assertDatabaseHas('users', ['username' => 'MOPZ']);
    	$this->assertDatabaseHas('users', ['username' => 'quentin']);
    }

    public function testDefaultUsersHaveSchedule()
    {
        $this->assertDatabaseHas('schedules', ['user_id' => User::findByUsername('Strift')->id]);
        $this->assertDatabaseHas('schedules', ['user_id' => User::findByUsername('MOPZ')->id]);
        $this->assertDatabaseHas('schedules', ['user_id' => User::findByUsername('quentin')->id]);
    }
}
