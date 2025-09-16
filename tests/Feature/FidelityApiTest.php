<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FidelityApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Cria prêmios fixos conforme PDF
        Reward::factory()->create(['id' => 1, 'name' => 'Suco de Laranja', 'points_required' => 5]);
        Reward::factory()->create(['id' => 2, 'name' => '10% de desconto', 'points_required' => 10]);
        Reward::factory()->create(['id' => 3, 'name' => 'Almoço especial', 'points_required' => 20]);
    }

    private function authHeaders(string $token): array
    {
        return ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'];
    }

    public function test_001_cadastrar_cliente()
    {
        $payload = ['name' => 'João Teste', 'email' => 'joao@example.com'];
        $res = $this->postJson('/api/clients', $payload, $this->authHeaders('4b5f8f32c96a9aa152e0c6615d4e632f'));
        $res->assertCreated()->assertJsonFragment(['email' => 'joao@example.com']);
    }

    public function test_002_buscar_cliente()
    {
        $client = Client::factory()->create();
        $res = $this->getJson('/api/clients/' . $client->id, $this->authHeaders('117ae721e424e7f819893edb2c0c5fd6'));
        $res->assertOk()->assertJsonFragment(['id' => $client->id]);
    }

    public function test_003_listar_clientes()
    {
        Client::factory()->count(2)->create();
        $res = $this->getJson('/api/clients', $this->authHeaders('117ae721e424e7f819893edb2c0c5fd6'));
        $res->assertOk();
    }

    public function test_006_pontuar_cliente_minimo_5()
    {
        $client = Client::factory()->create();
        $res = $this->postJson('/api/points/earn', ['client_id' => $client->id, 'amount_spent' => 4], $this->authHeaders('3b7d6e2cb06ba79a9c9744f8e256a39e'));
        $res->assertStatus(422);

        $res2 = $this->postJson('/api/points/earn', ['client_id' => $client->id, 'amount_spent' => 50], $this->authHeaders('3b7d6e2cb06ba79a9c9744f8e256a39e'));
        $res2->assertOk();
    }

    public function test_004_consultar_saldo_e_resgates()
    {
        $client = Client::factory()->create();
        // Pontua 50 -> 10 pontos
        $this->postJson('/api/points/earn', ['client_id' => $client->id, 'amount_spent' => 50], $this->authHeaders('4b5f8f32c96a9aa152e0c6615d4e632f'));
        $res = $this->getJson('/api/clients/' . $client->id . '/balance', $this->authHeaders('117ae721e424e7f819893edb2c0c5fd6'));
        $res->assertOk()->assertJsonFragment(['saldo' => 10]);
    }

    public function test_005_resgatar_premio_com_saldo()
    {
        $client = Client::factory()->create();
        // 50 -> 10 pontos
        $this->postJson('/api/points/earn', ['client_id' => $client->id, 'amount_spent' => 50], $this->authHeaders('4b5f8f32c96a9aa152e0c6615d4e632f'));
        $res = $this->postJson('/api/redemptions', ['client_id' => $client->id, 'reward_id' => 2], $this->authHeaders('4b5f8f32c96a9aa152e0c6615d4e632f'));
        $res->assertCreated()->assertJsonFragment(['reward_id' => 2, 'remaining_balance' => 0]);
        $this->assertTrue($res->headers->has('Location'));
    }
}
