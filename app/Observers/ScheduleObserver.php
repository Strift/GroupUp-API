<?php

namespace App\Observers;

use App\Schedule;

class ScheduleObserver
{
    /**
     * Listen to the Schedule created event.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {
    }

    /**
     * Listen to the Schedule deleting event.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    public function deleting(Schedule $schedule)
    {
        $schedule->sessions->each(function ($item, $key) {
            $item->delete();
        });
    }
}