<?php

namespace App\Events;

use App\Models\Discussion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscussionCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion->load('user');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('course.' . $this->discussion->course_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->discussion->id,
            'content' => $this->discussion->content,
            'user' => $this->discussion->user->name,
        ];
    }
}
