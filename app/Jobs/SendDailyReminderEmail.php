<?php

/**
 * SendDailyReminderEmail Job
 *
 * Envia e-mail diário para clientes com saldo suficiente para o prêmio máximo.
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReminderMail;

/**
 * Job responsável por enviar o e-mail de lembrete diário para o cliente.
 * Executado de forma assíncrona pela fila do Laravel.
 */
class SendDailyReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        // Envia o e-mail de lembrete diário
        Mail::to($this->client->email)
            ->send(new DailyReminderMail($this->client));
    }
}
