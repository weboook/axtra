<?php

namespace App\Events;

use App\Models\User;
use App\Models\Level;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLevelUp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $newLevel;
    public $reason;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Level $newLevel, ?string $reason = null)
    {
        $this->user = $user;
        $this->newLevel = $newLevel;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user->id),
        ];
    }
}
