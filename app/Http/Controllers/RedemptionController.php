<?php
/**
 * RedemptionController
 *
 * Gerencia o resgate de prêmios (005): valida saldo, debita pontos, cria o
 * registro de resgate e dispara o e-mail correspondente.
 */

namespace App\Http\Controllers;

use App\Http\Requests\RedeemRewardRequest;
use App\Models\Client;
use App\Models\Redemption;
use App\Models\Reward;
use App\Jobs\SendRedemptionEmail;

class RedemptionController extends Controller
{
    /**
     * Realiza o resgate de um prêmio (005), desconta pontos e dispara e-mail.
     */
    public function store(RedeemRewardRequest $request)
    {
    $client = Client::findOrFail($request->input('client_id'));
    $reward = Reward::findOrFail($request->input('reward_id'));
    $point = $client->points()->first();

        if (!$point || $point->amount < $reward->points_required) {
            return response()->json(['error' => 'Saldo insuficiente'], 400);
        }

        $point->decrement('amount', $reward->points_required);

        $redemption = Redemption::create([
            'client_id' => $client->id,
            'reward_id' => $reward->id
        ]);

        dispatch(new SendRedemptionEmail($client, $reward));

        // Saldo restante após o resgate
        $point->refresh();
        $remaining = $point->amount;

        // Retorna 201 Created com Location e saldo restante
        return response()
            ->json([
                'id' => $redemption->id,
                'client_id' => $redemption->client_id,
                'reward_id' => $redemption->reward_id,
                'remaining_balance' => $remaining,
                'created_at' => $redemption->created_at,
            ], 201)
            ->header('Location', url('/api/redemptions/'.$redemption->id));
    }
}
