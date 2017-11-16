<?php

namespace App\Listeners;

use App\Events\RecruitAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\RecruitActionNotification;

class RecruitActionNotify
{
    /**
     * Action the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RecruitAction  $event
     * @return void
     */
    public function handle(RecruitAction $event)
    {
        $lead = $event->getRecruit();
        $action = $event->getAction();
        $lead->user->notify(new RecruitActionNotification(
            $lead,
            $action
        ));
    }
}
