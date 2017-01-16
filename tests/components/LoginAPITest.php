<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginAPITest extends TestCase
{
	use DatabaseMigrations;

    public function testLoginWithEmail()
    {
    	$password = 'secret';
        $user = factory(App\User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt($password)]);

        $this->json('POST', 
                    '/api/login',
                    ['email' => $user->email, 'password' => $password],
                    [],
                    ['HTTP_Accept' => 'application/json'])
            ->seeJsonStructure([
                'errors',
                'data' => [
                    'id', 
                    'username', 
                    'email',
                    'api_token'
                    ]
                ])
            ->seeJson([
                'errors' => false,
                'username' => $user->username,
                'email' => $user->email,
                'api_token' => $user->api_token
                ])
            ->seeStatusCode(200);
    }

    public function testLoginWithUsername()
    {
        $password = 'secret';
        $user = factory(App\User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt($password)]);

        $this->json('POST', 
                    '/api/login',
                    ['username' => $user->username, 'password' => $password],
                    [],
                    ['HTTP_Accept' => 'application/json'])
            ->seeJsonStructure([
                'errors',
                'data' => [
                    'id', 
                    'username', 
                    'email',
                    'api_token'
                    ]
                ])
            ->seeJson([
                'errors' => false,
                'username' => $user->username,
                'email' => $user->email,
                'api_token' => $user->api_token
                ])
            ->seeStatusCode(200);
    }

    public function testLoginWithWrongCredentials()
    {
    	$user = factory(App\User::class)->create(['username' => 'Strift', 'email' => 'strift@email.com', 'password' => bcrypt('goodpassword')]);

        $this->json('POST', 
                    '/api/login',
                    ['email' => $user->email, 'password' => 'wrongpassword'],
                    [],
                    ['HTTP_Accept' => 'application/json'])
            ->seeJsonStructure([
                'errors',
                'data' => [
                    'email'
                    ]
                ])
            ->seeJson([
                'errors' => true
                ]);
    }
}
