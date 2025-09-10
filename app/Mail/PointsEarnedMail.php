<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Classe responsável pelo e-mail de confirmação de pontos ganhos.
class PointsEarnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $points;
    public $balance;

    public function __construct(Client $client, $points, $balance)
    {
        $this->client = $client;
        $this->points = $points;
        $this->balance = $balance;
    }

    public function build()
    {
        return $this->subject('🎉 Você ganhou pontos no programa de fidelidade!')
                    ->markdown('emails.points');
    }
}
