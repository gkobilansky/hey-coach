<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Athlete;

class AthleteAction
{
    private $athlete;
    private $action;

    use InteractsWithSockets, SerializesModels;

    /**
     * @return mixed
     */
    public function getAthlete()
    {
        return $this->athlete;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * AthleteAction constructor.
     * @param Athlete $athlete
     * @param $action
     */
    public function __construct(Athlete $athlete, $action)
    {
        $this->athlete = $athlete;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
