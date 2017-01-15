<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginAPITest extends TestCase
{
	use DatabaseMigrations;

    public function testLogin()
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
                'username' => 'Strift',
                'email' => 'strift@email.com'
                ]);
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
                    'input' => [
                    	'email'
                    	]
                    ]
                ])
            ->seeJson([
                'errors' => true
                ]);
    }
}
