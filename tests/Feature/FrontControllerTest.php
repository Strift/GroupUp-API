<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class FrontControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testAccountVerification()
    {
    	$user = factory(User::class)->create([]);
    	$this->get('/verification/?token=' . $user->verification_token)
    		->assertStatus(200);
    }

    public function testAccountVerificationWithWrongToken()
    {
    	$this->get('/verification/?token=wrongtoken')
    		->assertStatus(422);
    }
}
