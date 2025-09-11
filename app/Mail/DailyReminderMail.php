<?php
/**
 * DailyReminderMail
 *
 * Mailable do lembrete diário para clientes elegíveis.
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Client;

// Classe responsável pelo e-mail de lembrete diário para o cliente.
class DailyReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function build()
    {
        return $this->subject('✨ Você pode resgatar o prêmio máximo!')
            ->markdown('emails.reminder');
    }
}
