<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;

use App\User;

class LoginAPITest extends TestCase
{
	use DatabaseMigrations;

    public function testLoginWithEmail()
    {
    	$password = 'secret';
        $user = factory(User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt($password)]);

        $this->json('POST', 
                    '/api/login',
                    ['email' => $user->email, 'password' => $password],
                    ['HTTP_Accept' => 'application/json'])
            ->assertJson([
                'errors' => false,
                'data' => [
	                'username' => $user->username,
	                'email' => $user->email,
	                'api_token' => $user->api_token
	                ]
                ])
            ->assertStatus(200);
    }

    public function testLoginWithUsername()
    {
        $password = 'secret';
        $user = factory(User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt($password)]);

        $this->json('POST', 
                    '/api/login',
                    ['username' => $user->username, 'password' => $password],
                    ['HTTP_Accept' => 'application/json'])
            ->assertJson([
                'errors' => false,
                'data' => [
	                'username' => $user->username,
	                'email' => $user->email,
	                'api_token' => $user->api_token
	                ]
                ])
            ->assertStatus(200);
    }

    public function testLoginWithWrongCredentials()
    {
    	$user = factory(User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt('goodpassword')]);

        $this->json('POST', 
                    '/api/login',
                    ['email' => $user->email, 'password' => 'wrongpassword'],
                    ['HTTP_Accept' => 'application/json'])
            ->assertJson([
                'errors' => true
                ])
            ->assertStatus(422);
    }

    public function testFailedLoginTooManyTimes()
    {
        $response = null;
        for ($i = 0; $i < 60; $i++)
        {
        	$response = $this->json('POST', '/api/login', ['email' => 'wrong@email.com', 'password' => 'wrongpassword']);
        }
        $response->assertJson([
                'errors' => true
                ])
        	->assertStatus(429);
    }
}
