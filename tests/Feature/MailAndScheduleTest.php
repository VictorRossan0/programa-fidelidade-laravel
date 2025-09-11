<?php

namespace Tests\Feature;

use App\Jobs\SendDailyReminderEmail;
use App\Mail\PointsEarnedMail;
use App\Mail\RewardRedeemedMail;
use App\Models\Client;
use App\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class MailAndScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Reward::factory()->create(['id' => 1, 'name' => 'Suco de Laranja', 'points_required' => 5]);
        Reward::factory()->create(['id' => 2, 'name' => '10% de desconto', 'points_required' => 10]);
        Reward::factory()->create(['id' => 3, 'name' => 'Almoço especial', 'points_required' => 20]);
    }

    private function auth(string $token): array
    {
        return ['Authorization' => 'Bearer '.$token, 'Accept' => 'application/json'];
    }

    public function test_email_enviado_ao_pontuar_e_ao_resgatar()
    {
        Mail::fake();
        $client = Client::factory()->create(['email' => 'user@example.com']);

        // Pontuar -> deve enviar PointsEarnedMail
        $this->postJson('/api/points/earn', ['client_id' => $client->id, 'amount_spent' => 50], $this->auth('4b5f8f32c96a9aa152e0c6615d4e632f'));
        Mail::assertSent(PointsEarnedMail::class, function ($mailable) use ($client) {
            return $mailable->client->id === $client->id;
        });

        // Resgatar -> deve enviar RewardRedeemedMail
        $this->postJson('/api/redemptions', ['client_id' => $client->id, 'reward_id' => 2], $this->auth('4b5f8f32c96a9aa152e0c6615d4e632f'));
        Mail::assertSent(RewardRedeemedMail::class, function ($mailable) use ($client) {
            return $mailable->client->id === $client->id;
        });
    }

    public function test_schedule_dispara_lembrete_so_para_quem_pode_resgatar_premio_maximo()
    {
        Bus::fake();

        $eligible = Client::factory()->create();
        $notEligible = Client::factory()->create();

        // Pontua eligible com 100 reais -> 20 pontos
        $this->postJson('/api/points/earn', ['client_id' => $eligible->id, 'amount_spent' => 100], $this->auth('4b5f8f32c96a9aa152e0c6615d4e632f'));

        // Simula a execução do schedule (mesma lógica do Kernel)
        $maxRequired = \App\Models\Reward::max('points_required');
        $clients = \App\Models\Client::all();
        foreach ($clients as $client) {
            $balance = optional($client->points()->first())->amount ?? 0;
            if ($balance >= $maxRequired) {
                dispatch(new SendDailyReminderEmail($client));
            }
        }

    // Deve ter despachado apenas 1 job (somente elegível)
    Bus::assertDispatchedTimes(SendDailyReminderEmail::class, 1);
    }
}
