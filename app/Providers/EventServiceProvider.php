<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AthleteAction' => [
            'App\Listeners\athleteActionNotify',
            'App\Listeners\athleteActionLog',
        ],
         'App\Events\TaskAction' => [
            'App\Listeners\TaskActionNotify',
            'App\Listeners\TaskActionLog',
         ],
        'App\Events\RecruitAction' => [
            'App\Listeners\RecruitActionNotify',
            'App\Listeners\RecruitActionLog',
        ],
        'App\Events\NewComment' => [
            'App\Listeners\NotiftyMentionedUsers'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @internal param DispatcherContract $events
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
