<?php

namespace App\Events;

use App\Models\Scheduling;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SchedulingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $schedule;

    /**
     * Create a new event instance.
     */
    public function __construct(Scheduling $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['schedules']; //canal público
    }

    public function broadcastAs()
    {
        return 'scheduling.created';
    }
}