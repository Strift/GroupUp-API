<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Events\UserRegistered;

class UserRegisteredEventTest extends TestCase
{
	use DatabaseMigrations;

    public function testIsRegistered()
    {
    	// Faking events
    	Event::fake();
    	// Firing event
    	$user = factory(App\User::class)->create([]);
        event(new UserRegistered($user));
        // Assertion
        Event::assertFired(UserRegistered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }
}
