<?php

namespace App\Listeners;

use App\Events\RecruitAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Recruit;

class RecruitActionLog
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
        switch ($event->getAction()) {
            case 'created':
                $text = __(':title was created by :creator and assigned to :assignee', [
                    'title' => $event->getRecruit()->title,
                    'creator' => $event->getRecruit()->creator->name,
                    'assignee' => $event->getRecruit()->user->name
                ]);
                break;
            case 'updated_status':
                $text = __('Recruit was completed by :username', [
                    'username' => Auth()->user()->name,
                ]);
                break;
            case 'updated_deadline':
                $text = __(':username updated the deadline for this recruit', [
                    'username' => Auth()->user()->name,
                ]);
                break;
            case 'updated_assign':
                $text = __(':username assigned recruit to :assignee', [
                    'username' => Auth()->user()->name,
                    'assignee' => $event->getRecruit()->user->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' => Recruit::class,
                'source_id' =>  $event->getRecruit()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
