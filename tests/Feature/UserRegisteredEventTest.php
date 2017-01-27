<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $user = factory(App\User::class)->create([]);
        event(new UserRegistered($user));
        // Assertion
        Event::assertDispatched(UserRegistered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    public function testSendRegistrationMail()
    {
        // Faking mails
        Mail::fake();
        // Firing event
        $user = factory(App\User::class)->create([]);
        event(new UserRegistered($user));
        // Mail assertion
        Mail::assertSent(UserRegistration::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }
}
