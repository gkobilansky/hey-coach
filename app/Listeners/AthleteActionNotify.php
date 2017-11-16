<?php

namespace App\Listeners;

use App\Events\AthleteAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\AthleteActionNotification;

class athleteActionNotify
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AthleteAction  $event
     * @return void
     */
    public function handle(AthleteAction $event)
    {
        $athlete = $event->getAthlete();
        $action = $event->getAction();
        
        $athlete->assignedUser->notify(new AthleteActionNotification(
            $athlete,
            $action
        ));
    }
}
