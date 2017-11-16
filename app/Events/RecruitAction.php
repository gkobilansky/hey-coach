<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Recruit;

class RecruitAction
{
    private $recruit;
    private $action;

    use InteractsWithSockets, SerializesModels;

    public function getRecruit()
    {
        return $this->recruit;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * RecruitAction constructor.
     * @param Recruit $recruit
     * @param $action
     */
    public function __construct(Recruit $recruit, $action)
    {
        $this->recruit = $recruit;
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
