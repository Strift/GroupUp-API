<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterAPIest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanRegister()
    {
        //#call($method, $uri, $parameters, $files, $server, $content, $changeHistory
        $this->json('POST', 
                    '/api/register',
                    ['username' => 'Strift', 'email' => 'strift@email.com', 'password' => 'secret', 'password_confirmation' => 'secret'],
                    [],
                    ['HTTP_Accept' => 'application/json'])
            ->seeJsonStructure([
                'errors',
                'data' => [
                    'id', 
                    'username', 
                    'email'
                    ]
                ])
            ->seeJson([
                'errors' => false,
                'username' => 'Strift',
                'email' => 'strift@email.com'
                ]);
    }
}
