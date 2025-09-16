<?php

/**
 * SendPointsEmail Job
 *
 * Envia e-mail de confirmação de pontos ganhos para o cliente.
 */

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PointsEarnedMail;

/**
 * Job responsável por enviar o e-mail de confirmação de pontos ganhos.
 * Executado de forma assíncrona pela fila do Laravel.
 */
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
        // Envia o e-mail de confirmação de pontos ganhos
        $point = $this->client->points()->first();
        $balance = $point?->amount ?? 0;
        Mail::to($this->client->email)
            ->send(new PointsEarnedMail($this->client, $this->points, $balance));
    }
}
