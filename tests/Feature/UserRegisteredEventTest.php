<?php

namespace Tests\Feature;

use Tests\BrowserKitTest as TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Events\UserRegistered;
use App\Mail\UserRegistration;

class UserRegisteredEventTest extends TestCase
{
	use DatabaseMigrations;

    public function testIsRegistered()
    {
    	// Faking events
    	Event::fake();
    	// Firing event
    	$user = factory(User::class)->create([]);
        event(new UserRegistered($user));
        // Assertion
        Event::assertFired(UserRegistered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    public function testSendRegistrationMail()
    {
    	// Faking mails
    	Mail::fake();
    	// Firing event
    	$user = factory(User::class)->create([]);
        event(new UserRegistered($user));
    	// Mail assertion
    	Mail::assertSent(UserRegistration::class, function ($mail) use ($user) {
            return ($mail->hasTo($user) and $mail->user->id === $user->id);
        });
    }
}
