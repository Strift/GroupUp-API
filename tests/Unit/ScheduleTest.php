<?php

namespace Tests\Unit;

use Tests\BrowserKitTest as TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class ScheduleTest extends TestCase
{
	use DatabaseMigrations;

    public function testIsDeletedOnUserDeletion()
    {
    	$user = factory(User::class)->create([]);
    	$schedule_id = $user->schedule->id;
    	$this->seeInDatabase('schedules', ["id" => $schedule_id]);
    	$user->delete();
    	$this->missingFromDatabase('schedules', ['id' => $schedule_id]);
    }
}
