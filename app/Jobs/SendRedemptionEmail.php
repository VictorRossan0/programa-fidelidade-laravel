<?php

/**
 * SendRedemptionEmail Job
 *
 * Envia e-mail de confirmação de resgate para o cliente.
 */

namespace App\Jobs;

use App\Models\Client;
use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardRedeemedMail;

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
        $point = $this->client->points()->first();
        $balance = $point?->amount ?? 0;
        Mail::to($this->client->email)
            ->send(new RewardRedeemedMail($this->client, $this->reward, $balance));
    }
}
