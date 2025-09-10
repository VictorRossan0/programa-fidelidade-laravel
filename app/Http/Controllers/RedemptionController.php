<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedeemRewardRequest;
use App\Models\Client;
use App\Models\Redemption;
use App\Models\Reward;
use App\Jobs\SendRedemptionEmail;

// Controller responsável pelo resgate de prêmios pelos clientes.
class RedemptionController extends Controller
{
    // Realiza o resgate de um prêmio, desconta pontos e dispara e-mail.
    public function store(RedeemRewardRequest $request)
    {
    $client = Client::findOrFail($request->input('client_id'));
    $reward = Reward::findOrFail($request->input('reward_id'));
        $point = $client->points->first();

        if (!$point || $point->amount < $reward->points_required) {
            return response()->json(['error' => 'Saldo insuficiente'], 400);
        }

        $point->decrement('amount', $reward->points_required);

        $redemption = Redemption::create([
            'client_id' => $client->id,
            'reward_id' => $reward->id
        ]);

        dispatch(new SendRedemptionEmail($client, $reward));

        return response()->json($redemption, 201);
    }
}
