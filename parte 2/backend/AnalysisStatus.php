<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnalysisStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $analysisId;
    public string $status;
    public ?array $resultData;
    private User $user;

    public function __construct(User $user, int $analysisId, string $status, ?array $resultData = null)
    {
        $this->user = $user;
        $this->analysisId = $analysisId;
        $this->status = $status;
        $this->resultData = $resultData;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'analysis.status.updated';
    }
}