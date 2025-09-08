<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRedemptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client;
    protected $reward;

    public function __construct(Client $client, Reward $reward)
    {
        $this->client = $client;
        $this->reward = $reward;
    }

    public function handle()
    {
        // Implement email sending logic here
    }
}
