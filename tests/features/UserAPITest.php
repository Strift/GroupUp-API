<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAPITest extends TestCase
{
    use DatabaseMigrations;

    public function testDefault()
    {
    	$user = factory(App\User::class)->create([]);
    	$this->actingAs($user, 'api')
    		->get('api/user')
    		->seeJsonStructure([
    			"id", "name", "email"
    			]);
    }
}
