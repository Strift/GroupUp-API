<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ScheduleTest extends TestCase
{
	use DatabaseMigrations;

    public function testIsDeletedOnUserDeletion()
    {
    	$user = factory(App\User::class)->create([]);
    	$schedule_id = $user->schedule->id;
    	$this->seeInDatabase('schedules', ["id" => $schedule_id]);
    	$user->delete();
    	$this->missingFromDatabase('schedules', ['id' => $schedule_id]);
    }
}
