<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPointsEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $client;
    protected $points;

    public function __construct(Client $client, int $points)
    {
        $this->client = $client;
        $this->points = $points;
    }

    public function handle()
    {
        // Implement email sending logic here
    }
}
