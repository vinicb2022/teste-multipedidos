<?php

namespace App\Jobs;

use App\Events\AnalysisStatusUpdated;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessAnalysis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected int $analysisId;

    public function __construct(User $user, int $analysisId)
    {
        $this->user = $user;
        $this->analysisId = $analysisId;
    }

    public function handle()
    {
        try {
            $resultData = ['url' => '/results/' . $this->analysisId, 'accuracy' => '95%'];

            broadcast(new AnalysisStatusUpdated($this->user, $this->analysisId, 'Concluído', $resultData));

        } catch (Throwable $e) {
            broadcast(new AnalysisStatusUpdated($this->user, $this->analysisId, 'Falhou', ['error' => $e->getMessage()]));
        }
    }
}