<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Job responsável por enviar o e-mail de confirmação de resgate de prêmio.
 * Executado de forma assíncrona pela fila do Laravel.
 */
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
        // Envia o e-mail de confirmação de resgate de prêmio
        $balance = $this->client->points->amount ?? 0;
        Mail::to($this->client->email)
            ->send(new \App\Mail\RewardRedeemedMail($this->client, $this->reward, $balance));
    }
}
