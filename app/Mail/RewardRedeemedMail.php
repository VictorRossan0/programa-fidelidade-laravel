<?php
/**
 * RewardRedeemedMail
 *
 * Mailable de confirmação do resgate, com detalhes do prêmio e saldo.
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Client;

// Classe responsável pelo e-mail de confirmação de resgate de prêmio.
class RewardRedeemedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $reward;
    public $balance;

    public function __construct(Client $client, $reward, $balance)
    {
        $this->client = $client;
        $this->reward = $reward;
        $this->balance = $balance;
    }

    public function build()
    {
        return $this->subject('🏆 Prêmio resgatado com sucesso!')
            ->markdown('emails.reward');
    }
}
