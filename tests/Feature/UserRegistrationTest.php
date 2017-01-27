<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

use App\User;
use App\Events\UserRegistered;
use App\Mail\UserRegistration;

class UserRegisteredEventTest extends TestCase
{
	use DatabaseMigrations;

    public function testEventIsDispatched()
    {
    	Event::fake();
    	// Firing event
    	$user = factory(User::class)->create([]);
        event(new UserRegistered($user));
        // Assertion
        Event::assertDispatched(UserRegistered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    public function testRegistrationMailIsSent()
    {
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
