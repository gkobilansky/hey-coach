<?php

namespace App\Listeners;

use App\Events\AthleteAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use App\Models\Athlete;
use Lang;

class athleteActionLog
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

        switch ($event->getAction()) {
            case 'created':
                $text = __('Athlete :name from :company was assigned to :assignee', [
                    'name' => $athlete->name,
                    'company' => $athlete->company_name,
                    'assignee' => $athlete->AssignedUser->name,
                ]);
                break;
            case 'updated_assign':
                $text =  __(':username assigned athlete to :assignee', [
                    'username' => Auth()->user()->name,
                    'assignee' => $athlete->AssignedUser->name,
                ]);
                break;
            default:
                break;
        }
    
        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' => Athlete::class,
                'source_id' =>  $athlete->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
