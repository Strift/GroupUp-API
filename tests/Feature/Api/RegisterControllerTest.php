<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Mail;

use App\Events\UserRegistered;

class RegisterAPIest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanRegister()
    {
        $this->expectsEvents(UserRegistered::class);
        // JSON request
        $username = 'Strift';
        $email = 'strift@email.com';
        $password = 'secret';
        //#call($method, $uri, $parameters, $files, $server, $content, $changeHistory
        $this->json('POST', 
                    '/api/register',
                    ['username' => $username, 'email' => $email, 'password' => $password, 'password_confirmation' => $password],
                    [],
                    ['HTTP_Accept' => 'application/json'])
            ->assertJson([
                'errors' => false,
                'data' => [
	                'username' => $username,
	                'email' => $email
                	]
                ])
            ->assertStatus(200);
    }
}
