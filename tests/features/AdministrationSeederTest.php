<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdministrationSeederTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
    	parent::setUp();
    	$this->artisan('db:seed');
    }

    public function testAdministratorRoleSeeded()
    {
        $this->seeInDatabase('roles', [
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);
    }

    public function testAdminUserSeeded()
    {
    	$this->seeInDatabase('users', ['email' => 'admin@group-up.com']);
    }

    public function testAdminUserHasAdminRole()
    {
        $this->assertTrue(App\User::first()->hasRole('administrator'));
    }
}
